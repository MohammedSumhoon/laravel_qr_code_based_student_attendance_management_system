<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script>
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <style>
    .container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      margin-top: 20px;
      width:100%;
      position: relative;
      left: 30px;
      height: 600px;
    }
    .btn {
      color: black;
    }
    .btn:hover {
      color: white;
    }
    a
    {
    text-decoration:none;
    }
  </style>
</head>
<x-app-layout>
  <body>
  
    <div class="row">
      @if(session()->has('msg'))
      <div class="alert alert-success">{{session()->get('msg')}}</div>
      @endif
      <form method="POST" action="leave_sheet">
        @csrf
        <div class="container">
          <div class="form-group">
            <label for="Name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
          </div>
          <div class="form-group">
            <label for="RegisterNumber">Register Number</label>
            <input type="text" class="form-control" id="regno" name="regno" placeholder="Enter Register number">
          </div>
          <div class="form-group">
            <label for="Date">Date</label>
            <input type="text" class="form-control" id="date" name="date" placeholder="Select date">
          </div>
          <div class="form-group">
            <label for="NumberOfDays">No.of.Days</label>
            <input type="number" class="form-control" id="days" name="days" placeholder="Days">
          </div>
          <div class="form-group">
            <label for="Reason">Reason</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" name="reason"></textarea>
          </div><br>
          <button type="submit" class="btn btn-info">Submit</button>&nbsp;&nbsp;
          <button type="reset" class="btn btn-danger">Cancel</button>
      </form>
    </div>
    </div>
    <script>
      $(document).ready(function() {
        var count = 0;
        let temp=$('#date').multiDatesPicker({
          dateFormat: 'dd-mm-yy',
        }); 
      });
    </script>
  </body>
  </x-app-layout>
</html>
