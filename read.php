<?php 
	global $wpdb; // On récupère l'e-mail demandé
	$reponse = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE id = %d", $_GET['mail']));
	
	if(empty($reponse))
	{
			echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie"/>';
	}
	else
	{
	  // On update la table pour dire que l'email n'est plus non-lu
			$wpdb->update('wp_messagerie', array('unread' => '0'), array('id' => $_GET['mail']), array('%d'), array('%d'));
	}
	?>	
	<!-- On affiche le mail -->
	<table id="inbox">
		<tr><td><?php _e('De :', 'messagerie');?></td>		<td><?php echo get_user_by('id', $reponse->sender)->display_name; ?></td></tr>
		<tr><td><?php _e('À :', 'messagerie'); ?></td>			<td><?php echo get_user_by('id', $reponse->receiver)->display_name; ?></td></tr>
		<tr><td><?php _e('Objet :', 'messagerie');?></td><td><?php echo $reponse->objet; ?></td></tr>
		<tr><td><?php _e('Message :', 'messagerie');?></td>		<td><textarea id="test2"><?php echo $reponse->message; ?></textarea></td></tr>
	</table>