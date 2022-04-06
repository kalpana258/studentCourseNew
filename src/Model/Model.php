<?php

namespace src\Model;

use src\core\DatabaseConnector;
use src\core\CustomException;


class Model
{
    
    public function __construct()
    {
        $this->dbInstance = DatabaseConnector::getInstance();
        $this->conn = $this->dbInstance->getConnection();
    }
    
    public function insert($tableName,$fieldList,$bindArray,$mapList)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO ".$tableName."(".$fieldList.") VALUES(".$mapList.")");
            foreach($bindArray as $key=>$bindParams){
                 $stmt->bindValue($key, $bindParams);
            }
            $stmt->execute();
        } catch (\PDOException  $exception) {
          
            if($exception->getCode() == 23000) {
               
                throw new CustomException("Record already exists. Phone number already exists");
            }else{
                throw new CustomException("Error in saving Data");
            }
           
        }catch (\Exception $exception) {
          
            throw new CustomException($exception->getMessage());
           
        }
    
    }
    
    
    public function update($tableName,$setClause,$bindArray,$whereClause)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE ".$tableName." SET ".$setClause." WHERE ".$whereClause."");
       
            foreach($bindArray as $key=>$bindParams){
                  $stmt->bindValue($key, $bindParams);
            }
            $stmt->execute();
        } catch (\PDOException  $exception) {
          
            if($exception->getCode() == 23000) {
               
                throw new CustomException("Record already exists. Phone number/Email already exists");
            }else{
                throw new CustomException("Error in saving Data");
            }
           
        }catch (\Exception $exception) {
          
            throw new CustomException($exception->getMessage());
           
        }
    }
    
    public  function delete($tablename,$setClause,$bindArray,$whereClause)
    {
        try{
            $statement = $this->conn->prepare("UPDATE ".$tablename." SET ".$setClause." WHERE ".$whereClause."");
            foreach($bindArray as $key=>$bindParams){
                $statement->bindValue($key, $bindParams);
            }
            $statement->execute();
        }catch (\PDOException  $exception) {
            var_dump($exception);
            exit;
           
             throw new CustomException("Error in deleting Data");
          
           
        }catch (\Exception $exception) {
         
          
            throw new CustomException($exception->getMessage());
           
        }
           
    }
    
    public  function readById($tablename,$bindArray,$whereClause)
    {
        try{
            $query = "SELECT * FROM ".$tablename." WHERE ".$whereClause." LIMIT 1";
         
            $stmt = $this->conn->prepare($query);
            $stmt->execute($bindArray);
            return $stmt;
        }catch (\PDOException  $exception) {
           
            throw new CustomException("Error in fetching Data");
         
          
        }catch (\Exception $exception) {
         
            throw new CustomException($exception->getMessage());
          
        }
    }
     
    public  function readAll($tablename,$whereClause,$request,$row=0,$rowperpage = '')
    {
        try{
            if(isset($request['num_rows'])) {
                $rowperpage = $request['num_rows'];
            }
            if(isset($request['page'])) {
                $row = $request['page'];
            }else{
                $row=1;
            }
            

            $query = "SELECT * FROM ".$tablename." WHERE ".$whereClause."";
            if($rowperpage !='') {
                $initial_page = ($row-1) * $rowperpage;
                        
                $query .= ' LIMIT ' .$initial_page. ', ' .$rowperpage;               
            }  
                
           
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
           
            return $stmt;
        }catch (\PDOException  $exception) {
           
            throw new CustomException("Error in fetching Data");
         
          
        }catch (\Exception $exception) {
         
            throw new CustomException($exception->getMessage());
          
        }
    }
}

