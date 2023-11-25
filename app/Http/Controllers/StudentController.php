<?php

namespace App\Http\Controllers;

use App\Events\LeaveSheet;
use App\Exports\AttendanceExport;
use App\Jobs\LeaveSheetJob;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Status;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Jobs\QRcodeGenerationJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Http\Requests\StudentValidationRequest;
use App\Jobs\LoginCreditentials;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentLoginCredentials;
use Excel;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::orderBy('student_name', 'ASC')->get();
        if ($request->ajax()) {
            $allData = DataTables::of($students)->addIndexColumn()->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '"
data-orginal-title="Edit" class="btn btn-primary btn-sm edit editItem">
<i class="fa fa-wrench" aria-hidden="true"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '"
data-orginal-title="Delete" class="btn btn-danger btn-sm delete deleteItem">
<i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                return $btn;
            })
                ->rawColumns(P['action'])->make(true);
            return $allData;
        }
        return view('add_student_details', compact('students'));
    }

    /**
     * store the students details
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|max:25',
            'student_email' => 'required|email|unique:students,student_email',
            'student_contactno' => 'required|min:10|max:10',
            'student_dob' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $studentData = Student::create([
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_dob' => $request->student_dob,
                'student_contactno' => $request->student_contactno,
            ]);
            User::create([
                'name' => $request->student_name,
                'email' => $request->student_email,
                'password' => Hash::make($request->student_dob),
            ]);
            $name = $request->student_name;
            $username = $request->student_email;
            $password = $request->student_dob;
            LoginCreditentials::dispatch($name, $username, $password);
            QrCode::size(300)->format('png')->generate($studentData->student_email, public_path('/students_qrcode/' . $studentData->student_name . '.png'));
            // //QRcodeGenerationJob::dispatch($studentData);
            // return response()->json(['status' => '200', 'msg' => 'QR Code Generated']);
            // //return view('generate',compact('data'));
            return $request->all();
        }
    }

    /**
     * Delete the specific ID
     */
    public function delete($id)
    {
        $email = Student::where('id', '=', $id)->first()->student_email;
        $loginData = User::where('email', $email)->firstOrFail();
        $loginData->delete();
        $data = Student::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Student details deleted'], 200);
    }

    /**
     * Retrieve the data for editing
     */
    public function edit($id)
    {
        $edit_data = Student::findorFail($id);
        return response()->json($edit_data);
    }

    /**
     * Update the data
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edited_student_name' => 'required',
            'edited_student_email' => 'required|email',
            'edited_student_contactno' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $student = Student::findOrFail($id);
            $student->update([
                'student_name' => $request->edited_student_name,
                'student_email' => $request->edited_student_email,
                'student_contactno' => $request->edited_student_contactno,
            ]);

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
    }

    /**
     * Generate the leavesheet
     */
    public function leaveSheet(StudentValidationRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'regno' => 'required|string|min:8',
            'reason' => 'required|min:5'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
            ], 200);
        } else {
            $data = array(
                'name' => $request->name,
                'reason' => $request->reason
            );
            $name = $request->name;
            $reason = $request->reason;
            event(new LeaveSheet($data));
            LeaveSheetJob::dispatch($name, $reason);
            return redirect()->back()->with('msg', 'The leave permission has sent to your incharge');
        }
    }

    /**
     * Put down the attendance for students
     */
    public function putAttendance(Request $request)
    {
        $studentId = Student::where('student_email', $request->status)->get()->value('id');
        $todayDate = Carbon::now()->format('Y-m-d');
        $dataExist = Status::where('student_id', $studentId)->where('date', $todayDate)->where('status', 'Present')->first();
        if ($dataExist === null) {
            $newRecord = Status::where('student_id', $studentId)->first();
            if ($newRecord === null) {
                $status=new Status;
                $status->status="Present";
                $status->student_id=$studentId;
                $status->date=$todayDate;
                $status->save();

                //return response()->json(['message' => "Attendance Inserted/Created"], 200);
                return redirect()->back()->with('present', 'Attendance Inserted');
            } else {
                Status::where('student_id', $studentId)->Where('date', $todayDate)->update(['status' => 'Present']);
                // return response()->json(['message' => "Attendance Inserted"], 200);
                return redirect()->back()->with('present', 'Attendance Inserted');
            }
        } else {
            // return response()->json(['message' => "already presented"], 200);
            return redirect()->back()->with('alreadyPresent', 'You have already presented for today');
        }
    }

    

    public function getStatus()
    {
        $attendanceStatus = DB::table('students')->leftJoin('attendance_status', 'attendance_status.student_id', '=', 'students.id')
            ->selectRaw("student_name,IF(ISNULL(status)=1,'Absent',status) as status,date,attendance_status.id")->orderBy('students.student_name', 'asc')->orderBy('attendance_status.date', 'desc')->get();

        return view('show_attendance', compact('attendanceStatus'));
    }

    public function generate()
    {
        QrCode::size(200)->backgroundColor(255, 255, 255)->format('png')->generate('Mohammed sumhoon J', public_path('/students_qrcode/sample.png'));
        return view('generate');
    }

    public function getTime()
    {
        return Carbon::now()->format('Y-m-d');
    }
    public function exportExcel()
    {
        if (Status::count('id') > 0) {
            return Excel::download(new AttendanceExport, 'attendance_list.xlsx');
        } else {
            return redirect()->back()->with('message', 'There is no data on the table to export as excel sheet');
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function student_dashboard()
    {
        $id=Auth::id();
        $datas=Status::where('student_id',$id)->select('status','date')->get();
        $leaveCount=Status::where('student_id',$id)->where('status','Absent')->count();
        $name=Student::where('id',$id)->get()->value('student_name');
        $dob=Student::where('id',$id)->get()->value('student_dob');
        
        return view('student_dashboard',compact('datas','leaveCount','name','dob'));
    }
    public function scanner()
    {
        return view('scanner');
    }
}
