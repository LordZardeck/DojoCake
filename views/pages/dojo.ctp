<?php
    $dojo->req("dijit.layout.ContentPane");
    $dojo->req("dijit.layout.TabContainer");
?>
<div class="formContainer" dojoType="dijit.layout.TabContainer" style="width:600px;height:600px">
    <div dojoType="dijit.layout.ContentPane" title="Personal Data">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" size="30" /><br />
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" size="30" /><br />
    </div>
    <div dojoType="dijit.layout.ContentPane" title="Address">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" size="30" /><br />
        <label for="city">City</label>
        <input type="text" name="city" id="city" size="30" /><br />
    </div>
</div>