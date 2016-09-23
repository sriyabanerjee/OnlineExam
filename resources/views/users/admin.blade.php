@extends('master')
@section('title', 'adminPage')
@section('header')
    <link href="{{ URL::asset('../app/assets/css/dashboard.css')}}" rel="stylesheet" />
@endsection
@section('content')
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Welcome &nbsp{{ $_SESSION["userName"] }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Profile
            </button>
                
                <ul class="dropdown-menu">
                    <li id="adminShowProfile"><a href="#">Show Profile</a></li>
                    <li id="adminEditProfile"><a href="#">Edit Profile</a></li>
                    
                </ul>
                </div>
                </li>
            <li><a href="#">Logout</a></li>
            
          </ul>
          
        </div>
      </div>
    </nav>
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
        </ul>
        <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
        </ul>
        <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main">
        <table id="grid-basic" class="table table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="userName">User Name</th>
                    <th data-column-id="emailID" data-order="desc">Email ID</th>
                    <th data-column-id="password" data-order="desc">Password</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $_SESSION["id"] }}</td>
                    <td>{{ $_SESSION["userName"] }}</td>
                    <td>{{ $_SESSION["email"] }}</td>
                    <td>{{ $_SESSION["password"] }}</td>
                 </tr>
            </tbody>
        </table>
        <form name="adminEditForm"   method="post" class="form-horizontal">
            <div class="form-group">
                <label for="adminid" class="control-label col-sm-2">ID:</label>
                <div class="col-sm-4">
                    <input type="text" name="adminid" id="adminid" class="form-control" value={{ $_SESSION["id"] }} readonly><br>&nbsp
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="control-label col-sm-2">User Name:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="text" name="username" id="username" class="form-control"  value={{ $_SESSION["userName"] }} required><br>&nbsp
                    <span id="lastnameerror" class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="emailid" class="control-label col-sm-2">Email ID:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="email"  name="emailid" id="emailid"   class="form-control"  value={{ $_SESSION["email"] }} required><br>&nbsp
                    <span id="emailerror" class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-sm-2">Password:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="text" name="password" id="password" class="form-control"  value={{ $_SESSION["password"] }} required>
                    <span id="passworderror" class="error">
                </div>
            </div>
            <div class="form-group">
                <label for="privilege" class="control-label col-sm-2">Privilege:</label>
                <div class="col-sm-4">
                    <input type="text" name="privilege" id="privilege" class="form-control" value={{ $_SESSION["privilege"] }} readonly><br>&nbsp
                </div>
            </div>
            &nbsp &nbsp &nbsp &nbsp<input type="submit"  value="submit" class="btn btn-default" >
        </form>
    </div>
     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="msg"></div>
@endsection
@section('footer')
    <script src="{{ URL::asset('../app/assets/vendors/js/jquery.bootgrid.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#grid-basic").hide();
            $("form[name='adminEditForm']").hide();
            $('#msg').hide();
            $("#adminShowProfile").click(function(){
                $('#msg').hide();
                $("form[name='adminEditForm']").hide();
                $("#grid-basic").show(); 
            });
            $("#adminEditProfile").click(function(){
                
                $("#grid-basic").hide();
                $('#msg').hide();
                $("form[name='adminEditForm']").show();
            });
            $("form[name='adminEditForm']").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",	
                    url: "editUserProfile",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            $("#grid-basic").hide();
                            $("form[name='adminEditForm']").hide();
                            $('#msg').show();
                            $('#msg').html("You have sucessfully edited the informations"); 
                    },
                    error:function(data){
                        $("#grid-basic").hide();
                        $("form[name='adminEditForm']").hide();
                        $('#msg').html("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
         });
    </script>
@endsection