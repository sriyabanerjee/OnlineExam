<?php

namespace App;
/**
 * fileName:Users.php
 * app\Users.php
 * @author Sriya Banerjee<sriyab@mindfiresolutions.com>
 * created on 21 st sep, 2016
 */
use \FileMaker;
use Config;
use Session;
use Log;
class Users 
{
    protected $layout_name='USR';
    protected $fmCon = '';
    
    public function __construct()
    {
        $this->fmCon = new  FileMaker(Config('filemaker.FM_FILE'),Config('filemaker.FM_HOST'),Config('filemaker.FM_USER'),Config('filemaker.FM_PASS'));
    }
    /**
     * To create database connection
     * @return layout object
     */
    public function setDatabaseConnection()
    {
        
        $layout_object = $this->fmCon->getLayout($this->layout_name);
        if(FileMaker::isError($layout_object))
        {
           Log::error($layout_object); 
        }
        else
           return $layout_object;
            
    }
    /**
     * To add users
     * @return void
     * 
     */
    public function addUser($username,$email,$password,$privilege,$phnNo,$address,$activationCode,$parentUserID)
    {
        $record = $this->fmCon->createRecord($this->layout_name);
        $record -> setfield('xt_userName',$username);
        $record -> setfield('xt_email',$email);
        $record -> setfield('xt_password',$password);
        $record -> setfield('xt_privilege',$privilege);
        $record -> setfield('xn_phnNumber',$phnNo);
        $record -> setfield('xt_address',$address);
        
        $record -> setfield('xn_activationCode',$activationCode);
        $record -> setfield('xn_parentUserID',$parentUserID);
        if(FileMaker::isError($record))//if any error presents, then print it and exist
        {
           Log::error( $record->getMessage());
           return 0;
        }
        
        /**if(!empty($current_id)) {
            $actual_link = "http://localhost/OnlineExam/public/setPassword/activationCode=" . $activationCode;
            $toEmail = $email;
            $subject = "User Registration Activation Email";
            $content = "Click this link to activate your account. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
            $mailHeaders = "From: Admin\r\n";
            if(mail($toEmail, $subject, $content, $mailHeaders)) {
                echo "in mail";
                
                return 1;	
            }
        }*/
	
        $result = $record -> commit();
        return 1;
    }
    /**
     * To delete user
     * @return void
     */
    public function deleteUser($id)
    {
        $deleteRecord = $this->fmCon->newDeleteCommand($this->layout_name,$id);
        $result = $deleteRecord -> execute();
        if(FileMaker::isError($result))
        {
           Log::error( $result->getMessage()); 
        }
        
    }
    /**
     * To find a user against emailId and password
     * @param text $email emailId of the user
     * @param text $password password of the user
     * @return the fetched records
     */
    public function doCompoundSearch($email,$password)
    {
        $request = $this->fmCon->newFindRequest($this->layout_name);
        $request -> addFindCriterion('xt_email',$email);
        $request1 = $this->fmCon->newFindRequest($this->layout_name);
        $request1 -> addFindCriterion('xt_password',$password);
        $compoundFind = $this->fmCon->newCompoundFindCommand($this->layout_name);
        $compoundFind->add(1,$request);
        $compoundFind->add(2,$request1);
        $result=$compoundFind->execute();
        session_start();
        
       
        if(FileMaker::isError($result))
        {
           Log::error( $result->getMessage());
           return 0;
        }
         $records=$result->getRecords();
        /** $_SESSION["userName"] = $records[0]->getField('xt_userName');
         $_SESSION["id"] = $records[0]->getField('pk_ID');
         $_SESSION["email"] = $records[0]->getField('xt_email');
         $_SESSION["password"] = $records[0]->getField('xt_password');
         $_SESSION["privilege"] = $records[0]->getField('xt_privilege');*/
        Session::set('userName',$records[0]->getField('xt_userName'));
        Session::set('id',$records[0]->getField('pk_ID'));
        Session::set('email',$records[0]->getField('xt_email'));
        Session::set('password',$records[0]->getField('xt_password'));
        Session::set('privilege',$records[0]->getField('xt_privilege'));
         if($records[0]->getField('xt_privilege')=='admin') //if the user is admin
                return 4;
            elseif($records[0]->getField('xt_privilege')=='manager') //if the user is manager
                return 2;
            elseif($records[0]->getField('xt_privilege')=='reporter') //if the user is reporter
                return 1;
            elseif($records[0]->getField('xt_privilege')=='user') ////if the user is normal user
                return 4;
        
    }
    /** public function doCompoundSearch($email,$password)
    {
        $request = $this->fmCon->newFindCommand($this->layout_name);
        $request -> addFindCriterion('xt_email',$email);
        //$request1 = $this->fmCon->newFindRequest($this->layout_name);
        //$request1 -> addFindCriterion('xt_password',$password);
       // $compoundFind = $this->fmCon->newCompoundFindCommand($this->layout_name);
        //$compoundFind->add(1,$request);
        //$compoundFind->add(2,$request1);
        $result=$request->execute();
        //session_start();
        
       
        if(FileMaker::isError($result))
        {
           echo $result;
           return 0;
        }
         $records=$result->getRecords();
         if($records[0]->getField('xt_password')==$password) //if the user is admin
          {      
         if($records[0]->getField('xt_privilege')==3) //if the user is admin
                return 3;
            elseif($records[0]->getField('xt_privilege')==2) //if the user is manager
                return 2;
            elseif($records[0]->getField('xt_privilege')==1) //if the user is reporter
                return 1;
            elseif($records[0]->getField('xt_privilege')==4) ////if the user is normal user
                return 4;
          }
          else
          {
            echo "else";
            return 0;
          }
          
    }*/
    public function isEmailIDExsit($emailID)
    {
        $request = $this->fmCon->newFindCommand($this->layout_name);
        $request->addFindCriterion('xt_email','=='.$emailID);
        $result=$request->execute();
        if(FileMaker::isError($result))
        {
            echo($result);
           return 0;
        }
        $records=$result->getRecords();
        return 1;
    }
    public function doEditUserDetails($id,$username,$email,$password,$privilege)
    {
        $editRecord = $this->fmCon->newEditCommand($this->layout_name,$id);
        $editRecord -> setfield('xt_userName',$username);
        $editRecord -> setfield('xt_email',$email);
        $editRecord -> setfield('xt_password',$password);
        $editRecord -> setfield('xt_privilege',$privilege);
        $result = $editRecord -> execute();
        if(FileMaker::isError($result))
        {
           Log::error( $result->getMessage());
           return 0;
        }
        
            return 1;
        
    }
    public function editUserDetails($id,$username,$email,$password,$privilege,$phnNo,$address,$activationCode,$parentUserID)
    {
        
        $editRecord = $this->fmCon->newEditCommand($this->layout_name,$id);
        if($username)
        $editRecord -> setfield('xt_userName',$username);
        if($email)
        $editRecord -> setfield('xt_email',$email);
        if($password)
        {
        $editRecord -> setfield('xt_password',$password);
        echo $password;
        }
        if($privilege)
        {
          $editRecord -> setfield('xt_privilege',$privilege);
          echo $privilege;
        }
        
        if($phnNo)
        {
        $editRecord -> setfield('xn_phnNumber',$phnNo);
        echo $phnNo;
        }
       if($address)
        {
        $editRecord -> setfield('xt_address',$address);
        echo $address;
        }
       // $editRecord -> setfield('xn_phnNumber',9830133272);
       // $editRecord -> setfield('xn_activationCode',0);
        //$editRecord -> setfield('xn_parentUserID',4);
        if($activationCode)
        {
        $editRecord -> setfield('xn_activationCode',$activationCode);
        echo $activationCode;
        }
        if($parentUserID)
        {
        $editRecord -> setfield('xn_parentUserID',$parentUserID);
        echo $parentUserID;
        }
        $result = $editRecord -> execute();
        if(FileMaker::isError($result))
        {
            
           Log::error( $result->getMessage());
           return 0;
        }
        return 1;
    }
    public function findUsers($id,$sortColumn,$sortOrder,$search)
    {
       
        if($search){
         $request1 = $this->fmCon->newFindRequest($this->layout_name);
        $request1 -> addFindCriterion('pk_ID',$search);
        $request1->addFindCriterion('xn_parentUserID',$id);
        $request2= $this->fmCon->newFindRequest($this->layout_name);
        $request2 -> addFindCriterion('xt_userName','=='.$search);
        $request2->addFindCriterion('xn_parentUserID',$id);
        $request3= $this->fmCon->newFindRequest($this->layout_name);
        $request3 -> addFindCriterion('xt_email','=='.$search);
        $request3->addFindCriterion('xn_parentUserID',$id);
        $request4= $this->fmCon->newFindRequest($this->layout_name);
        $request4 -> addFindCriterion('xn_phnNumber',$search);
        $request4->addFindCriterion('xn_parentUserID',$id);
        $request5= $this->fmCon->newFindRequest($this->layout_name);
        $request5-> addFindCriterion('xt_address','=='.$search);
        $request5->addFindCriterion('xn_parentUserID',$id);
        $compoundFind = $this->fmCon->newCompoundFindCommand($this->layout_name);
        $compoundFind->add(1,$request1);
        $compoundFind->add(2,$request2);
        $compoundFind->add(3,$request3);
        $compoundFind->add(4,$request4);
        $compoundFind->add(5,$request5);
        $compoundFind->addSortRule($sortColumn,1,$sortOrder);
        $max = $_POST['rowCount'];
            $current = $_POST['current'];
            //echo $current;
            //if(!isset($current)) { $current = 0; }
            
                $compoundFind->setRange(($current-1)*$max, $max);
            $_POST['current']=$current+1;
        $result=$compoundFind->execute();
        }
        else
        {
            $request = $this->fmCon->newFindCommand($this->layout_name);
            $request -> addFindCriterion('xn_parentUserID',$id);
            $request->addSortRule($sortColumn,1,$sortOrder);
            $max = $_POST['rowCount'];
            $current = $_POST['current'];
            //echo $current;
            //if(!isset($current)) { $current = 0; }
            
            $request->setRange(($current-1)*$max, $max);
            $_POST['current']=$current+1;
            $result=$request->execute();
            
        }
        
        if(FileMaker::isError($result))
        {
          Log::error( $result->getMessage());
          return 0;
        }
        $records=$result->getRecords();
        $total=$result->getFoundSetCount();
        $layout_object = $this->fmCon->getLayout($this->layout_name);
        $field_objects=$layout_object->getFields();
        $arr2=array(array());
        $i=0;
        $arr=array();
        foreach($records as $returnval)
		{
            $arr['recordID']=$returnval->getRecordId();
			foreach($field_objects as $field_object)
            {
			$index= $field_object->getName();
			$val= $returnval->getField($field_object->getName());
            $arr[$index]=$val;
            }
            $arr2[$i]=$arr;
            $i++;
		}
        
        $val=array(
                
                "current"=> $current,
                "rowCount"=> 2,
                "rows"=> $arr2,
                "total"=> $total
            );
       
       
         return $val;
        
    }
    /**
     * Getting user's details by record ID
     * @return 0 if user not found
     * @return arrray containg user's details
     * @param number record ID of the user
     */
    public function findUserByRecordID($ID)
    {
        $records = $this->fmCon->getRecordById($this->layout_name,$ID);
        if(FileMaker::isError($records))
        {
           error_log($records);
           return 0;
        }
        $layout_object = $this->fmCon->getLayout($this->layout_name);
        $field_objects=$layout_object->getFields();
        $arr2=array(array());
        $i=0;
        $arr=array();
        $arr['recordID']=$records->getRecordId();
        foreach($field_objects as $field_object)
        {
			$index= $field_object->getName();
			$val= $records->getField($field_object->getName());
            $arr[$index]=$val;
        }
        
        return $arr;
    }
    /**
     * Delete user by Record ID
     * @return true if sucess
     * @return false if failure
     * @param number record ID of the user
     */
    public function deleteUserByRecordID($ID)
    {
        $deleteRecord = $this->fmCon->newDeleteCommand($this->layout_name,$ID);
        $result = $deleteRecord->execute();
        if(FileMaker::isError($result))
        {
            
           Log::error( $result->getMessage());
           return false;
        }
        return true;
    }
	public function setPassword($activationCode,$password)
	{
		$request = $this->fmCon->newFindCommand($this->layout_name);
        $request->addFindCriterion('xn_activationCode',$activationCode);
        $result=$request->execute();
		echo"in user";
        if(FileMaker::isError($result))
        {
            Log::error( $result->getMessage());
           return 0;
        }
        $record=$result->getRecords();
		foreach($record as $returnval)
		{
        $recordID=$returnval->getRecordId();
		}
		$editRecord = $this->fmCon->newEditCommand($this->layout_name,$recordID);
		$editRecord -> setfield('xn_activationCode',null);
		$editRecord -> setfield('xt_password',$password);
		$result = $editRecord -> execute();
		if(FileMaker::isError($result))
        {
            Log::error( $result->getMessage());
           return 0;
        }
		if(FileMaker::isError($result))
        {
            
           dd( $result->getMessage());
           return 0;
        }
        return 1;
	}
}
