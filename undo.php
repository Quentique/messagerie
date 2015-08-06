<?php 
	global $wpdb;
	$wpdb->update('wp_messagerie', array('dossier' => 'inbox'), array('id' => $_GET['mail']), array('%s'), array('%s'));

