<?php
namespace src\Model;

use src\core\CustomException;
use src\Model\Model;

class Student extends Model
{
    public function __construct()
    {
        parent::__construct();
             
    }

    public function edit($data)
    {
      
         
               $bindArray=    array(
                       ':fname'   =>  $data["fname"],
                       ':lname' =>  $data["lname"],
                       ':dob'       =>  date("Y-m-d", strtotime($data['dob'])),
                       ':phone'       =>  $data["contact_no"],
                       ':country_code'       =>  $data["country_code"],
                       ':email'       =>  $data["email"],
                       ':updated'       =>  date('Y-m-d H:i:s'),
                        ':id'=> $data["student_id"]
                    );
               $setClause = "fname = :fname, lname = :lname, dob = :dob,phone = :phone,email=:email,country_code=:country_code,updated_at=:updated";
               $whereClause = "id = :id";
               $this->update("student", $setClause, $bindArray, $whereClause);
               return true;
       
    }

    public  function get_total_all_records()
    {
       
              $whereClause= "is_delete=0";
               $response =$this->readAll('student', $whereClause, []);
            $response = $response->fetchAll();
            return $response;
     
    }
    public  function get($request)
    {
      

           $whereClause= "is_delete=0";
               $response =$this->readAll('student', $whereClause, $request);
            $response = $response->fetchAll(\PDO::FETCH_ASSOC);
            return $response;
    
    }
    public  function getByID($id)
    {
      
             $whereClause = "id =:id AND is_delete=0";
             $bindArray = array(
                ':id'       =>  $id
                );
         
             $response =$this->readById('student', $bindArray, $whereClause, true);
              $response = $response->fetch(\PDO::FETCH_ASSOC);
             return $response;
       
    }
    public  function deleteRecord($id)
    {
      
           
             $bindArray =   array(
                ':delete'   =>  1,
                ':id'       =>  $id
                );
             $setClause = "is_delete = :delete";
             $whereClause = "id = :id";
             $this->delete('student', $setClause, $bindArray, $whereClause);
       
    }
    
    public function add($data)
    {
            $stuRegNo = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $bindArray = array(
                       ':fname'   =>  $data["fname"],
                       ':lname' =>  $data["lname"],
                       ':regno'       =>  $stuRegNo,
                       ':dob'       =>  date("Y-m-d", strtotime($data['dob'])),
                       ':phone'       =>  $data["contact_no"],
                       ':country_code'       =>  $data["country_code"],
                       ':email'       =>  $data["email"],
                       ':created_at'       =>  date('Y-m-d H:i:s'),
                       ':updated_at'       =>  date('Y-m-d H:i:s'),
                       
                    );
                $fieldList = '`fname`, `lname`,`reg_no`, `dob`,`phone`,`email`,`country_code`,`created_at`,`updated_at`';  
               $valueList =  ":fname,:lname,:regno,:dob,:phone,:email,:country_code,:created_at,:updated_at";
                $this->insert('student', $fieldList, $bindArray, $valueList);
      
            return true;
      
    }
}
