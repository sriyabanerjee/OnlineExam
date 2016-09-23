<?php
/**
 * fileName: DetailList.php
 * @package app\DetailList.php
 * @author Sriya Banerjee<sriyab@mindfiresolutions.com>
 * created on 15 th sep, 2016
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * DetailList class, a container for the details of users
 */

class DetailList extends Model
{
    
    public static $details = array( 
            0 => array (
               "id" =>1,
               "firstName" => "Sriya",
               "lastName" => "Banerjee",	
               "address" => "Barasat"
            ),
            
            1 => array (
                "id" =>3,
               "firstName" => "Jayita",
               "lastName" => "Das",
               "address" => "Kolkata"
            ),
            
            2 => array (
                "id" =>2,
               "firstName" => "Rajat",
               "lastName" => "Roy",
               "address" => "Badu"
            ),
            3 => array (
                "id" =>4,
               "firstName" => "Shyam",
               "lastName" => "Roy",
               "address" => "Garia"
            ),
    );
    /**
     * For the given id , user details will be returned
     * @param $id
     * @return array
     */
    public function showDetails($id)
    {
        foreach(self::$details as $key=>$value)
        {
            if($key==$id)
            {
                return $value;
            }
        }
    }
}
