<?php 
    $dojo->css("grid/resources/soriaGrid.css", "dojox");
    $headers = array(array("field"=>"description", "title"=>"Cigar"),array("field"=>"size", "title"=>"Length/Ring"),
                    array("field"=>"origin", "title"=>"Origin"),array("field"=>"wrapper", "title"=>"Wrapper"),
                    array("field"=>"shape", "title"=>"Shape"));
    $homeButton = $dojoForm->createButton("Home");
    $projectsButton = $dojoForm->createButton("Projects");
    $navigation = $homeButton."<br />".$projectsButton;
    $firstNameInput = $dojoForm->createValidationTextBox("first_name", true, "You must enter a first name.",true, true, true);
    $secondNameInput = $dojoForm->createValidationTextBox("second_name", true, "You must enter a second name.",false, true, true);
    $pane1Content = "Pane 1 Content.".$firstNameInput."<br />".$secondNameInput;
    $grid = $dojoAjax->Grid($headers, "/js/wishlist.js", null, array("query"=>"{wishId: '*'}", "title"=>"Pane 2"));
    $tabContainer->create();
    $tabContainer->addTab($layout->createContainer($pane1Content, array('title'=>"Pane 1")));
    $tabContainer->addTab($grid);
    $tabContainer->addTab($layout->createContainer("Pane 3 Content.", array('title'=>"Pane 3")));
    
    echo $layout->createLayout(array(
                            'center'=>array(
                                            'content'=>$tabContainer->getString(), 
                                            'parms'=>array('style'=>'height:85%')
                            ), 'top'=>array(
                                            'content'=>'<lzH>Digital Takedown</lzH>', 
                                            'parms'=>array('style'=>'height:15px')
                            ), 'leading'=>array(
                                            'content'=>$navigation, 
                                            'parms'=>array('style'=>'width:20%; overflow: auto')
                            )));                                                             
?>