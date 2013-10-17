<?php

define('RT_MESSAGE', 0);
define('RT_ERROR', 1);
define('RT_BOOL', 2);
define('RT_DATA', 3);

class ResponseComponent extends Object
{
    var $errors = array();
    var $messages = array();  
    var $data = array(); 
    var $type = null;
    var $controller = null;         
    
    function initialize(&$controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller =& $controller;
    }

    
    function message($message = null)
    {
        if(!is_null($message))
            $this->messages[] = $message;
    }
    
    function error($error = null)
    {
        if(!is_null($error))
        {
            $this->errors[] = $error;
            $this->type = RT_ERROR;
        }
    }        
    
    function data($data)
    {
        if(is_array($data) && !empty($data))
            $this->data = $this->data + $data;                  
        elseif(!is_array($data) && !is_null($data))
            $this->data[] = $data;
    }
    
    function render()
    {
        //Set defaults
        $response = array('status' => 200, 'message' => null, 'type' => RT_ERROR, 'data' => null, 'callback' => null);      
                                               
        if(!empty($this->data))
        {
            if(is_null($this->type))
                $this->type = RT_DATA;
            $response['data'] = $this->data;
        }
        if(!empty($this->errors))
        {
            $this->messages = $this->messages + $this->errors;
            $response['type'] = RT_ERROR;   
        }     
        if(!empty($this->messages))
        {
            $response['message'] = implode(' ', $this->messages);          
        }
        if(!is_null($this->type))
            $response['type'] = $this->type;
        elseif(!empty($this->messages))
            $response['type'] = RT_MESSAGE;
                
        $this->controller->layout = 'ajax';
        $this->controller->set('data', $response);
        $this->controller->render('/elements/response');
    }
}

?>
