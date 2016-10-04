<?php

namespace App;

use \FileMaker;
use Config;
use Log;

class QuestionBankRelates 
{
    protected $layout_name='QBR';
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
    public function addQuestionBankRelate($questionBankID,$questionID)
    {
        $record = $this->fmCon->createRecord($this->layout_name);
        $record -> setfield('fk_questionBankID',$questionBankID);
        $record -> setfield('fk_questionID',$questionID);
        
        if(FileMaker::isError($record))//if any error presents, then print it and exist
        {
           //dd( $result->getMessage());
           return 0;
        }
        $result = $record -> commit();
        return 1;
    }
}
