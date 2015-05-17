<table id="inbox">
 <thead>
	 <?php if ($_GET['action'] == 'sent' || $_GET['action'] == 'draft')
		{
		?>
			<tr><td><?php _e('Receiver', 'messagerie');?></td><td><?php _e('Object', 'messagerie');?></td><td><?php _e('Mail', 'messagerie');?></td><td><?php _e('Date of Sending', 'messagerie');?></td></tr>
		<?php
		}
		else
		{
		?>
			<tr><td></td><td><?php _e('Sender', 'messagerie');?></td><td><?php _e('Object', 'messagerie');?></td><td><?php _e('Mail', 'messagerie');?></td><td><?php _e('Date of Sending', 'messagerie');?></td></tr>
		<?php 
		}
		?>
	</thead>
 <tbody>
 <?php
 global $wpdb;
	if ($_GET['action'] == 'sent')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE sender = %d ORDER BY date_envoi DESC", get_current_user_id()));
	}
	elseif($_GET['action'] == 'trash')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE receiver = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'trash'));
	}
	elseif($_GET['action'] == 'draft')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE sender = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'draft'));
	}
	else
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE receiver = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'inbox'));
	}
	
	foreach($reponse as $donnes)
	{
	 if ($_GET['action'] == 'sent' || $_GET['action'] == 'draft')
		{
		?>
		<tr><td><?php echo get_user_by('id', $donnes->receiver)->display_name; ?></td><td><a href="?page=messagerie&action=<?php if($_GET['action'] == 'draft') { echo 'continue';} else {echo 'read';}?>&mail=<?php echo $donnes->id; ?>"><?php echo esc_html($donnes->objet); ?></a></td><td><?php echo wp_kses(substr($donnes->message, 0, 20), array('')); ?></td><td><?php echo $donnes->date_envoi; ?></td><?php if ($_GET['action'] == 'draft') { echo '<td><a href="?page=messagerie&action=deldraft&mail=' . $donnes->id . '"><img alt="Del" src="' .  plugins_url()  .'/messagerie/delete.png" style="width: 25px; height: 25px;"/></a></td>'; }?></tr>
<?php 
		}
		else 
		{ 
		?>
				<tr <?php if ($donnes->unread == 1) { echo 'style="font-weight: bold;"'; }?>><td><?php if ($donnes->unread == 1) { echo '<img style="width: 50%" src="' . plugins_url() . '/messagerie/etoile.png"/>'; }?></td><td><?php echo get_user_by('id', $donnes->sender)->display_name; ?></td><td><a href="?page=messagerie&action=read&mail=<?php echo $donnes->id; ?>"><?php echo $donnes->objet; ?></a></td><td><?php echo wp_kses(substr($donnes->message, 0, 20), array('')); ?></td><td><?php echo $donnes->date_envoi; ?></td><td><a href="?page=messagerie&action=<?php if($_GET['action'] == 'trash') {echo 'undo'; } else { echo 'delete';}?>&mail=<?php echo $donnes->id; ?>"><img alt="<?php if ($_GET['action'] == 'trash') { echo 'Undo';} else { echo 'Del';}?>" style="width: 25px; height: 25px;" src="<?php echo plugins_url(); ?>/messagerie/<?php if ($_GET['action'] == 'trash') { echo 'undo.png';} else { echo 'delete.png';}?>"/></a></td></tr>
		<?php 
		}
	}
	
	echo '</tbody></table>';
