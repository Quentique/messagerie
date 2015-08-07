<ul>
	<?php
	global $wpdb;
	$reponse = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}messagerie WHERE unread = 1 AND receiver = %d AND dossier = \"inbox\"", get_current_user_id()));

	if(empty($reponse))
	{
		_e('<li><a href="#" id="inbox_folder">Boîte de Réception</a></li>', 'messagerie');
	}
	else
	{
		_e('<li><a href="#" id="inbox_folder">Boîte de Réception (' . $reponse . ')</a></li>', 'messagerie');
	}
	
	_e('<li><a href="#" id="sent_folder">Messages Envoyés</a></li>', 'messagerie');
	_e('<li><a href="#" id="trash_folder">Messages Supprimés</a></li>', 'messagerie'); 
	_e('<li><a href="#" id="draft_folder">Brouillons</a></li>', 'messagerie'); 
	
	?>
</ul>