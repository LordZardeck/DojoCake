<?php

class ResponseHelper extends AppHelper
{
    function encode($data = array())
    {
        return json_encode($data);
    }
    
    function server_response($data = array())
    {
        if(empty($data))
        {
            return null;
        }
        
        $response = array();
        if($data['type'] == 'error')
        {
            if(!$data['message'])
            {
                $response['message'] = 'There was an error retrieving a response from the server. Please try again.';
            }
            else
            {
                $response['message'] = $data['error'];
            }
            $response['sucess'] = 'false';
        }
        else
        {
            $response['sucess'] = 'true';
        }
        if($data['message'])
        {
            $response['message'] = $data['message'];
        }
        if(!$data['type'])
        {
            $data['type'] = 'alert';
        }
        
        unset($data['error']);
        unset($data['message']);
        $response = array_merge($data, $response);
        
        return $this->encode($response);
    }
}

?>
