<ul><?php
global $wpdb;
$reponse = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}messagerie WHERE unread = 1 AND receiver = %d AND dossier = \"inbox\"", get_current_user_id()));

	if(empty($reponse))
	{
	_e('<li><a href="?page=messagerie">Inbox</a></li>', 'messagerie');
	}
	else
	{
	_e('<li><a href="?page=messagerie">Inbox (' . $reponse . ')</a></li>', 'messagerie');
	}
	
	_e('<li><a href="?page=messagerie&action=sent">Sent Emails</a></li>', 'messagerie');
	
	_e('<li><a href="?page=messagerie&action=trash">Trash</a></li>', 'messagerie'); 
	
	
		_e('<li><a href="?page=messagerie&action=draft">Drafts</a></li>', 'messagerie'); 
	?>
	</ul>