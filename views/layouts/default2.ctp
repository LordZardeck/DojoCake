<?php
    if($session->check('User')){
        Configure::write("Theme", $session->read("User.Preferences.Theme"));
    }
    $dojo->link("dojo");
    $dojo->css("dojo");
    $dojo->theme(Configure::read('Theme'));
?>
<html>
    <head>
        <title><?php echo(Configure::read('Page.Title'));?></title>
        <?php echo $dojo->getCss();?> 
        <?php echo $html->css('cake.generic');?> 
        <?php echo $dojo->getLinks();?>
        <?php echo $dojo->getReq();?> 
    </head>
    <body class="<?php echo Configure::read('Theme'); ?>">
        <div class="content">
            <?php echo $content_for_layout;?>
        </div>
        <p align='center'>&copy;
            <script language='JavaScript' type='text/javascript'>
                var d=new Date();
                yr=d.getFullYear();
                if (yr!=2000)
                document.write(' '+yr);
            </script>
        Black Fire Web Development</p>        
    </body>
</html>
