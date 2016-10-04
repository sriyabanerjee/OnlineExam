@extends('master')
@section('title', 'adminPage')
@section('header')
    <link href="{{ URL::asset('../app/assets/css/dashboard.css')}}" rel="stylesheet" />
    <!--<link href="{{ URL::asset('../app/assets/vendors/css/font.awesome.min.css')}}" rel="stylesheet" />-->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
@endsection
@section('content')
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <<div class="navbar-header">
         <a  class="navbar-brand" href="#" >Welcome &nbsp{{ Session::get("userName") }} </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li id="adminShowProfile"><a href="#">Show Profile</a></li>
                        <li id="adminEditProfile"><a href="#">Edit Profile</a></li>
                    </ul>
                    </div>
                </li>
                <li><div>&nbsp &nbsp &nbsp</div></li>
                <li><button class="btn btn-primary dropdown-toggle" type="button" id="logOut"  data-toggle="dropdown"><i class="fa fa-sign-out" id="logOut" aria-hidden="true" ></i>
                </button></li>
            </ul>
        </div>
      </div>
    </nav>
        
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="#" id="usersLink" >Users <span class="sr-only">(current)</span></a></li>
            <li><a href="#" id="catagoriesLink">Catagories</a></li>
            <li><a href="#" id="QuestionsLink">Questions</a></li>
            <li><a href="#" id="QuestionsBankLink">Question Banks</a></li>
        </ul>
    </div>
        
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="main">
        <div class="container" id="grid-basic"><br><br><br><br>
            <div class="row" >
                <div class="col-sm-2">
                    &nbsp &nbsp &nbsp &nbsp ID:
                </div>
                <div class="col-sm-2">
                    {{ Session::get("id") }}
                </div>
            </div><br>
             <div class="row" >
                <div class="col-sm-2">
                    &nbsp &nbsp &nbsp &nbsp User Name:
                </div>
                <div class="col-sm-2">
                    {{ Session::get("userName") }}
                </div>
            </div> <br>
            <div class="row" >
                <div class="col-sm-2">
                    &nbsp &nbsp &nbsp &nbsp Email ID:
                </div>
                <div class="col-sm-2">
                    {{ Session::get("email") }}
                </div>
            </div> <br>  
        </div>
            
        <form name="adminEditForm"   method="post" class="form-horizontal">
            
                    <input type="hidden" name="adminid" id="adminid" class="form-control" value={{ Session::get("id") }} readonly><br>&nbsp
                
            <div class="form-group">
                <label for="username" class="control-label col-sm-2">User Name:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="text" name="username" id="username" class="form-control"  value={{ Session::get("userName") }} required><br>&nbsp
                    <span id="lastnameerror" class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="emailid" class="control-label col-sm-2">Email ID:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="email"  name="emailid" id="emailid"   class="form-control"  value={{ Session::get("email") }} required><br>&nbsp
                    <span id="emailerror" class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-sm-2">Password:<span style="color:red;">*</span></label>
                <div class="col-sm-4">
                    <input type="password" name="password" id="password" class="form-control"  value={{ Session::get("password") }} required>
                    <span id="passworderror" class="error">
                </div>
            </div>
            
                    <input type="hidden" name="privilege" id="privilege" class="form-control" value={{ Session::get("privilege") }} readonly><br>&nbsp
               
            <div class="col-sm-8"><center><input type="submit"  value="submit" class="btn btn-default" ></center></div>
        </form>
    </div>
    
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="msg"></div>
        
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="categoriesList">
        
        <table id="grid-data-category" class="table table-condensed table-hover table-striped">
            <caption><center><b>Category List</b></center></caption>
            <thead>
                <tr>
                    <th data-column-id="recordCategoryID" data-visible="false" >recordId</th>
                    <th data-column-id="pk_ID" data-type="numeric" data-order="asc" >ID</th>
                    <th data-column-id="xt_category" >Category Name</th>
                    <th  data-formatter="actions" data-sortable="false" >Actions</th>
                </tr>
            </thead>
        </table>
        <button type="button" class="btn btn-primary" id="addNewCategory">Add New Category</button>
        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Edit Modal</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="modalEditCategoryForm">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="form-group">
                                <label for="modalEditCategoryName"><span class="glyphicon glyphicon-user"></span> Category Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="modalEditCategoryName" placeholder="Enter Category Name" name="modalEditCategoryName" required>
                            </div>
                             <div class="form-group">
                                <input type="hidden" class="form-control" id="modalEditCategoryRecordID" name="modalEditCategoryRecordID">
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Save</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                 </div>
                </div>
            </div>
        </div>
         <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="modalDeleteCategoryForm">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="modalDeleteCategoryRecordID" name="modalDeleteCategoryRecordID">
                            </div>
                            <div class="form-group">
                                <p> Are You Sure? You want To delete <span id="deleteCategoryName"></span></p>
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block" id="modalDeleteCategoryFormButton"><span class="glyphicon glyphicon-off"></span> Delete</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="categoryAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="modalAddCategoryForm">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="form-group">
                                <label for="modalAddCategoryName"><span class="glyphicon glyphicon-user"></span> Category Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="modalAddCategoryName" placeholder="Enter Category Name" name="modalAddCategoryName" required>
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Save</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="categoryShowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Details</h4>
                    </div>
                    <div class="modal-body">
                        
                        <p> Category Name:<span id="categoryShowModalNameSpan"></span></p>
                         <p>Category ID:<span id="categoryShowModalIDSpan"></span></p>       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="usersList">
        <table id="grid-data" class="table table-condensed table-hover table-striped">
        <caption><center><b>User's Information</b></center></caption>
        <thead>
            <tr>
                <th data-column-id="recordID" data-visible="false">recordId</th>
                <th data-column-id="pk_ID" data-type="numeric" data-order="asc">ID</th>
                <th data-column-id="xt_userName" >UserName</th>
                <th data-column-id="xt_email" >Email ID</th>
                <th data-column-id="xn_phnNumber" >Phone Number</th>
                <th data-column-id="xt_address" >Address</th>
                <th  data-formatter="actions" data-sortable="false">Actions</th>
            </tr>
        </thead>
    </table>
    <button type="button" class="btn btn-primary" id="addNewUser">Add New User</button>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">User Edit Form</h4>
      </div>
      <div class="modal-body">
        <form role="form" name="modalEditForm">
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalUsrID" name="modalUsrID"  >
            </div>
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> User Name:</label>
              <input type="text" class="form-control" id="modalUsrname" placeholder="Enter UserName" name="modalUsrname" >
            </div>
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Email ID:</label>
              <input type="text" class="form-control" id="modalEmail" placeholder="Enter email" name="modalEmail" >
            </div>
            
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalUsrPassword" name="modalUsrPassword"  >
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalUsrPriviledge"  name="modalUsrPriviledge">
            </div>
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Phone Number</label>
              <input type="text" class="form-control" id="modalPhnNo" placeholder="Enter Phone No" name="modalPhnNo">
            </div>
            
            
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Address</label>
              <input type="text" class="form-control" id="modalAddress" placeholder="Enter Address" name="modalAddress">
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalUserParentUserID" name="modalUserParentUserID" >
            </div>
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Submit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <div class="modal-body">
            <form role="form" name="modalDeleteForm">
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalDeleteUsrRecordID" name="modalDeleteUsrRecordID">
            </div>
            <div class="form-group">
              <p> Are You Sure? You want To delete <span id="deleteUserNameModal"></span></p>
            </div>
            
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Delete</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="myAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Add New User</h4>
      </div>
      <div class="modal-body">
            <form role="form" name="modalAddForm">
            <div class="form-group">
              <label for="modalAddUsrname"><span class="glyphicon glyphicon-user"></span> User Name:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="modalAddUsrname" placeholder="Enter UserName" name="modalAddUsrname" required>
            </div>
            <div class="form-group">
              <label for="modalAddEmailID"><span class="glyphicon glyphicon-user"></span> Email ID:<span style="color:red;">*</span></label>
              <input type="email" class="form-control" id="modalAddEmailID" placeholder="Enter Email ID" name="modalAddEmailID" required>
            </div>
            <div class="form-group">
              <label for="modalAddPrivilege"><span class="glyphicon glyphicon-user"></span> Privilege:</label>
              <select id="modalAddPrivilege" name="modalAddPrivilege" class="form-control">
                <option value="manager">Manager</option>
                <option value="reporter">Reporter</option>
                <option value="user">User</option>
            </select>
            </div>
            <div class="form-group">
              <label for="modalAddPhoneNo"><span class="glyphicon glyphicon-user"></span> Phone No:</label>
              <input type="text" class="form-control" id="modalAddPhoneNo" placeholder="Enter Phone No" name="modalAddPhoneNo" >
            </div>
            <div class="form-group">
              <label for="modalAddAddress"><span class="glyphicon glyphicon-user"></span> Address:</label>
              <input type="text" class="form-control" id="modalAddAddress" placeholder="Enter Address" name="modalAddAddress" >
            </div>
            <div class="form-group">
              
              <input type="hidden" class="form-control" id="modalAddPassword"  name="modalAddPassword"  value="">
            </div>
            <div class="form-group">
              
              <input type="hidden" class="form-control" id="modalAddActivationCode"  name="modalAddActivationCode"  value="">
            </div>
                
            <div class="form-group">
              
              <input type="hidden" class="form-control" id="modalAddParentUserID"  name="modalAddParentUserID"  value={{ Session::get("id") }} >
            </div>
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Submit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="usersShowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"> User Details</h4>
      </div>
      <div class="modal-body">
            
            
            <p>User Name:<span id="showUserNameModal"></span></p>
           <p>Email ID:<span id="showUserEmailIDModal"></span></p>
            <p> Privilege:<span id="showUserPrivilegeModal"></span></p>
            <p>Phone No:<span id="showUserPhoneNoModal"></span></p>
            <p>Address:<span id="showUserAddressModal"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
        
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="Questions">
        <table id="grid-data-QuestionsList" class="table table-condensed table-hover table-striped">
        <caption><center><b>Question's Information</b></center></caption>
        <thead>
            <tr>
                <th data-column-id="recordID" data-visible="false">recordId</th>
                <th data-column-id="pk_ID" data-type="numeric" data-order="asc">ID</th>
                <th data-column-id="xt_description" >Description</th>
                <th data-column-id="xt_category" >Category</th>
                <th data-column-id="xn_marks" >Marks</th>
                
                <th  data-formatter="actions" data-sortable="false">Actions</th>
            </tr>
        </thead>
    </table>
        <button type="button" class="btn btn-primary" id="addNewQuestion">Add New Question</button>
    
    <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Add New Question</h4>
      </div>
      <div class="modal-body">
            <form role="form" name="modalQuestionAddForm">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="form-group">
              <label for="modalAddQuestionDescription"> Description:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="modalAddQuestionDescription" placeholder="Enter Description" name="modalAddQuestionDescription" required>
            </div>
            
            <div class="form-group">
              <label for="modalAddQuestionCategory">Category:<span style="color:red;">*</span></label>
              <select id="modalAddQuestionCategory" name="modalAddQuestionCategory" class="form-control" >
                <option value="">Please Choose a Category</option>
                
            </select>
            </div>
            <div class="form-group">
              <label for="modalAddQuestionMark"> Marks:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="modalAddQuestionMark" placeholder="Enter Marks" name="modalAddQuestionMark" required>
            </div>
            
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Submit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="editModalQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Edit Question</h4>
      </div>
      <div class="modal-body">
            <form role="form" name="EditModalQuestionForm">
            
            <div class="form-group">
              <label for="modalEditQuestionDescription">Description:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="modalEditQuestionDescription" placeholder="Enter Description" name="modalEditQuestionDescription" required>
            </div>
            
            <div class="form-group">
              <label for="modalEditQuestionCategory">Category:<span style="color:red;">*</span></label>
              <select id="modalEditQuestionCategory" name="modalEditQuestionCategory" class="form-control" required>
                <option value="">Please select a Category</option>
                
            </select>
            </div>
            <div class="form-group">
              <label for="modalEditQuestionMark"> Marks:<span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="modalEditQuestionMark" placeholder="Enter Marks" name="modalEditQuestionMark" required >
            </div>
            
            <div class="form-group">
              
              <input type="hidden" class="form-control" id="modalEditQuestionRecordID"  name="modalEditQuestionRecordID" >
            </div>
            
                
            
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Edit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="questionsShowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"> question Details</h4>
      </div>
      <div class="modal-body">
            
            
            <p>Description:<span id="showQuestionDescriptionModal"></span></p>
           <p>Category:<span id="showQuestionCategoryModal"></span></p>
            <p> Marks:<span id="showQuestionMarksModal"></span></p>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="QuestionDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete Question</h4>
      </div>
      <div class="modal-body">
            <form role="form" name="QuestionDeleteModalForm">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="form-group">
              <input type="hidden" class="form-control" id="modalDeleteQuestionRecordID" name="modalDeleteQuestionRecordID">
            </div>
            <div class="form-group">
              <p> Are You Sure? You want To delete the question " <span id="deleteQuestionDescriptionModal"></span> "</p>
            </div>
            
            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Delete</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
