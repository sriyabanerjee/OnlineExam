<?php

namespace App;

use \FileMaker;
use Config;
use Log;

class QuestionsBank 
{
    protected $layout_name='QNSBNK';
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
     * To add Question
     * @return void
     * 
     */
    public function addQuestionBank($description,$name)
    {
        $record = $this->fmCon->createRecord($this->layout_name);
        $record -> setfield('xt_description',$description);
        $record -> setfield('xt_name',$name);
        
        if(FileMaker::isError($record))//if any error presents, then print it and exist
        {
           //dd( $result->getMessage());
           return 0;
        }
        $result = $record -> commit();
        
        return $record->getField('pk_ID');
    }
}
