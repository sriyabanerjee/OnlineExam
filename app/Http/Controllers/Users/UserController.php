<?php

namespace App\Http\Controllers\Users;
/**
 * fileName:UserController.php
 * app\Http\Controllers\Users\ListController.php
 * @author Sriya Banerjee<sriyab@mindfiresolutions.com>
 * created on 21 st sep, 2016
 */
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
/**
 * This class extends Controller class
 * @see app\Http\Controllers\Controller
 */
class UserController extends Controller
{
    /**
     * verifies if the user is registered or not
     * @return view page with coressponding user data
     */
    public function isUser(Request $request)
    {
        
        
        $emailId =$request->input("inputEmail");
        $password = $request->input("inputPassword");
        $object=new  Users();
        $detail=$object->setDatabaseConnection();//To create database connection
        $priviledge=$object -> doCompoundSearch($emailId,$password);//To find if the user exists
        
        if (!$priviledge)//if the user does not exist
        {
            
			 $msg="EmailId Or Password are incorrect";
             return view('users.login')->with('msg',$msg);
             
        }
		
		
		elseif($priviledge==4)
		{
			$msg="";
			
			return view('users.admin')->with('msg',$msg);
		}
		elseif($priviledge==3)
			return view('users.manager');
		elseif($priviledge==2)
			return view('users.reporter');
		elseif($priviledge==1)
			return view('users.user');
        
      
	}
	  public function editUserDetails(Request $request)
	  {
		$id=$request->input("adminid");
		$userName=$request->input("username");
		$emailID=$request->input("emailid");
		$password=$request->input("password");
		$privilege=$request->input("privilege");
		
		
		$object=new  Users();
        $detail=$object->setDatabaseConnection();//To create database connection
        $returnValue=$object -> doEditUserDetails($id,$userName,$emailID,$password,$privilege);//To find if the user exists
		if($returnValue==0)
		{
			return "false";
		}
		else
			return "true";
	  }
	  public function doEditUserDetails(Request $request)
	  {
		$id=$request->input("modalUsrID");
		
		$username=$request->input("modalUsrname");
		$email=$request->input("modalEmail");
		$password=$request->input("modalUsrPassword");
		$privilege=$request->input("modalUsrPriviledge");
		$phnNo=$request->input("modalPhnNo");
		
		
		$activationCode=$request->input("modalUserActivationCode");
		
		$address=$request->input("modalAddress");
		$parentUserID=$request->input("modalUserParentUserID");
		
		$object=new  Users();
        $detail=$object->setDatabaseConnection();//To create database connection
        $returnValue=$object -> editUserDetails($id,$username,$email,$password,$privilege,$phnNo,$address,$activationCode,$parentUserID);//To find if the user exists
		if($returnValue==0)
		{
			return "false";
		}
		
			return "true";
	  }
	  public function doLogOut()
	  {
		if(session_id() == '') {
			session_start();
		}
		session_unset();
		session_destroy();
	  }
	public function showUsers(Request $request)
	{
		$object=new  Users();
        $detail=$object->setDatabaseConnection();//To create database connection
		$id=$request->input("id");//login user ID
		$sortVar= $request->input('sort');
		//dd($sortOrder);
		$search=$request->input('searchPhrase');//searchPhase to search
        foreach($sortVar as $key=>$val)
        {
                $sortColumn = $key;//key for sort
				$sortOrder = $val;//order of sort
		}
		if($sortOrder=='desc')
			$sortOrder = FILEMAKER_SORT_DESCEND;
        else
            $sortOrder = FILEMAKER_SORT_ASCEND;
		/** to get user's list*/
        $usersList = $object->findUsers($id,$sortColumn,$sortOrder,$search);
		/**$arr=array(
				"current"=> count($usersList),
                "rowCount"=> 2,
                "rows"=> $usersList,
                "total"=> count($usersList)
            );*/
		$jsonObject=json_encode($usersList);//Now convert user data into json data
		return $jsonObject;
	}
    public function showUserByRecordId(Request $request)
	{
		$object=new  Users();
        $detail=$object->setDatabaseConnection();
		//$ID=$_POST['ID'];
		$ID=$request->input("ID");
		$usersList = $object->findUserByRecordID($ID);
		$jsonObject=json_encode($usersList);//Now convert user data into json data
		return $jsonObject;
	}
	/**
	 * Delete user by record ID
	 * @return true if sucess
	 * @return false if fail
	 * @param Request
	 */
	public function deleteUserByRecordId(Request $request)
	{
		$object=new  Users();
		$ID=$request->input("modalDeleteUsrRecordID");
		echo $ID;
		if($object->deleteUserByRecordID($ID))
			return "true";
		return "false";
	}
	public function addNewUser(Request $request)
	{
		$object=new  Users();
		$username=$request->input('modalAddUsrname');
		$email=$request->input('modalAddEmailID');
		$password=$request->input('modalAddPassword');
		$privilege=$request->input('modalAddPrivilege');
		$phnNo=$request->input('modalAddPhoneNo');
		$address=$request->input('modalAddAddress');
		$activationCode=rand();
		$parentUserID=$request->input('modalAddParentUserID');
		if($object->isEmailIDExsit($email))
		   return "Email ID already registered";
		if($object->addUser($username,$email,$password,$privilege,$phnNo,$address,$activationCode,$parentUserID))
			return "you have sucessfully added user";
		else
			return "OOPS!!Something Wrong";
	}
	public function sendMail($activationCode)
	{
		
		if(Mail::send( 'users.passwordLink',['activationCode'=>$activationCode],function($message)
               {
				$message->from('sriya92.banerjee@gmail.com', 'Free Online Test');
               $message->to('sriyab@mindfiresolutions.com','Sreya')->subject('Set Your Password to Activate Your Account');
			   }))
			echo "sucess";
		
	}
	public function setPassword(Request $request)
	{
		$object=new  Users();
		/*8dd("in controller");
		return 1 ;*/
		$detail=$object->setDatabaseConnection();
		$activationCode=$request->input('activationCode');
		$password=$request->input('password');
		if($object->setPassword($activationCode,$password))
			return "true";
		else
			return "false";
	}
}