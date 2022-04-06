<?php
 
namespace src\core;
     
class Validator
{
        
        /**
         * @var array $patterns
         */
        public $patterns = array(
          'mobile' => '^[0-9]{10,11}$',
            'alpha'=> '^[a-zA-Z]+$',
           'alphanumeric'=> '^[a-zA-Z0-9]+$'
        );
        
        /**
         * @var array $errors
         */
        public $errors = array();
        public $sanitizeInput = array();
        
        
        /**
         * 
         * 
         * @param  string $name
         * @return this
         */
        public function name($name)
        {
            
            $this->name = $name;
            return $this;
        
        }
        
        /**
         * 
         * 
         * @param  mixed $value
         * @return this
         */
        public function value($value)
        {
            
          
            $this->value = $value;
            return $this;
        
        }

        // check age 
        public function checkDate($date)
        {
            $current_date =date_create("now");
            $interval = date_diff($current_date, date_create($date))->format('%y');
            if($interval <= 4) {
                $this->errors[] = "Minimum age required to register is 5 years";
            }
              
         
        }
        
        /*
         * Validation error message check 
         */
        public function pattern($name)
        {
              
               
            foreach($name as $validator){
               
                if(in_array($validator['name'], array_keys($this->patterns))) {
                    $regex = '/^('.$this->patterns[$validator['name']].')$/u';
                    if($this->value != '' && !preg_match($regex, $this->value)) {
                        $this->errors[] = isset($validator['msg'])?$validator['msg']
                            : 'Format of '.$this->name.' not valid';
                    }
                }else{
                          $this->callValidation($validator);
                }
            }
            return $this;
            
        }
        
        public function callValidation($validator)
        {
              switch($validator['name']):
            case('required'):
                $this->required($validator['value']);
                break;
            case('min'):
                $this->min($validator);
                break;
            case('max'):
                $this->max($validator);
                break;
            case('email'):
                $this->is_email($validator);
                break; 
            default :
                //
              endswitch;
                                  
        }
      
        
        /**
         * check for required field
         * 
         * @return this
         */
        public function required($value)
        {
            if(is_array($this->value)) {
                foreach($this->value as $val){
                    if(($val == '' || $val == null)) {
                        $this->errors[] = "Field ".$this->name." ".$value;
                    } 
                }
            }else{
                if(($this->value == '' || $this->value == null)) {
                    $this->errors[] = "Field ".$this->name." ".$value;
                }         
            }   
            return $this;
            
        }
        
        /**
         * Check for minimum length
         * 
         * @param  int $length
         * @return this
         */
        public function min($validator)
        {
            
            if(is_string($this->value)) {
                
                if(strlen($this->value) < $validator['value']) {
                
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Minimum ".$validator['value']." chars is allowed for ".$this->name;
                }
           
            }else{
                
                if($this->value < $validator['value']) {
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Minimum ".$validator['value']." digits is allowed for ".$this->name;
                }
                
            }
            return $this;
            
        }
            
        /**
         * 
         * 
         * 
         * @param  int $max
         * @return this
         */
        public function max($validator)
        {
            
            if(is_string($this->value)) {
                
                if(strlen($this->value) > $validator['value']) {
                    
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Maximum ".$validator['value']." chars is allowed for ".$this->name;
              
                }
           
            }else{
                
                if($this->value > $validator['value']) {
                    $this->errors[] = isset($validator['msg'])?$validator['msg']
                            :"Maximum ".$validator['value']." digits is allowed for ".$this->name;
                }
                
            }
            return $this;
            
        }
        
    
        
        /**
         * 
         * 
         * @return boolean
         */
        public function isSuccess()
        {
            if(empty($this->errors)) { return true;
            }
        }
        
        /**
         * 
         * 
         * @return array $this->errors
         */
        public function getErrors()
        {
            if(!$this->isSuccess()) { return $this->errors;
            }
        }
        
       
        
     
        
        /**
         * un'e-mail
         *
         * @param  mixed $value
         * @return boolean
         */
        public function is_email($validator)
        {
            if(!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
                   $this->errors[] =isset($validator['msg'])?$validator['msg']:
                       "Please enter valid email.";
            }      
                    
        }
 
        
}
