<h2>Hi</h2>
<div>
<?php                               
  echo $dijitForm->text('Username', array('label'=>'UserName'));
  echo $dijitForm->button('Hey', null, $js->request('/', array('update'=>'home')));
?>
</div>
<div>
<?php 
    echo $dijitForm->textarea('Notes');
    echo $dijitForm->datebox('Date');
?>
</div>      
<div id="home"></div>   
