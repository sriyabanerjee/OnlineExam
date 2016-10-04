<?php

namespace App;
use \FileMaker;
use Config;
use Log;


class Categories 
{
    protected $layout_name='Category';
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
     * To add category
     * @return void
     * 
     */
    public function addCategory($category)
    {
        $record = $this->fmCon->createRecord($this->layout_name);
        $record -> setfield('xt_category',$category);
        
        if(FileMaker::isError($record))//if any error presents, then print it and exist
        {
           //dd( $result->getMessage());
           return 0;
        }
        $result = $record -> commit();
        return 1;
    }
    public function doEditUserDetails($id,$name)
    {
        $editRecord = $this->fmCon->newEditCommand($this->layout_name,$id);
        $editRecord -> setfield('xt_category',$name);
        
        $result = $editRecord -> execute();
        if(FileMaker::isError($result))
        {
           Log::error( $result->getMessage());
           return 0;
        }
        
            return 1;
        
    }
    public function showCategoryList($sortColumn,$sortOrder,$search)
    {
        if($search){
         $request1 = $this->fmCon->newFindRequest($this->layout_name);
        $request1 -> addFindCriterion('pk_ID',$search);
        
        $request2= $this->fmCon->newFindRequest($this->layout_name);
        $request2 -> addFindCriterion('xt_category','=='.$search);
        
        $compoundFind = $this->fmCon->newCompoundFindCommand($this->layout_name);
        $compoundFind->add(1,$request1);
        $compoundFind->add(2,$request2);
        
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
            $request = $this->fmCon->newFindAllCommand($this->layout_name);
            
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
            $arr['recordCategoryID']=$returnval->getRecordId();
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
                "rowCount"=> $max,
                "rows"=> $arr2,
                "total"=> $total
            );
       
       
         return $val;
    }
    /**
     * Delete user by Record ID
     * @return true if sucess
     * @return false if failure
     * @param number record ID of the user
     */
    public function deleteCategoryByRecordID($ID)
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
    public function findAllCategoryNames()
    {
        $request=$this->fmCon->newFindAllCommand($this->layout_name);
        $result = $request->execute();
        $categoryNames=array();
        if(FileMaker::isError($result))
        {
            
           Log::error( $result->getMessage());
           return $categoryNames;
        }
        $records=$result->getRecords();
        $categoryNames=array();
        $layout_object = $this->fmCon->getLayout($this->layout_name);
        $field_objects=$layout_object->getFields();
        $index=0;
        foreach($records as $returnval)
		{
           $val= $returnval->getField('xt_category');
            $categoryNames[$index++]=$val;
            
        }
        return $categoryNames;
    }
}
