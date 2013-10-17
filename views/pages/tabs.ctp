<?php       
    $tabContainer->create();
    $tabContainer->addTab($layout->createContainer("Pane 1 Content.", array('title'=>"Pane 1")));
    $tabContainer->addTab($layout->createContainer("Pane 2 Content.", array('title'=>"Pane 2")));
    $tabContainer->addTab($layout->createContainer("Pane 3 Content.", array('title'=>"Pane 3")));
    echo $tabContainer->getString();
?>