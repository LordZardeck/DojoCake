<?php
App::import('Helper', 'Form');

/**
 * Dojo Cake - Dijit Form helpers for CakePHP
 *
 * Provides methods for simplifying the process of creating Dojo forms withing CakePHP.
 * Includes methods for creating widjets for every form input type.       
 * 
 * PHP versions 4 and 5
 *
 * Copyright 2011, Black Fire Development (http://www.blackfireweb.com)
 *                        
 * @copyright     Copyright 2011, Black Fire Development (http://www.blackfireweb.com)
 * @link          http://dojocake.googlecode.com Dojo Cake Project
 * @version       1.3.1
 * @since         0.0.1
 * @author        Sean Templeton (LordZardeck), Phally
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class DijitFormHelper extends FormHelper {
/**
 * Other helpers used by FormHelper
 *
 * @var array
 * @access public
 */
    var $helpers = array('Js'=>array('Dojo'), 'Html');     
      
    function label($fieldName = null, $text = null, $options = array())
    {
        return parent::label($fieldName, $text, array_merge(array('class'=>'DojoFormLabel'), $options));
    }           
    
    function checkbox($fieldName, $options = array())
    {
        $this->Js->req('dijit.form.CheckBox');
        return parent::checkbox($fieldName, array_merge(array('dojoType'=>'dijit.form.CheckBox'), $options));
    }
    
    function radio($fieldName, $options = array(), $attributes = array())
    {
        $this->Js->req('dijit.form.RadioButton');
        return parent::radio($fieldName, $options, $attributes);
    }

    function text($name = null, $options = array())
    {              
        $this->Js->req('dijit.form.TextBox');
        return parent::text($name, array_merge(array('dojoType'=>'dijit.form.TextBox'), $options));                                   
    }
    
    function password($fieldName, $options = array())
    {
        $this->Js->req('dijit.form.TextBox');
        return parent::password($name, array_merge(array('dojoType'=>'dijit.form.TextBox'), $options));   
    }
    
    function textarea($name = null, $options = array())
    {                 
        $this->Js->req('dijit.form.Textarea');
        return parent::textarea($name, array_merge(array("width"=>"200px", 'dojoType'=>'dijit.form.Textarea'), $options));        
    }             
    
    function select($fieldName, $options = array(), $selected = null, $attributes = array())
    {
        $this->Js->req('dijit.form.FilteringSelect');
        return parent::select($fieldName, $options, $selected, array_merge(array('dojoType'=>'dijit.form.FilteringSelect'), $attributes));
    }

    function button($text = null, $options = array(), $dojoMethod = null)
    {
        if(is_null($options))
            $options = array();
        if(is_array($dojoMethod))
        {
            $code = $dojoMethod['code'];       
        }
        else
        {
            $code = $dojoMethod;
            $dojoMethod = array();
        }                                    
        $this->Js->req('dijit.form.Button');
        return parent::button($text . $this->Js->method($code, $dojoMethod), array_merge(array('dojoType'=>'dijit.form.Button'), $options));   
    } 
    
    function submit($caption = null, $options = array())
    {
        $this->Js->req('dijit.form.Button');
        return parent::submit($caption, array_merge(array('dojoType'=>'dijit.form.Button'), $options));
    }
    
    function dateTime($fieldName, $options = array())
    {
        $this->Js->req('dijit.form.DateTextBox');
        return parent::input($fieldName, array_merge(array('dojoType'=>'dijit.form.DateTextBox', 'type'=>'text'), $options));
    }  

    /**
    * Non-Conformed Functions. Work In Progress.        
    */
    /*
    function comboButton($buttons = array()){
        if(empty($buttons)){
            return null;
        }            
        $a = 1;
        $menuItems = "";
        foreach($buttons as $button){
            $button["content"] = $button["title"];
            unset($button["title"]);
            if($a == 1){
                $button["content"] = "<span>".$button["content"]."</span>";
                $combo = $button;
            }else{
                $menuItems .= $this->Js->divTag("dijit.MenuItem", $button); 
            }
            $a++; 
        }
        $menu = $this->Js->divTag("dijit.Menu", array("content"=>$menuItems, "toggle"=>"fade"));
        $combo["content"] .= $menu;
        return $this->Js->divTag("dijit.form.ComboButton", $combo);
    } 

    function validationTextBox($id = null, $label = true, $missingMsg = null, $required = true, $trim = true, $properCase = true, $parms = array())
    {
        if(is_null($id)){
            return null;
        }
        $parms["trim"] = $trim;
        $parms["propercase"] = $properCase;
        $parms["required"] = $required;
        $parms["missingMessage"] = $missingMsg;
        $parms["dojoType"] = "dijit.form.ValidationTextBox";
        $this->Js->req($parms["dojoType"]);
        return $this->textBox($id, $label, $parms);
    } 
    */    
}
?>
