<?php
            
/**
 * Dojo Cake - Core Dojo helpers for CakePHP
 *
 * Provides methods for simplifying the process of creating Dojo applications withing CakePHP.
 * Includes methods for creating widjets and for including the files nesicary to run Dojo.
 * Remember to copy the dojo file exactly the way they are provided, or change the paths defined at the
 * beginning of this class. 
 * 
 * PHP versions 4 and 5
 *
 * Copyright 2011, Black Fire Development (http://www.blackfireweb.com)
 *                        
 * @copyright     Copyright 2011, Black Fire Development (http://www.blackfireweb.com)
 * @link          http://dojocake.googlecode.com Dojo Cake Project
 * @version       1.3.1
 * @since         0.0.1
 * @author        Sean Templeton (LordZardeck)
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class DojoEngineHelper extends JsBaseEngineHelper {
/**
* Dojo's css selector
*     
* @var mixed
*/
    var $query = "dojo.query(%s)";
    var $funcWrap = "(function(){%s})();";
/**
* Provides built-in helpers to allow for easier coding of Dojo functions
* 
* @var array
*/
    var $helpers = array('Html');         
    
/**
* An array containg the src directories for Dojo libraries.                                                        
*/
    var $srcDirs = array();

/**
* An array of all the Dojo components and widgets to be loaded. Holds all of the "dojo.require()" calls
* till used by DojoHelper::getReq().
* 
* @var mixed
*/
    var $_requires = array();

/**
 * Option mappings for jQuery
 *
 * @var array
 */
    var $_optionMap = array(
        'request' => array(      
            'type' => 'handleAs',
            'success' => 'load',
            'complete' => 'load',
            'async' => 'sync',
            'data' => 'content'
        )
    );

/**
 * callback arguments lists
 *
 * @var string
 */
    var $_callbackArguments = array(   
        'request' => array(                  
            'error' => 'request, ioArgs',
            'load' => 'request, ioArgs', 
            'handle' => 'request, ioArgs',                   
            'xhr' => ''
        )
    );        
/**
* Starts up the DojoHelper by setting up the needed parser and theme files
*     
* @param array $options Start-Up configuration
*/
    function start($options = array())
    {        
        $this->srcDirs['dojo'] = (Configure::read('DojoSrc.Dojo'))? Configure::read('DojoSrc.Dojo') : JS_URL . 'dojo/';
        $this->srcDirs['dijit'] = (Configure::read('DojoSrc.Dijit'))? Configure::read('DojoSrc.Dijit') : JS_URL . 'dijit/';
        $this->srcDirs['dojox'] = (Configure::read('DojoSrc.Dojox'))? Configure::read('DojoSrc.Dojox') : JS_URL . 'dojox/';
                                                             
        $options = array_merge(array('theme'=>'tundra', 'debug'=>false, 'parseOnLoad'=>'true', 'isDebug'=>'false', 'baseUrl'=>$this->webroot($this->srcDirs['dojo']), 'debugAtAllCosts'=>'false'), $options);
        echo $this->Html->scriptBlock(null, array('djConfig'=> "parseOnLoad:" . $options['parseOnLoad'] . ', isDebug:' . $options['isDebug'] . ', debugAtAllCosts:' . $options['debugAtAllCosts'] . ', baseUrl:\'' . $options['baseUrl'] . '\'', 'src'=> (Configure::read('DojoSrc.CDN') === true)? 'http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojo/dojo.xd.js' : $this->webroot($this->srcDirs['dojo'] . 'dojo.js'), 'inline'=>true, 'safe'=>false));  
        echo $this->css("dojo", "dojo", array("inline"=>true));    
        echo $this->req("dojo.parser", true);   
        
        if(strstr($options['theme'], ".css"))
            $css = sprintf('/%sthemes/%s', $this->srcDirs['dijit'], $options['theme']);    
        else
            $css = sprintf('/%sthemes/%s/%s.css', $this->srcDirs['dijit'], $options['theme'], $options['theme']);        
        echo $this->Html->css($css);         
        echo $this->Html->scriptBlock($this->domReady($this->get("body")->selection . ".attr('class', '{$options['theme']}');", array("inline"=>true)), array("inline"=>true, 'safe'=>false));                  
    }         
  
