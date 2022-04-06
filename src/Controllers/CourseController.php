<?php

namespace src\Controllers;

use src\Model\Course;
use src\core\Views;
use src\core\CustomException;
use src\core\Validator;


class CourseController
{
    
    public function __construct()
    {
         $this->validator = new Validator();
         $this->course = new Course();
    }
  
    public function validate($requestData){
        $this->validator->name('Course Name')->value($requestData['courseName'])
        ->pattern([
            ['name'=>'required','value'=>'required'],
      
           ]);

   $this->validator->name('Course Details')->value($requestData['courseDetails'])
        ->pattern([
            ['name'=>'required','value'=>'required']
         
           ]);
    }
     /**
     * This method create the course
     *
     *
     */
    public function createCourse()
    {
        try {
         if (isset($_POST['submit'])) {
             $this->validate($_POST);
             if(!empty($this->validator->getErrors())){
                    $view = new Views('course/index.php');
                    $view->assign('errors',$this->validator->getErrors());
                     $view->assign('postData',$_POST);
                    return;
             }else{
                $_POST['courseName'] = filter_var($_POST['courseName'], FILTER_SANITIZE_STRING);
                $_POST['courseDetails'] = filter_var($_POST['courseName'], FILTER_SANITIZE_STRING);
                  $_POST['courseDetails']  = filter_var($_POST['courseDetails'], FILTER_SANITIZE_SPECIAL_CHARS);
            
                $save = $this->course->add($_POST);
                if ($save) {
                     $view = new Views('course/index.php');
                    $view->assign('success', 'Data saved successfully.');
                    return;
                } else {
                    $view = new Views('course/index.php');
                    $view->assign('errors', 'There is issue in saving the data in Database. Please try again.');
                    $view->assign('postData',$_POST);
                    return ;
                }
             }
          
         }
           $view = new Views('course/index.php');
         
           return;
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
     /**
     * This method list all the courses
     *
     *
     */
    public function list()
    {
        try {
            $view = new Views('course/view.php');
        } catch (CustomException $e) {
            echo   $e->customFunction();
        }
    }
      /**
     * This method loads view for the list
     *
     *
     */
    public function delete()
    {
        try {
            $id = $_POST['course_id'];
            $res = $this->course->deleteRecord($id);
            echo json_encode(["success"=>true]);
        } catch (CustomException $e) {
            echo json_encode(["success"=>false,"message"=>"Delete is not successfull.Please try again"]);
        }
    }
    
      /**
     * This method edit the course
     *
     *
     */
    public function edit()
    {
      
        try{
        if (isset($_POST['submit'])) {
            $this->validate($_POST);
            if(!empty($this->validator->getErrors())){
                   $view = new Views('course/index.php');
                   $view->assign('errors',$this->validator->getErrors());
                    $view->assign('postData',$_POST);
                    $view->assign("id",$_POST['course_id']);
                   return;
            }else{
               $_POST['courseName'] = filter_var($_POST['courseName'], FILTER_SANITIZE_STRING);
               $_POST['courseDetails'] = filter_var($_POST['courseDetails'], FILTER_SANITIZE_STRING);
                 $_POST['courseDetails']  = filter_var($_POST['courseDetails'], FILTER_SANITIZE_SPECIAL_CHARS);
           
               $save = $this->course->edit($_POST);
               if ($save) {
                
                    header('Location: /courseList');
                  
               } else {
                   $view = new Views('course/index.php');
                   $view->assign('errors', ['There is issue in saving the data in Database. Please try again.']);
                   $view->assign('postData',$_POST);
                   $view->assign("id",$_POST['course_id']);
                   return ;
               }
            }
         
        }
        $courseData = $this->course->getById($_POST['course_id']);
          $view = new Views('course/index.php');
          $view->assign('postData',["courseName"=>$courseData['name'],"courseDetails"=>$courseData['details']]);
          $view->assign("id",$_POST['course_id']);
        
          return;
       } catch (CustomException $e) {
           echo   $e->customFunction();
       }
    }
      /**
     * This method list all the courses
     *
     *
     */
    public function getList()
    {
    
        try {
            
            $records = $this->course->get($_POST);
            $limit = $_POST['num_rows'];
            $totalcount =  count($this->course->get_total_all_records());
           
            $total_pages = ceil ($totalcount / $limit);
            if (!isset ($_POST['page']) ) {  

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
