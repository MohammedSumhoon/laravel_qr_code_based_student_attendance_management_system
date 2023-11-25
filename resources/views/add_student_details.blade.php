<html>

<head>
    <title>Student Registeration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<x-app-layout>
<body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="container">
                        <a class="btn btn-success" href="javascript:void(0)" id="AddStudent" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New Student</a><br><br>
                        <table class="data-table table table-striped table-bordered">
                            <thead style="text-align: center;">
                                <tr style="text-align: center;">
                                    <th>SNo</th>
                                    <th>Student name</th>
                                    <th>Student email</th>
                                    <th>Student Contact No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="modal fade" id="StudentModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="ModalHeading"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="saveform_errList"></ul>
                                        <form id="StudentForm" name="StudentForm" class="form-horizontal" method="POST">
                                            @csrf
                                            <!-- <input type="hidden" name="id" id="id"> -->
                                            <div class="form-group">
                                                Student Name:<br>
                                                <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter student's name" required>
                                            </div><br>
                                            <div class="form-group">
                                                Student EmailID:<br>
                                                <input type="text" class="form-control" id="student_email" name="student_email" placeholder="Enter student's EmailID">
                                            </div><br>
                                            <div class="form-group">
                                                Student Date of Birth:<br>
                                                <input type="date" id="student_dob" name="student_dob">
                                            </div><br>
                                            <div class="form-group">
                                                Student Contact Number:<br>
                                                <input type="text" class="form-control" id="student_contactno" name="student_contactno" placeholder="Enter Student's Contact number">
                                            </div><br>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" style="color:black" name="savebtn" id="save" value="Save">Save</button>
                                                <button type="button" class="btn btn-danger" style="color:black" data-dismiss="modal" id="close">Close</button>
                                            </div><br>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="StudentEditModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalHeading"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="updateform_errList"></ul>
                                        <form id="UpdateStudentForm" name="UpdateStudentForm" class="form-horizontal" method="POST">
                                            @csrf
                                            <input type="hidden" name="update_id" id="update_id">
                                            <div class="form-group">
                                                Student Name:<br>
                                                <input type="text" class="form-control" id="edited_student_name" name="edited_student_name" placeholder="Enter student name">
                                            </div>
                                            <div class="form-group">
                                                Student Email:<br>
                                                <input type="text" class="form-control" id="edited_student_email" name="edited_student_email" placeholder="Enter student email">
                                            </div>
                                            <div class="form-group">
                                                Student Date of Birth:<br>
                                                <input type="date" class="form-control" id="edited_student_dob" name="edited_student_dob" placeholder="Enter Student's Contact number">
                                            </div><br>
                                            <div class="form-group">
                                                Student contact no:<br>
                                                <input type="text" class="form-control" id="edited_student_contactno" name="edited_student_contactno" placeholder="Enter student contact no">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" name="savebtn" id="update" value="Save">Update</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeupdate">Close</button>
                                            </div>
                                        </form>
                                        <div id="success_msg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--layout-->
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{url('students')}}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'student_name',
                            name: 'student_name'
                        },
                        {
                            data: 'student_email',
                            name: 'student_email'
                        },
                        {
                            data: 'student_contactno',
                            name: 'student_contactno'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
                $("#AddStudent").click(function() {
                    $('#StudentModal').modal('show');
                    $('#id').val();
                    $('#StudentForm').trigger("reset");
                    $('#ModalHeading').html('Add New Student');
                });

                $('#save').click(function(e) {
                    e.preventDefault();
                    let table = $('.data-table')
                    $.ajax({
                        data: $('#StudentForm').serialize(),
                        url: "{{url('store_student_details')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.status == 400) {
                                $('#saveform_errList').html("");
                                $('#saveform_errList').addClass('alert alert-danger')
                                $.each(response.errors, function(key, err_values) {
                                    console.log(err_values);
                                    $('#saveform_errList').append('<li>' + err_values + '</li>');
                                });
                            } else {
                                $('.data-table').DataTable().ajax.reload();
                                toastr.success("The Student data has added successfully!!!");
                                $('#StudentModal').modal('hide');
                                $('#StudentForm')[0].reset();
                            }
                        },
                        error: function(data) {
                            console.log('The Error is :', data);
                        }
                    });
                });

                $('body').on('click', '.deleteItem', function() {
                    var student_id = $(this).data("id");
                    console.log(student_id);
                    confirm("Are you sure want to delete this student details!");
                    $.ajax({
                        type: "get",
                        url: "{{url('delete_student_data')}}" + '/' + student_id,
                        success: function(res) {
                            $('.data-table').DataTable().ajax.reload();
                            console.log(res);
                        },
                        error: function(data) {
                            console.log('Error', data);
                        }
                    });
                });

                $('body').on('click', '.editItem', function() {
                    var student_id = $(this).data('id');
                    $.get("{{url('edit_student_data')}}" + "/" + student_id, function(data) {
                        $('#modalHeading').html("Edit Student Data");
                        $('#StudentEditModal').modal('show');
                        $('#update_id').val(data.id);
                        $('#edited_student_name').val(data.student_name);
                        $('#edited_student_email').val(data.student_email);
                        $('#edited_student_contactno').val(data.student_contactno);
                        $('#edited_student_dob').val(data.student.dob);
                    });
                });

                $('#update').click(function(e) {
                    e.preventDefault();
                    var updated_student_id = $('#update_id').val();
                    console.log(updated_student_id);

                    var updatedata = {
                        'edited_student_name': $('#edited_student_name').val(),
                        'edited_student_email': $('#edited_student_email').val(),
                        'edited_student_contactno': $('#edited_student_contactno').val(),
                    }
                    var name = $('#edited_student_name').val();
                    console.log('name :', name);
                    var data = $('#UpdateStudentForm').serialize()
                    console.log(data);

                    $.ajax({
                        data: updatedata,
                        url: "{{url('update_student_data')}}" + "/" + updated_student_id,
                        type: "POST",
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 400) {
                                $('#updateform_errList').html("");
                                $('#updateform_errList').addClass('alert alert-danger')
                                $.each(response.errors, function(key, err_values) {
                                    console.log(err_values);
                                    $('#updateform_errList').append('<li>' + err_values + '</li>');
                                });
                            } else {
                                $('.data-table').DataTable().ajax.reload();
                                $('#StudentEditModal').modal('hide');
                                $('#UpdateStudentForm')[0].reset();
                            }
                        },
                        error: function(data) {
                            console.log('Error', data);
                        },

                    });
                });

                $("#close").click(function() {
                    $('#StudentModal').modal('hide');
                });

                $("#closeupdate").click(function() {
                    $('#StudentEditModal').modal('hide');
                });

            });
        </script>
</body>
</x-app-layout>
</html>