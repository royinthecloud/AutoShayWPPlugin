<form name="wpwallform" action="<?php echo $action_url ?>" method="post">
    <input type="hidden" name="submitted" value="1" /> 
	<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo $nonce?>" />
    
    <h2>API database name</h2>	
    <input type="text" id="db_name" name="db_name" size="50" value="<?php echo $db_name?>" required />
    <label for="db_name">Input API database name</label> <br />
    
    <div class="submit"><input type="submit" name="Submit" value="Save" /></div>
</form>