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
           dd($layout_object); 
        }
        else
           return $layout_object;
            
    }
    /**
     * To add users
     * @return void
     * 
     */
    public function addUser()
    {
        $record = $this->fmCon->createRecord($this->layout_name);
        $record -> setfield('xt_userName','Ratan');
        $record -> setfield('xt_email','ratan.basu@gmail.com');
        $record -> setfield('xt_password','basu');
        $record -> setfield('xt_privilege','1');
        if(FileMaker::isError($record))//if any error presents, then print it and exist
        {
           dd( $result->getMessage());  
        }
        $result = $record -> commit();
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
           dd($result); 
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
           
           return 0;
        }
         $records=$result->getRecords();
         $_SESSION["userName"] = $records[0]->getField('xt_userName');
         $_SESSION["id"] = $records[0]->getField('pk_ID');
         $_SESSION["email"] = $records[0]->getField('xt_email');
         $_SESSION["password"] = $records[0]->getField('xt_password');
         $_SESSION["privilege"] = $records[0]->getField('xt_privilege');
         if($records[0]->getField('xt_privilege')==3) //if the user is admin
                return 3;
            elseif($records[0]->getField('xt_privilege')==2) //if the user is manager
                return 2;
            elseif($records[0]->getField('xt_privilege')==1) //if the user is reporter
                return 1;
            elseif($records[0]->getField('xt_privilege')==4) ////if the user is normal user
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
           dd($result);
           return 0;
        }
        else
            return 1;
        
    }
 
}
