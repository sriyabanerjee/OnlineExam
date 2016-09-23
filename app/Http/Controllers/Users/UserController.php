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
        
        if ($priviledge==0)//if the user does not exist
        {
            
			 $msg="EmailId Or Password are incorrect";
             return view('users.login')->with('msg',$msg);
             
        }
		
		
		elseif($priviledge==3)
		{
			$msg="";
			return view('users.admin')->with('msg',$msg);
		}
		elseif($priviledge==3)
			return view('users.manager');
		elseif($priviledge==3)
			return view('users.reporter');
		elseif($priviledge==3)
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
   
}