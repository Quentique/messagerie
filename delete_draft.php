 <?php 
	if(!isset($_GET['mail']) || empty($_GET['mail']))
	{
			echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=draft"/>';
	}
	
	global $wpdb;
	if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT sender FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
	{
		 $wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE id = %d', $_GET['mail']));
	}
	
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=draft"/>';