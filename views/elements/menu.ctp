<?php if (!isset($_SESSION["Auth"]["Admin"])): ?>
<?php echo $html->link('Log In',array('controller'=>'admins','action'=>'login'),null,null,false);?>
<?php else: ?>                                                                                           
<?php echo $html->link('Home',array('controller'=>'messages','action'=>'index'),null,null,false);?>
<br />
<?php if(is_array(Configure::read("Menu"))):?>
<?php foreach(Configure::read("Menu") as $pluginMenuKey=>$pluginMenuValue): ?>
<?php echo $html->link($pluginMenuValue["Name"],array('plugin'=>$pluginMenuKey,'controller'=>$pluginMenuValue["Controller"],'action'=>$pluginMenuValue["Action"]),null,null,false);?> 
<br />
<?php endforeach;?>
<?php endif; ?>
<?php echo $html->link('Log Out',array('controller'=>'admins','action'=>'logout'),null,null,false);?>
<br />
<?php endif;?>

