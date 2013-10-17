<html>
    <head>
        <title>Test</title>
        <?php //echo $html->css('cake.generic'); ?>
        <?php echo $js->start(array('theme'=>'soria')); ?>
        <?php echo $scripts_for_layout; ?>
    </head>
    <body>
        <div id="content">
            <?php echo $content_for_layout; ?> 
        </div>                     
    </body>
</html>
