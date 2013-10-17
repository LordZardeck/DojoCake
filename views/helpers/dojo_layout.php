<?php
/**
 * Dojo Cake - Layout Helpers
 *
 * Provides methods for simplifying the process of creating Dojo layouts withing CakePHP. Uses the container
 * pane helper to build the layout.
 * 
 * PHP versions 4 and 5
 *
 * Copyright 2009, Black Fire Development (http://www.blackfireweb.com)
 *                       
 * @copyright     Copyright 2009, Black Fire Development (http://www.blackfireweb.com)
 * @link          http://dojocake.googlecode.com Dojo Cake Project
 * @version       0.0.12
 * @since         0.0.1 
 * @author        Sean Templeton (LordZardeck) 
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
  class DojoLayoutHelper extends AppHelper {
/**
* Helpers needed by the class. Dojo and ContainerPane is required.
* 
* @var array
*/
      var $helpers = array('Dojo');

/**
* Creates a BorderContainer widget based on an array of content panes. Content panes must have a region parameter in order to work. The
* rejion parameter can be either left, leading, top, heading, right, trailing, footer, bottom, or center.
*       
* @param mixed $rejions
* @param mixed $design  States wither or not the heading will cut off the sidebars or not. To have the heading span the width of the 
* border container, state "heading". To have the sidebars span the hieght of the container, specify "sidebar".
* @param array $parms
* @return string
*/
      function borderContainer($rejions = array(), $parms = array()){
          if(empty($rejions)){
              return null;
          }
          $defaults = array("width"=>"100%", "height"=>"100%", "design"=>"heading");
          $parms = array_merge($defaults, $parms);
          if(empty($parms["style"])){
              $parms["style"] = "height: ".$parms["height"]."; width: ".$parms["width"];
          }                           
          $borderContainer = "";    
          foreach($rejions as $key=>$value){
              $containerParms = $value["parms"];
              $containerParms["region"] = $key;
              $borderContainer .= $this->contentPane($value["content"], $containerParms);
          }                         
          $parms["content"] = $borderContainer;
          return $this->Dojo->divTag("dijit.layout.BorderContainer", $parms);
      }

/**
* Depriciated. Alias for DojoLayoutHelper::borderContainer()
* 
* @param mixed $rejions
* @param mixed $design
* @param array $parms
*/
      function layout($rejions = array(), $design = "heading", $parms = array()){
          $defaults = array("design"=>$design);
          $parms = array_merge($defaults, $parms);
          return $this->borderContainer($rejions, $parms);
      }

/**
* Depriciated. Alias for DojoLayoutHelper::contentPane()
*       
* @param mixed $content
* @param mixed $parms
*/
      function container($content = null, $parms = array()){
          return $this->contentPane($content, $parms);
      }

/**
* Creates a simple content pane widget wrapper for content.
*       
* @param mixed $content
* @param mixed $parms
*/
      function contentPane($content = null, $parms = array()){
          if(is_null($content)){
              return null;
          }
          $parms["content"] = $content; 
          return $this->Dojo->divTag("dojox.layout.ContentPane", $parms);
      }
      
/**
* Creates a tab container and creates the tabs passed in the $tabs variable and parses any parameters as attributes of the tab container.
* 
* @param array $tabs    An array of the tabs. It is recommened that you pass content panes as tabs.
* @param array $parms   Parameters to be parsed as attributes of the tab container.
*/
      function tabContainer($tabs = array(), $parms = array()){
          $tabDefaults = array("class"=>"tabContainer", "width"=>"400px", "height"=>"300px");
          $parms = array_merge($tabDefaults, $parms);                                                           
          if(empty($parms["style"])){
              $parms["style"] = "height: ".$parms["height"]."; width: ".$parms["width"];
          }                                                                                                          
          foreach($tabs as $tab){
              $parms["content"] .= $tab;
          };
          return $this->Dojo->divTag("dijit.layout.TabContainer", $parms);
      }
      
      function accordion($panes = array(),$parms = array()){                             
          foreach($panes as $pane){
              $parms["content"] .= $pane;
          }
          return $this->Dojo->divTag("dijit.layout.AccordionContainer", $parms);
      }
  }
?>
