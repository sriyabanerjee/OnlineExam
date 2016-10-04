<?php

namespace App\Http\Controllers\Questions;

/**
 * fileName:UserController.php
 * app\Http\Controllers\Users\ListController.php
 * @author Sriya Banerjee<sriyab@mindfiresolutions.com>
 * created on 21 st sep, 2016
 */
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;
use App\QuestionsBank;
use App\QuestionBankRelates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
/**
 * This class extends Controller class
 * @see app\Http\Controllers\Controller
 */
class QuestionsBankController extends Controller
{
    public function addQuestionsBank(Request $request)
	{
		$object=new  QuestionsBank();
		$description=$request->input("modalAddQuestionBankDescription");
		$name=$request->input("modalAddQuestionBankName");
		return $object->addQuestionBank($description,$name);
			
	}
    public function addQuestionBankRelate(Request $request)
    {
        $object=new  QuestionBankRelates();
		$questionBankID=$request->input("");
		$questionID=$request->input("");
		return $object->addQuestionBankRelate($questionBankID,$questionID);   
    }
}