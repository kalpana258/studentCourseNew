<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\core\CustomException;
use src\core\Validator;
use src\Helper;

class StudentRegistrationController
{
    
    public function __construct()
    {
        $this->validator = new Validator();
        $this->student = new Student();
    }
 
   
    /**
     * This method create student
     */
    public function createStudent()
    {
        try {
            $helper = new Helper();
            $countryCodes = $helper->getCountryCodes();
         
            if (isset($_POST['submit'])) {
                $this->validate($_POST);
                if(!empty($this->validator->getErrors())) {
                    $view = new Views('studentReg/index.php');
                    $view->assign('errors', $this->validator->getErrors());
                     $view->assign('postData', $_POST);
                     $view->assign('countryCodes', $countryCodes);
                    return;
                }else{
                    $_POST['fname'] = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                    $_POST['lname'] = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                    $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              
                    $save = $this->student->add($_POST);
                    if ($save) {
                        $view = new Views('studentReg/index.php');
                        $view->assign('success', 'Data saved successfully.');
                        $view->assign('countryCodes', $countryCodes);
                        return;
                    } else {
                        $view = new Views('studentReg/index.php');
                        $view->assign('errors', 'There is issue in saving the data in Database. Please try again.');
                        $view->assign('postData', $_POST);
                        $view->assign('countryCodes', $countryCodes);
                        return ;
                    }
                }
          
            }
            $view = new Views('studentReg/index.php');
            $view->assign('countryCodes', $countryCodes);
            return;
        
        } catch (CustomException $e) {
           
            echo   $e->customFunction($e);
          
        }
    }
    /**
     * This method list the students
     */
    public function list()
    {
        try {
            $view = new Views('studentReg/view.php');
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
    /**
     * This method delete the student
     */
    public function delete()
    {
        try {
            $id = $_POST['student_id'];
            $res = $this->student->deleteRecord($id);
            echo json_encode(["success"=>true]);
        } catch (CustomException $e) {
            echo json_encode(["success"=>false,"message"=>"Delete is not successfull.Please try again"]);
        }
    }
   
    /**
     * This method edit the student
     */
    public function edit()
    {
        try {
            $helper = new Helper();
            $countryCodes = $helper->getCountryCodes();
            if (isset($_POST['submit'])) {
                $this->validate($_POST);
                if(!empty($this->validator->getErrors())) {
                    $view = new Views('studentReg/index.php');
                    $view->assign('errors', $this->validator->getErrors());
                     $view->assign('postData', $_POST);
                     $view->assign('countryCodes', $countryCodes);
                     $view->assign('id', $_POST['student_id']);
                    return;
                }else{
                     $_POST['fname'] = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                    $_POST['lname'] = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                    $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                     $save =  $this->student->edit($_POST);

                    if ($save) {
                        header('Location: /');
                    } else {
                        $view = new Views('studentReg/index.php');
                        $view->assign('errors', 'There is issue in saving the data in Database. Please try again.');
                        $view->assign('postData', $_POST);
                        $view->assign('countryCodes', $countryCodes);
                        $view->assign('id', $_POST['student_id']);
                        return ;
                    }
                      
                }
            }
            $studentData = $this->student->getById($_POST['student_id']);
            $view = new Views('studentReg/index.php');
            $view->assign('countryCodes', $countryCodes);
            $view->assign('postData', $studentData);
            $view->assign('id', $_POST['student_id']);
            return;
           
        } catch (CustomException $e) {
            echo   $e->customFunction($e);
        }
    }
    
    public function validate($requestData)
    {
         $this->validator->name('First Name')->value($requestData['fname'])
            ->pattern(
                [
                   ['name'=>'alpha','value'=>'Alphabets',"msg"=>"Only Alphabets is allowed for First Name."],
                   ['name'=>'required','value'=>'required'],
                   ['name'=>'min','value'=>4,"msg"=>"Please enter minimum 4 chars for First Name."],
                   ['name'=>'max','value'=>50, "msg"=>"Please enter minimum 4 chars for First Name."]
                   ]
            );
       
          $this->validator->name('Last Name')->value($requestData['lname'])
            ->pattern(
                [
                  ['name'=>'alpha','value'=>'Alphabets',"msg"=>"Only Alphabets is allowed for Last Name."],
                   ['name'=>'required','value'=>'required'],
                   ['name'=>'min','value'=>4,"msg"=>"Please enter minimum 4 chars for Last Name."],
                   ['name'=>'max','value'=>50,"msg"=>"Maximum 50 chars are allowed for Last Name"],
                   ]
            );
          
             $this->validator->name('Mobile Number')->value($requestData['contact_no'])
                ->pattern(
                    [
                    ['name'=>'mobile','value'=>'Mobile',"msg"=>"Please enter valid Mobile number."],
                    ['name'=>'required','value'=>'required'],
                    ['name'=>'min','value'=>10,"msg"=>"Please enter minimum 10 digits for Mobile No."],
                    ['name'=>'max','value'=>10,"msg"=>"Maximum 10 digits are allowed for Mobile No."],
                    ]
                );
             $this->validator->name('Email')->value($requestData['email'])
                ->pattern(
                    [
                    ['name'=>'email','value'=>'Email'],
                    ['name'=>'required','value'=>'required'],
                    ]
                );
             $this->validator->checkDate($requestData['dob']);
    }
    /**
     * This method get list of student
     */
    public function getList()
    {
        try {
            $records = $this->student->get($_POST);
            $limit = $_POST['num_rows'];
            $totalcount =  count($this->student->get_total_all_records());
            $total_pages = ceil($totalcount / $limit);
            if (!isset($_POST['page']) ) {  

                $page_number = 1;  
        
            } else {  
        
                $page_number = $_POST['page'];  
        
            }                
            $data = array(); 
            $output = array(       
                "data"              =>  $records,
                "total"             =>  $totalcount,
                "page"              =>  $page_number,
                "total_pages"       =>  $total_pages
                );
            echo json_encode($output);
        } catch (CustomException $e) {
            $output = array(       
                "data"              =>  'error',
                "total"             =>  0,
                "page"              =>  1,
                "total_pages"       =>  0
                );
            echo json_encode($output);
        }
    }
}
