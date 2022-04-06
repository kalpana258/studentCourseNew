<?php

namespace src\Controllers;

use src\Model\Student;
use src\core\Views;
use src\Model\Course;
use src\Model\StudentCourseMapping;
use src\core\CustomException;
use src\core\Validator;

class StudentCourseMappingController
{
    
    public function __construct()
    {
           $this->student = new Student();
           $this->mapp = new StudentCourseMapping();
         $this->course = new Course();
         $this->validator = new Validator();
    }
      
      /**
       * This method save student course mapping
       */
    public function createStudentCourseMapping()
    {
        try {
            
            $studentDropdown = $this->student->get_total_all_records();
            $courseDropdown = $this->course->get_total_all_records();
            if (isset($_POST['submit'])) {
               
                $this->validator->name('Student')->value($_POST['student'])->required('required');
                $this->validator->name('course')->value($_POST['course'])->required('required');
               
                if(!empty($this->validator->getErrors())) {
                    $view = new Views('studentCourseMap/mapping.php');
                    $view->assign('errors', $this->validator->getErrors());
                    //  $view->assign('postData',$_POST);
                     $view->assign('studentdropdown', $studentDropdown);
                     $view->assign('courseDropdown', $courseDropdown);
                    return;
                }else{
                    $requestData = $_POST;
                     $result = $this->mapp->storeStudentCourseMapping($requestData);
                    if($result) {
                           header('Location: /report');
                    }else{
                        $view = new Views('studentCourseMap/mapping.php');
                        $view->assign('errors', "There is some error while saving");
                        //$view->assign('postData',$_POST);
                        $view->assign('studentdropdown', $studentDropdown);
                        $view->assign('courseDropdown', $courseDropdown);
                    }
                }
                
            }

            $view = new Views('studentCourseMap/mapping.php');
            $view->assign('studentdropdown', $studentDropdown);
            $view->assign('courseDropdown', $courseDropdown);

        } catch (CustomException $e) {
            echo   $e->customFunction($e);
        }
    }
     /**
      * This method get the student course mapping
      */
    public function getStudentCourseSubscription()
    {
      
        try {
            $response = $this->mapp->getStudentCourseMapping();
            $view = new Views('studentCourseMap/report.php');
            $view->assign('response', $response);
        } catch (CustomException $e) {
            echo   $e->customFunction($e);
        }
    }
}
