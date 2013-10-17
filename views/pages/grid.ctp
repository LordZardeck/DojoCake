<?php 
    $dojo->css("grid/resources/soriaGrid.css", "dojox");
    $headers = array(array("field"=>"description", "title"=>"Cigar"),array("field"=>"size", "title"=>"Length/Ring"),
                    array("field"=>"origin", "title"=>"Origin"),array("field"=>"wrapper", "title"=>"Wrapper"),
                    array("field"=>"shape", "title"=>"Shape"));
    echo $dojoAjax->Grid($headers, "/js/wishlist.js", null, array("query"=>"{wishId: '*'}"));
?>