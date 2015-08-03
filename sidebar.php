<ul>
	<?php
	global $wpdb;
	$reponse = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}messagerie WHERE unread = 1 AND receiver = %d AND dossier = \"inbox\"", get_current_user_id()));

	if(empty($reponse))
	{
			_e('<li><a href="#" id="inbox_folder">Inbox</a></li>', 'messagerie');
	}
	else
	{
			_e('<li><a href="#" id="inbox_folder">Inbox (' . $reponse . ')</a></li>', 'messagerie');
	}
	
	_e('<li><a href="#" id="sent_folder">Sent Emails</a></li>', 'messagerie');
	_e('<li><a href="#" id="trash_folder">Trash</a></li>', 'messagerie'); 
	_e('<li><a href="#" id="draft_folder">Drafts</a></li>', 'messagerie'); 
	
	?>
	<script src="<?php echo plugin_dir_url(__FILE__); ?>script_sidebar.js"></script>
</ul>