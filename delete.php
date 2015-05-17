	<?php if (!isset($_GET['mail']) || empty($_GET['mail']))
			{
			echo '<meta htpp-equiv="refresh" content="0;URL=?page=messagerie&action=inbox" />';
			}
			
		global $wpdb;
		if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT receiver FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
		{

	$wpdb->update('wp_messagerie', array('dossier' => 'trash'), array('id' => $_GET['mail']), array('%s'), array('%s'));
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie" />';
		}