/**
* Adds a component to the DojoHelper::_requires array if it is not already there.
*   
* @param string $component   The name of the component to require.
*/
    function req($component, $inline = false)
    {
        if(!in_array($component, $this->_requires) && !$inline)
            $this->_requires[] = $component;    
        elseif(!$inline)
            return null;
        
        return $this->Html->scriptBlock('dojo.require("'.$component.'");', array("safe"=>false, "inline"=>$inline));
    }
  
/**
* Adds a css file needed to render an component correctly.
* 
* @param mixed $file      The file to be loaded. If not specified as an actual file, it will load the css
*                         from the projects default folder, "resources/".  
* @param mixed $project   The project the css file is to be loaded from. Defaults to "dojo".
*/
    function css($file, $project = "dojo", $options = array()){
        if(!$file){
            return null;
        }
        $options = array_merge(array("inline"=>false), $options);
        if(strstr($file, ".css")){
            $css = "/".$this->srcDirs[$project].$file;
        }else{
            $css = "/".$this->srcDirs[$project]."resources".'/'.$file.".css";
        }
        if($options["inline"]){
            return $this->Html->css($css)."\n";
        }else{
            $view =& ClassRegistry::getObject('view'); 
            $view->addScript($this->Html->css($css));
        }
    }
  
/**
* Parses the type parameter and requires the dojo component.
*   
* @param string $typeName   The name of the component.
* @return string
*/
    function type($typeName){
        $this->req($typeName);
        
        return "dojoType=\"$typeName\"";
    }
  
/**
* Parses an array of paremeters and returns a string to be placed withing a HTML tag.
*   
* @param array $parms   An array of parameters in the format parameterName=>parameterValue.
* @return string $string
*/
    function parseParms($parms = array()){
        if(empty($parms)){
            return null;
        }
        $string = "";  
        $i = 0;       
        if(is_array($parms)){
            foreach($parms as $key=>$value){   
                if($i>0){
                    $string .= " ";
                }
                $string .= "$key=\"$value\"";  
                $i++;
            }
        }else{
            $string .= " $key=\"$value\"";
        }
        return $string;
    }

/**
* Creates a <div></div> tag, parsing the options and requiring the dojoType provided. Used mainly by widgets.
*   
* @param string $type    A string containing the type of the dojo widget
* @param array $parms   Parameters to be assigned as attributes. The content parameter is filtered out and placed inside the div tags.
* @return string
*/
    function divTag($type = null, $parms = array()){
        $defaults = array("dojoType"=>null, "content"=>null);
        $parms = array_merge($defaults, $parms);
        if(!is_null($type)){
            $parms["dojoType"] = $type;
            $this->req($type);
        }
        if(isset($parms["content"]) || is_null($parms["content"])){
            $content = $parms["content"];
            unset($parms["content"]);
        }
        return sprintf($this->Html->tags["block"], " ".$this->parseParms($parms), $content);
    }      
    
/**
 * Add an event to the script cache. Operates on the currently selected elements.
 *
 * ### Options
 *
 * - 'wrap' - Whether you want the callback wrapped in an anonymous function. (defaults true)
 * - 'stop' - Whether you want the event to stopped. (defaults true)
 *
 * @param string $type Type of event to bind to the current dom id
 * @param string $callback The Javascript function you wish to trigger or the function literal
 * @param array $options Options for the event.
 * @return string completed event handler
 */
    function event($type, $callback, $options = array()) {
        $defaults = array('wrap' => true, 'stop' => true);
        $options = array_merge($defaults, $options);

        $function = 'function (event) {%s}';
        if ($options['wrap'] && $options['stop']) {
            $callback .= "\nreturn false;";
        }
        if ($options['wrap']) {
            $callback = sprintf($function, $callback);
        }                     
        return sprintf('dojo.connect(%s, "%s", %s);', $this->selection, $type, $callback);
    } 
    
/**
 * Create javascript selector for a CSS rule
 *
 * @param string $selector The selector that is targeted
 * @return object instance of $this. Allows chained methods.
 */
    function get($selector) 
    {    
        if ($selector == 'window' || $selector == 'document') {
            $this->selection = sprintf($this->query, $selector) ;
        } else {
            $this->selection = sprintf($this->query, "'$selector'");
        }
        if(strpos($selector, "#") == 0 && strpos($selector, "#") !== false)
        {
            $this->selection .= "[0]";
        }
        return $this;
    }

