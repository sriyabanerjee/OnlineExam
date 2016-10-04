@extends('master')
@section('content')
    <div id='formContains'>
    <form name="setPasswordForm"   method="POST" class="form-horizontal">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" name="activationCode" id="activationCode" class="form-control" value={{ $activationCode }} readonly><br>&nbsp
                
            <div class="form-group">
                <label for="password" class="control-label col-sm-2">Password:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="password" name="password" id="password" class="form-control"   required><br>&nbsp
                    
                </div>
            </div>
            
                    
               
            <div class="col-sm-8"><center><input type="submit"  value="submit" class="btn btn-default" ></center></div>
        </form>
        </div>
     <div id="msg"><p id="txt"></p></div>
@endsection
@section('footer')
    <script src="{{ URL::asset('../app/assets/vendors/js/jquery.blockUI.js')}}"></script>
    <script type="text/javascript">
        $(document).ajaxStop($.unblockUI);
        $(document).ready(function(){
            $("#msg").hide();
            $("#formContains").show();
            $("form[name='setPasswordForm']").on('submit', function(e){
                
                e.preventDefault();
                
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "../confirmation",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            $("#formContains").hide();
                            //$("#msg").show();
                            $("#txt").val("you have sucessfully set your password");
                            alert('sucess');
                            
                    },
                    error:function(data){
                            $("#formContains").hide();
                            $("#msg").show();
                            $("#txt").val("OOPS!! something wrong");
                    }   
                });
            });
        });
    </script>
@endsection