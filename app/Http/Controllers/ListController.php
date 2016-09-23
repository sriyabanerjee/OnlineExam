<?php
/**
 * fileName:ListController.php
 * app\Http\Controllers\ListController.php
 * @author Sriya Banerjee<sriyab@mindfiresolutions.com>
 * created on 15 th sep, 2016
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\DetailList;
use resources\views\users\test;
use App\Users;

/*
 * This class extends Controller class
 * @see app\Http\Controllers\Controller.php
 */
class ListController extends Controller
{
    /**
     * This function returns the details of specified id
     * @param number $id the id of user 
     * @return the details of the user
     */
    public function listDetails($id=1)
    {
        $object=new DetailList();
        $detail=$object->showDetails($id);
        if(is_null($detail)){
            return "$id is not valid id";
        }
        return view('listDetail')->with('detail',$detail);
    }
    /**
     * @return the content of test view page 
     */
    public function testBlade()
    {
        return view('users.test');
    }
    public function test()
    {
        return view('users.test');
    }
    /**
     * Fetches the user data and encoding the data in json format
     * @return json 
     */
    public function testBootGrid(Request $request)
    {
        $object=DetailList::$details;//Fetch users data
       /** if(!empty($request->input('sort')))
        {
            $sortArr=$request->input('sort');
            foreach($sortArr as $key=>$val)
            {
                $index=$key;
                $order=$val;
            }
            if($order=="asc")
            {
                usort($myArray, function($a, $b) {
                return $a['order'] - $b['order'];
});
            }
        }*/
        $search = $request->input('searchPhrase');
        if($search=="")
        {
            $arr=array(
                "current"=> 1,
                "rowCount"=> 3,
                "rows"=> $object,
                "total"=> count($object)
            );
        }
        else
        {
            $var=0;
            $object1=array();
            foreach($object as $key=>$val)
            { 
                if($val['id']==$search || stripos($val['firstName'],$search ) !== false || stripos($val['lastName'], $search) !== false || stripos( $val['address'],$search) !== false )
                {
                    array_push($object1,$val);
                }
            }
            $arr=array(
                "current"=> 1,
                "rowCount"=> 3,
                "rows"=> $object1,
                "total"=> count($object1)
            );
        }
        $jsonObject=json_encode($arr);//Now convert user data into json data
       return $jsonObject;
    }
    public function testDatabase()
    {
        $object=new  Users();
        $detail=$object->setDatabaseConnection();
        $object -> addUser($detail);
       // $object -> deleteUser(4);
        $object -> doCompoundSearch("sriya92.banerjee@gmail.com","banerjee");
    }
    
}