/**
 * Create a domReady event. This is a special event in many libraries
 *
 * @param string $functionBody The code to run on domReady
 * @return string completed domReady method
 */
    function domReady($functionBody, $options = array()) { 
        $defaults = array('inline' => false);
        $options = array_merge($defaults, $options); 
        
        $domReady = sprintf("dojo.addOnLoad(function(){%s});", $functionBody);
        
        if($options["inline"] === false){
            $this->Html->scriptBlock($domReady, array("safe"=>false, "inline"=>false));
        }else{
            return $domReady;
        }     
    }
    
/**
 * Create an iteration over the current selection result.
 *
 * @param string $method The method you want to apply to the selection
 * @param string $callback The function body you wish to apply during the iteration.
 * @return string completed iteration
 */
    function each($callback) {
        return $this->selection . '.forEach(function(item) {' . $callback . '});';
    } 
    
/**
 * Serialize a form attached to $selector. If the current selection is not an input or
 * form, errors will be created in the Javascript.
 *
 * @param array $options Options for the serialization
 * @return string completed form serialization script
 * @see JsHelper::serializeForm() for option list.
 */
    function serializeForm($options = array()) {
        $options = array_merge(array('isForm' => false, 'inline' => false), $options);
        $selector = $this->selection;
        if (!$options['isForm']) {
            $selector = sprintf("dojo.formToQuery(%s)", $this->selection);
        }                      
        if (!$options['inline']) {
            $selector .= ';';
        }
        return $selector;
    }
    
/**
 * Create a Dojo.xhr() call.
 *
 * If the 'update' key is set, success callback will be overridden.
 *
 * @param mixed $url
 * @param array $options
 * @return string The completed ajax call.
 */
    function request($url, $options = array()) 
    {
        $url = $this->url($url);
        $options = $this->_mapOptions('request', $options);
        
        if (isset($options['content']) && is_array($options['content'])) 
            $options['content'] = $this->_toQuerystring($options['content']);
        
        if($options["handleAs"] == 'html')
            $options["handleAs"] = "text";
        
        if(isset($options["method"]))
        {
            $method = $options["method"];
            unset($options["method"]);
        }
        else
            $method = "post";
        
        $options['url'] = $url;
        if (isset($options['update'])) 
        {
            $options["handleAs"] = "text";
            $wrapCallbacks = isset($options['wrapCallbacks']) ? $options['wrapCallbacks'] : false;
            unset($options['wrapCallbacks']);
            if ($wrapCallbacks === false) {
            $success = 'dojo.byId("' . $options['update'] . '").innerHTML = request;';
            } else {
            $success = 'function (request, ioArgs) {dojo.byId("' . $options['update'] . '").innerHTML = request;}';
            }
            $options['dataType'] = 'text';
            $options['handle'] = $success;
            unset($options['update']);
        }
        
        $callbacks = array('load', 'error', 'handle');
        if (isset($options['dataExpression'])) 
        {
            $callbacks['load'] = $options['content'];
            unset($options['content']);
            unset($options['dataExpression']);
        }
        
        $options = $this->_prepareCallbacks('request', $options);
        $options = $this->_parseOptions($options, $callbacks);
        return 'dojo.xhr("' . strtoupper($method) . '", {' . $options .'});';
    }
    
/**
* Create a dojo method script block
* 
* @param mixed $code The code to embed in the block
* @param mixed $params Options to be rendered to block
* @return string The script block
*/
    function method($code = null, $params = array())
    {
        return $this->scriptType($this->Html->scriptBlock($code, array_merge(array('inline'=>true, 'escape'=>false, 'safe'=>false, 'event'=>'onClick', 'args'=>'args'), $params)), 'dojo/method');
    }
    
/**
* Change the script block type. Defaults to 'dojo/method'
* 
* @param mixed $src The string to be replaced
* @param mixed $type The block type
* @return mixed The Script block
*/                               
    function scriptType($src, $type = 'dojo/method')
    {
        return str_replace('type="text/javascript"', 'type="' . $type . '"', $src);
    }
}
?>