</div>    
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="QuestionsBank">
        <button type="button" class="btn btn-primary" id="addNewQuestionsBank">Add New QuestionsBank</button>
        <div class="modal fade" id="questionsBankAddquestionsBankModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                        <h4 class="modal-title" id="myModalLabel"> question Details</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="AddModalQuestionBankForm">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="form-group">
                                <label for="modalAddQuestionBankName"> Name:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="modalAddQuestionBankName" placeholder="Enter Name" name="modalAddQuestionBankName" required >
                            </div>
                            <div class="form-group">
                                <label for="modalAddQuestionBankDescription"> Description:<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="modalAddQuestionBankDescription" placeholder="Enter Description" name="modalAddQuestionBankDescription" required >
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> AddQuestions</button>
                                
                        </form>
            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addQuestionsInQuestionsBankModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                        <h4 class="modal-title" id="myModalLabel"> Select Questions </h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" name="AddModalQuestionBankForm">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="AddModalQuestionBankFormQuestionBankID" id="AddModalQuestionBankFormQuestionBankID">
                            <div class="form-group">
                                
                                <select id="modalSelectQuestionsForQuestionsBank" name="modalSelectQuestionsForQuestionsBank" class="form-control" multiple>
                                </select>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> select</button>
                                
                        </form>
            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ URL::asset('../app/assets/vendors/js/jquery.bootgrid.min.js')}}"></script>
    <script src="{{ URL::asset('../app/assets/vendors/js/jquery.blockUI.js')}}"></script>
    <script type="text/javascript">
        $(document).ajaxStop($.unblockUI);
        $(document).ready(function(){
            $("#grid-basic").hide();
            $("#categoriesList").hide();
            $("form[name='adminEditForm']").hide();
            $('#msg').hide();
            $('#Questions').hide();
            $("#QuestionsBank").hide();
           // $("#usersList").hide();
             //console.log( $("#usersLink").length);
            /* setTimeOut(function(){
              $("#usersLink").trigger('click');
             }, 10);*/
           
            $('.nav li a').click(function(e) {

                $('.nav li').removeClass('active');

             var $parent = $(this).parent();
             if (!$parent.hasClass('active')) {
                $parent.addClass('active');
                }
                e.preventDefault();
            });
            $("form[name='modalDeleteCategoryForm']").on('submit', function(e){
               // alert("hi");
               // $("#deleteCategoryModal").modal("hide");
                
                e.preventDefault();
                $.blockUI();
                
                $.ajax({
                    type: "POST",	
                    url: "deletecategories",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("You have sucessfully deleted");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
            $("#adminShowProfile").click(function(){
                $('#msg').hide();
                $('#Questions').hide();
                $("#categoriesList").hide();
                $("form[name='adminEditForm']").hide();
                $("#usersList").hide();
                $("#QuestionsBank").hide();
                $("#grid-basic").show(); 
            });
            $("#adminEditProfile").click(function(){
                $("#categoriesList").hide();
                $("#grid-basic").hide();
                $('#msg').hide();
                $("#usersList").hide();
                $('#Questions').hide();
                $("#QuestionsBank").hide();
                $("form[name='adminEditForm']").show();
            });
            $("form[name='adminEditForm']").on('submit', function(e){
                e.preventDefault();
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "editUserProfile",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            $("#grid-basic").hide();
                            $("#categoriesList").hide();
                            $("form[name='adminEditForm']").hide();
                            $('#msg').show();
                            $('#msg').html("You have sucessfully registered"); 
                    },
                    error:function(data){
                        $("#grid-basic").hide();
                        $("form[name='adminEditForm']").hide();
                        $("#categoriesList").hide();
                        $('#msg').html("OOPS! something wrong");
                    }   
                });
            });
            $("#logOut").click(function(){
                $.blockUI();
                $.ajax({
                    url: 'logout',
                    success: function(data){
                        window.location.href = 'login';
                    }
                });
            });
            $("#catagoriesLink").click(function(){
                
                $("#grid-basic").hide();
                $('#msg').hide();
                $("form[name='adminEditForm']").hide();
                $("#usersList").hide();
                $('#Questions').hide();
                $("#QuestionsBank").hide();
                $("#categoriesList").show();
                  $("#grid-data-category").bootgrid({
                    ajax: true,
                    cssClass: "showDetails",
                    post: function ()
                    {
                        /* To accumulate custom parameter with the request object */
                        return {
                            id: {{ Session::get("id") }},
                            
                        };
                    },
                    pagination: true,
                    url: "categories",
                    formatters: {
                        "actions": function(column, row)
                        {
                            return "<button  data-id=\"" + row.recordCategoryID +"\" data-categoryName=\""+ row.xt_category+"\" class=\"w3-btn w3-blue w3-small edit\"  data-toggle=\"modal\"  data-target=\"#editCategoryModal\" ><span class=\"fa fa-pencil\"></span></button> " +
                                    "<button data-id=\"" + row.recordCategoryID +"\" data-categoryName=\""+ row.xt_category +"\" data-pkID=\""+ row.pk_ID+"\" class=\"w3-btn w3-blue w3-small delete\" data-toggle=\"modal\" data-target=\"#deleteCategoryModal\"><span class=\"fa fa-remove\"></span></button>";
 
                        }
                        
                    }
              }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                $(this).find(".edit").click(function (e) {
                    //alert('in edit');
                    $('#modalEditCategoryName').val($(this).attr("data-categoryName"));
                    document.getElementById('modalEditCategoryRecordID').value=$(this).attr("data-id");
                    
                      $($(".edit").attr("data-target")).modal("show");   
                    });
                
                $(this).find(".delete").click(function (e) {
                   $('#deleteCategoryName').text($(this).attr("data-categoryName"));
                    document.getElementById('modalDeleteCategoryRecordID').value=$(this).attr("data-id");
                    //document.getElementById('modalDeleteCategoryRecordID').value=$(this).attr("data-id");
                    //console.log($(this).attr("data-id"));
                   // console.log($(this).attr("data-userName"));
                    $($(".delete").attr("data-target")).modal("show"); 
                });
                $(this).find('tbody tr').on('click', function(e){
                    $('#categoryShowModalNameSpan').text($(this).find('.delete').attr("data-categoryName"));
                    //$(this).find('.btn-edit').attr('id')
                    //document.getElementById('modalDeleteCategoryRecordID').value=$(this).attr("data-id");
                    
                    // $('#categoryShowModalNameSpan').text($('.edit').attr("data-pkID"));
                    $('#categoryShowModalIDSpan').text($(this).find('.delete').attr("data-pkID"));
                    $('#categoryShowModal').modal("show");
                });
                });
            });
            
            $("#usersLink").click(function(){
                $('#Questions').hide();
                $("#grid-basic").hide();
                $('#msg').hide();
                $("form[name='adminEditForm']").hide();
                $("#categoriesList").hide();
                $("#QuestionsBank").hide();
                $("#usersList").show();
                $("#grid-data").bootgrid({
                    ajax: true,
                    post: function ()
                    {
                        /* To accumulate custom parameter with the request object */
                        return {
                            id: {{ Session::get("id") }},
                            
                        };
                    },
                    pagination: true,
                    url: "showUsersList",
                    formatters: {
                        "actions": function(column, row)
                        {
                            return "<button  data-id=\"" + row.recordID +"\" class=\"w3-btn w3-blue w3-small edit\"  data-toggle=\"modal\"  data-target=\"#myModal\"><span class=\"fa fa-pencil\"></span></button> " +
                                    "<button data-id=\"" + row.recordID +"\" data-userName=\""+ row.xt_userName+"\" class=\"w3-btn w3-blue w3-small delete\" data-toggle=\"modal\" data-target=\"#myDeleteModal\"><span class=\"fa fa-remove\"></span></button>";
 
                        }
                        
                    }
              }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                $(this).find(".edit").click(function (e) {
                    $.blockUI();
                    $.ajax({
                        type: "POST",	
                        url: "usersByRecordID",
                        data: ({ID: $(this).attr("data-id")}),
                        dataType: "json",
                        success: function(data){
                            $('#modalUsrID').val(data.pk_ID);
                            $('#modalUsrname').val(data.xt_userName);
                            $('#modalEmail').val(data.xt_email);
                            $('#modalUsrPassword').val(data.xt_password);
                            $('#modalUsrPriviledge').val(data.xt_privilege);
                            $('#modalPhnNo').val(data.xn_phnNumber);
                            $('#modalAddress').val(data.xt_address);
                            $('#modalUserParentUserID').val(data.xn_parentUserID);
                            $($(".edit").attr("data-target")).modal("show");
                            
                            },
                        error:function(data){
                        alert("error");
                        }   
                    });
                    });
                
                $(this).find(".delete").click(function (e) {
                    //$('#deleteUserNameModal').val($(this).attr("data-userName"));
                    document.getElementById('modalDeleteUsrRecordID').value=$(this).attr("data-id");
                    //document.getElementById('deleteUserNameModal').value=$(this).attr("data-userName");
                    $('#deleteUserNameModal').text($(this).attr("data-userName"));
                    console.log($(this).attr("data-id"));
                    console.log($(this).attr("data-userName"));
                    $($(this).attr("data-target")).modal("show");
                });
                $(this).find('tbody tr').on('click', function(e){
                    $.blockUI();
                    $.ajax({
                        type: "POST",	
                        url: "usersByRecordID",
                        data: ({ID: $(this).find('.delete').attr("data-id")}),
                        dataType: "json",
                        success: function(data){
                            //document.getElementById('modalUsrID').value=data.recordID;
                            $('#showUserNameModal').text(data.xt_userName);
                            $('#showUserEmailIDModal').text(data.xt_email);
                            $('#showUserPrivilegeModal').text(data.xt_privilege);
                            $('#showUserPhoneNoModal').text(data.xn_phnNumber);
                            $('#showUserAddressModal').text(data.xt_address);
                            
                            $('#usersShowModal').modal("show");
                            },
                        error:function(data){
                        alert("error");
                        }
                    
                    });
                });
                });
            });
            $("form[name='modalEditForm']").on('submit', function(e){
                $("#myModal").modal("hide");
                $.blockUI();
                e.preventDefault();
                
                $.ajax({
                    type: "POST",	
                    url: "editUserProfileModal",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("You have sucessfully edited the informations");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
            $("form[name='modalDeleteForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#myDeleteModal").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "deleteuserByRecordID",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("You have sucessfully deleted");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
            $("#addNewUser").click(function(e){
                $("#myAddModal").modal("show");
            });
            $("form[name='modalAddForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#myAddModal").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "adduser",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("you have sucessfully added the user");
                            window.location.reload();
                    },
                    error:function(data){
                        alert(data);
                    }   
                });
            });
            $("#addNewCategory").click(function(e){
                
                $("#categoryAddModal").modal("show");
            });
            $("form[name='modalEditCategoryForm']").on('submit', function(e){
                $("#editCategoryModal").modal("hide");
                $.blockUI();
                e.preventDefault();
                
                $.ajax({
                    type: "POST",	
                    url: "edit.categories",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("You have sucessfully edited the informations");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
            $("form[name='modalAddCategoryForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#categoryAddModal").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "addcategories",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("you have sucessfully added the category");
                            window.location.reload();
                    },
                    error:function(data){
                        alert(data);
                    }   
                });
            });
            $("#QuestionsLink").click(function(){
                $("#grid-basic").hide();
                $('#msg').hide();
                $("form[name='adminEditForm']").hide();
                $("#usersList").hide();
                $("#categoriesList").hide();
                $("#QuestionsBank").hide();
                $('#Questions').show();
                $("#addNewQuestion").click(function(e){
                    $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "findAllcategories",
                    
                    success: function(data){
                            for(i=0;i<data.length;i++)
                                $('#modalAddQuestionCategory').append("<option value='"+ data[i] +"'>" + data[i] + "</option>");
                            $("#addQuestionModal").modal("show");
                            
                    },
                    error:function(data){
                        alert(data);
                    }   
                    });
                    });
                   /* $("#modalEditQuestionCategory").click(function(e){
                    $.blockUI();
                    $.ajax({
                    type: "POST",	
                    url: "findAllcategories",
                    
                    success: function(data){
                            for(i=0;i<data.length;i++)
                                $('#modalEditQuestionCategory').append("<option value='"+ data[i] +"'>" + data[i] + "</option>");
                            
                            
                    },
                    error:function(data){
                        alert(data);
                    }   
                    });
                    });*/
                    $("#grid-data-QuestionsList").bootgrid({
                    ajax: true,
                    
                    post: function ()
                    {
                        /* To accumulate custom parameter with the request object */
                        return {
                            id: {{ Session::get("id") }},
                            
                        };
                    },
                    pagination: true,
                    url: "showQuestion",
                    formatters: {
                        "actions": function(column, row)
                        {
                            return "<button  data-id=\"" + row.recordCategoryID +"\" data-Description=\""+ row.xt_description+"\" class=\"w3-btn w3-blue w3-small edit\"  data-toggle=\"modal\"  data-target=\"#editModalQuestion\" ><span class=\"fa fa-pencil\"></span></button> " +
                                    "<button data-id=\"" + row.recordCategoryID +"\" data-Description=\""+ row.xt_description +"\" data-pkID=\""+ row.pk_ID+"\" class=\"w3-btn w3-blue w3-small delete\" data-toggle=\"modal\" data-target=\"#QuestionDeleteModal\"><span class=\"fa fa-remove\"></span></button>";
 
                        }
                        
                    }
              }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                $(this).find(".edit").click(function (e) {
                    $.blockUI();
                    $.ajax({
                        type: "POST",	
                        url: "showsQuestion",
                        data: ({ID: $(this).attr("data-id")}),
                        dataType: "json",
                        success: function(dataouter){
                           
                            $('#modalEditQuestionRecordID').val(dataouter.recordID);
                            $('#modalEditQuestionDescription').val(dataouter.xt_description);
                            $('#modalEditQuestionMark').val(dataouter.xn_marks);
                             var selectedItem=dataouter.xt_category;
                           $.ajax({
                    type: "POST",	
                    url: "findAllcategories",
                    
                    success: function(data){
                            for(i=0;i<data.length;i++)
                                $('#modalEditQuestionCategory').append("<option value='"+ data[i] +"'>" + data[i] + "</option>");
                                //$("#modalEditQuestionCategory >[value="+ selectedItem"]").attr("selected","selected");
                                //$('option[value=valueToSelect]', newOption).attr('selected', 'selected');
                                
                                $('#editModalQuestion').modal("show");
                            
                    },
                    error:function(data){
                        alert(data);
                    }   
                    });
                            },
                        error:function(data){
                        alert("error");
                        }   
                    });
                });
                $(this).find('tbody tr').on('click', function(e){
                     if($(e.target).hasClass('edit') || $(e.target).hasClass('delete')) {
                    e.preventDefault();    
                } else {
                    $.blockUI();
                    $.ajax({
                        type: "POST",	
                        url: "showsQuestion",
                        data: ({ID: $(this).find('.delete').attr("data-id")}),
                        dataType: "json",
                        success: function(data){
                            //document.getElementById('modalUsrID').value=data.recordID;
                            $('#showQuestionDescriptionModal').text(data.xt_description);
                            $('#showQuestionCategoryModal').text(data.xt_category);
                            $('#showQuestionMarksModal').text(data.xn_marks);
                            
                            
                            },
                        error:function(data){
                        alert("error");
                        }
                    
                    });
                }
                    });
                $(this).find(".delete").click(function (e) {
                    $('#modalDeleteQuestionRecordID').val($(this).attr("data-id"));
                    //document.getElementById('modalDeleteUsrRecordID').value=$(this).attr("data-id");
                    //document.getElementById('deleteUserNameModal').value=$(this).attr("data-userName");
                    $('#deleteQuestionDescriptionModal').text($(this).attr("data-Description"));

                    $($(this).attr("data-target")).modal("show");
                });
            });
            });
            $("form[name='modalQuestionAddForm']").on('submit', function(e){
               // alert("hi");
                $("#addQuestionModal").modal("hide");
                
                e.preventDefault();
                $.blockUI();
                
                $.ajax({
                    type: "POST",	
                    url: "addQuestion",
                    data: $(this).serialize(),
                    success: function(data){
                            alert("You have sucessfully Added");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
            
            $("form[name='EditModalQuestionForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#editModalQuestion").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "editQuestion",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                       alert("You have sucessfully edited");     
                    },
                    error:function(data){
                        alert(data);
                    }   
                });
            });
            $("form[name='QuestionDeleteModalForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#QuestionDeleteModal").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "deleteQuestion",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(data){
                            alert("You have sucessfully deleted");
                            window.location.reload();
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
             $("#usersLink").trigger('click');
             $("#QuestionsBankLink").click(function(){
                
                $("#grid-basic").hide();
                $('#msg').hide();
                $("form[name='adminEditForm']").hide();
                $("#usersList").hide();
                $('#Questions').hide();
                $("#categoriesList").hide();
                $("#QuestionsBank").show();
             });
             $("#addNewQuestionsBank").click(function(){
                $("#questionsBankAddquestionsBankModal").modal("show");
             });
             $("form[name='AddModalQuestionBankForm']").on('submit', function(e){
                
                e.preventDefault();
                $("#questionsBankAddquestionsBankModal").modal("hide");
                $.blockUI();
                $.ajax({
                    type: "POST",	
                    url: "addQuestionsBank",
                    data: $(this).serialize(),
                    
                    success: function(data){
                        var questionBankID=data;
                        $.ajax({
                                type: "POST",	
                                url: "findAllcategories",
                                success: function(data){
                                    for(i=0;i<data.length;i++)
                                    $('#modalSelectQuestionsForQuestionsBank').append("<optgroup label='"+ data[i] +"'class='"+data[i]+"'>"  + "</optgroup>");
                                    $.ajax({
                                        type: "GET",	
                                        url: "searchAllQuestions",
                                        success: function(data){
                                            
                                            for(i=0;i<data.length;i++)
                                            {
                                                var category=data[i].xt_category;
                                                var question=data[i].xt_description;
                                                var questionId =data[i].pk_ID
                                                $('.'+category).append("<option value='"+ questionId +"'id='"+questionId+"'>" + question + "</option>");
                                                
                                            }
                                            
                                            $('#AddModalQuestionBankFormQuestionBankID').val(questionBankID);
                                            $('#addQuestionsInQuestionsBankModal').modal("show");
                                        },
                                        error:function(data){
                                            alert(data);
                                        }   
                                    });  
                                },
                                error:function(data){
                                    alert(data);
                                }   
                            });        
                            
                    },
                    error:function(data){
                        alert("OOPS!!!SOMETHING WRONG");
                    }   
                });
            });
         });
    </script>
@endsection