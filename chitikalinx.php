<?php
/*
Plugin Name: Chitika Linx
Plugin URI: http://www.programmershelp.net/chitikalinx.php
Description: This plugin adds the Chitika Linx code to your blog
Version: 0.2
Author: IH
Author URI: http://www.programmershelp.net

Change History
0.1 : Basic first release allowed entry of Chitika id
0.2 : Better Chitika ID  compatability and the ability to include a Tracking Channel for reports
*/

// This function outputs the chitika javascript for the configured user
function chitika_output()
{
    // get the publisher id
    $chitika_id = get_option('chitika_id');
	//get the custom channel for reports
	$channel_id = get_option('channel_id');
    ?>
	<!-- start of chitika linx code -->
	<script type="text/javascript"><!--
	ch_client = '<?php echo str_replace('\'', '\\\'', $chitika_id); ?>';
	ch_non_contextual = 0;
	ch_sid = "<?php echo($channel_id); ?>";
	ch_linkStyle= "style3";
	//--></script>
	<script  src="http://scripts.chitika.net/static/linx/chitika_linx.v3.js" type="text/javascript">
	</script>
    <!-- end of chitika linx code -->
<?php
}

// Adds the chitika settings menu to the Wordpress options page
function Chitika_menu()
{
    add_options_page('Chitika Settings', 'Chitika Settings', 8, __FILE__, 'chitika_options');
}

// Output the options menu page
function chitika_options()
{
    ?>
    <div class="wrap">
    <h2>Chitika Settings </h2>

	<form method="post" action="">
	<?php wp_nonce_field('update-options'); ?>
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options »') ?>" />
	</p>

	<?php
	    echo '<table>';
	    $parameters = array
		(
	    'chitika_id' => 'Chitika publisher ID',
		'channel_id' => 'Channel Tracking',
	    );

	    if ($_POST['action'] == 'update')
		{
		foreach($parameters as $param => $desc)
		{
		    update_option($param, $_POST[$param]);
		}
	    }
	    
	    foreach($parameters as $param => $desc){
		echo "<tr><td> $desc: </td> <td> <input type='text' name='$param' value='".get_option($param)."' /> </td></tr>";
	    }
	    echo '</table>';
	    $page_options = implode(',', array_keys($parameters));
	?>
	
	<input type="hidden" name="page_options" value="<?php echo $page_options ?>" />
	<input type="hidden" name="action" value="update" />

	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options »') ?>" />
	</p>
	</form>
    </div>
    <?php
}

add_option('chitika_id', 'xxxxxxxx');
add_option('channel_id', 'xxxxxxxx');
add_action('admin_menu', 'chitika_menu');
add_action('wp_footer', 'chitika_output');
?>