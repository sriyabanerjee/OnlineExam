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
use App\Questions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
/**
 * This class extends Controller class
 * @see app\Http\Controllers\Controller
 */
class QuestionsController extends Controller
{
    public function showCategoris(Request $request)
    {
        $object=new  Categories();
        $detail=$object->setDatabaseConnection();//To create database connection
		//$id=$request->input("id");//login user ID
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
        $categoryList = $object->showCategoryList($sortColumn,$sortOrder,$search);
		
		$jsonObject=json_encode($categoryList);//Now convert categories data into json data
		return $jsonObject;
    }
    public function doEditcategories(Request $request)
	  {
		$id=$request->input("modalEditCategoryRecordID");
		
		$name=$request->input("modalEditCategoryName");
		
		
		$object=new  Categories();
        $detail=$object->setDatabaseConnection();//To create database connection
        $returnValue=$object -> doEditUserDetails($id,$name);//To find if the user exists
		if($returnValue==0)
		{
			return "false";
		}
		
			return "true";
	  }
      /**
	 * Delete user by record ID
	 * @return true if sucess
	 * @return false if fail
	 * @param Request
	 */
	public function deleteCategoryByRecordId(Request $request)
	{
		$object=new  Categories();
		echo "in controller";
		$ID=$request->input("modalDeleteCategoryRecordID");
		echo $ID;
		if($object->deleteCategoryByRecordID($ID))
			return "true";
		return "false";
	}
	public function addCategory(Request $request)
	{
		$object=new  Categories();
		echo "in controller";
		$name=$request->input("modalAddCategoryName");
		
		if($object->addCategory($name))
			return "true";
		return "false";
	}
	public function findAllCategoryNames()
	{
		$object=new  Categories();
		$categoryNames=$object->findAllCategoryNames();
		return $categoryNames;
	}
	public function addQuestion(Request $request)
	{
		$object=new  Questions();
		//echo "in controller";
		$description=$request->input("modalAddQuestionDescription");
		$category=$request->input("modalAddQuestionCategory");
		$marks=$request->input("modalAddQuestionMark");
		if($object->addQuestion($description,$category,$marks))
			return "true";
		return "false";
	}
	public function showQuestions(Request $request)
    {
        $object=new  Questions();
        $detail=$object->setDatabaseConnection();//To create database connection
		//$id=$request->input("id");//login user ID
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
		/** to get question's list*/
        $questionsList = $object->showQuestionsList($sortColumn,$sortOrder,$search);
		
		$jsonObject=json_encode($questionsList);//Now convert questions data into json data
		return $jsonObject;
    }
	public function showQuestionByRecordId(Request $request)
	{
		$object=new  Questions();
        $detail=$object->setDatabaseConnection();
		//$ID=$_POST['ID'];
		$ID=$request->input("ID");
		$questionsList = $object->findQuestionByRecordID($ID);
		$jsonObject=json_encode($questionsList);//Now convert user data into json data
		return $jsonObject;
	}
	/**
	 * Delete user by record ID
	 * @return true if sucess
	 * @return false if fail
	 * @param Request
	 */
	public function deleteQuestionByRecordId(Request $request)
	{
		$object=new  Questions();
		
		$ID=$request->input("modalDeleteQuestionRecordID");
		echo $ID;
		if($object->deleteQuestionByRecordID($ID))
			return "true";
		return "false";
	}
	public function doEditQuestion(Request $request)
	  {
		$id=$request->input("modalEditQuestionRecordID");
		$description=$request->input("modalEditQuestionDescription");
		$category=$request->input("modalEditQuestionCategory");
		$marks=$request->input("modalEditQuestionMark");
		
		$object=new  Questions();
        $detail=$object->setDatabaseConnection();//To create database connection
        $returnValue=$object -> doEditQuestionDetails($id,$description,$category,$marks);//To find if the user exists
		if($returnValue==0)
		{
			return "false";
		}
		
			return "true";
	  }
	  public function searchQuestions()
	  {
		$object=new  Questions();
		$returnValue=$object ->searchQuestions();
		return $returnValue;
	  }
}