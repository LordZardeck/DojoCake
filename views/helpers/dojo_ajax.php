<?php
class DojoAjaxHelper extends AppHelper {
    var $helpers = array('Dojo');

    function Updater($formId = null, $contentId = null){
        if(is_null($formId) || is_null($contentId)){
            return null;
        }
        return "dojo.xhrPost({
                form: \"$formId\",
                handle: function(response, ioArgs){     
                    dojo.byId(\"$contentId\").innerHTML = response;
                }
        });";
    }

    function Grid($headers = array(), $url = null, $id = null, $parms = array()){
        if(empty($headers) || is_null($url) || !isset($parms["query"])){
            return null;
        }
        if(is_null($id)){
            $id = "dojoGrid".rand(1, 999);
        }       
        if(isset($parms["width"])){
            $width = $parms["width"];
            unset($parms["width"]);
        }else{
            $width = "550px";
        }   
        if(isset($parms["height"])){
            $height = $parms["height"];
            unset($parms["height"]);
        }else{
            $height = "200px";
        }                                                     
        $store = $this->Dojo->divTag("dojo.data.ItemFileReadStore", array('jsId'=>$id."Store", 'url'=>$this->webroot($url)));
        $this->Dojo->req("dojox.grid.DataGrid");
        $parms["id"] = $id;
        $parms["store"] = $id."Store";
        $parms["dojoType"] = "dojox.grid.DataGrid";
        if(!isset($parms["clientSort"])){ 
            $parms["clientSort"] = "true";
        }
        $table = "<table ".$this->Dojo->parseParms($parms)."><thead><tr>";
        foreach($headers as $header){
            $table .= "<th field=\"{$header["field"]}\">{$header["title"]}</th>";
        }
        $table .= "</thead></table>"; 
        $style = "<style>#$id { 
                        border: 1px solid #333;
                        width: $width;
                        margin: 10px;
                        height: $height;
                        font-size: 0.9em;
                        font-family: Geneva, Arial, Helvetica, sans-serif;    
                    }</style>";
        return $style.$store."\n".$table;
    }
    
    function store($options = array()){
        if(!isset($options["id"]) || !isset($options["data"])){
            return null;
        }
        $store["identifier"] = $options["id"];
        if(isset($options["label"])){
            $store["label"] = $options["label"];
        }
        $store["items"] = $options["data"];
        return json_encode($store);
        
    }
}
?>
