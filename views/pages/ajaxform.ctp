<?php 
    echo $form->create("", array('id'=>'ajaxForm', 'url'=>'/pages/home2'));  
    echo $form->button("Get Page", array('onclick'=>$dojoAjax->Updater("ajaxForm", "ajaxResponse")));
    echo $form->end();                                                                                   
?>
<div id="ajaxResponse"></div>
