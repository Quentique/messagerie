<table id="inbox">
<!--<script>jQuery.getScript('<?php echo plugins_url('script_read.js', __FILE__);?>');</script>-->
 <thead>
	 <?php if ($_GET['use'] == 'sent')
		{
		?>
			<tr><td><?php _e('Destinataire', 'messagerie');?></td><td><?php _e('Objet', 'messagerie');?></td><td><?php _e('Message', 'messagerie');?></td><td><?php _e('Date d\'envoi', 'messagerie');?></td></tr>
		<?php
		}
		else if ($_GET['use'] == 'draft')
		{?>
			<tr><td><?php _e('Destinataire', 'messagerie');?></td><td><?php _e('Objet', 'messagerie');?></td><td><?php _e('Message', 'messagerie');?></td><td><?php _e('Date d\'envoi', 'messagerie');?></td></tr><?php
		}
			else
		{
		?>
			<tr><td></td><td><?php _e('Expéditeur', 'messagerie');?></td><td><?php _e('Objet', 'messagerie');?></td><td><?php _e('Message', 'messagerie');?></td><td><?php _e('Date d\'envoi', 'messagerie');?></td></tr>
		<?php 
		}
		?>
	</thead>
 <tbody>
 <?php
 global $wpdb;
	if ($_GET['use'] == 'sent')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE sender = %d AND dossier = %s OR %s ORDER BY date_envoi DESC", get_current_user_id(), 'inbox', 'trash'));
	}
	elseif($_GET['use'] == 'trash')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE receiver = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'trash'));
	}
	elseif($_GET['use'] == 'draft')
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE sender = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'draft'));
	}
	else
	{
			$reponse = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE receiver = %d AND dossier = %s ORDER BY date_envoi DESC", get_current_user_id(), 'inbox'));
	}
	
	foreach($reponse as $donnes)
	{
	 if ($_GET['use'] == 'sent' || $_GET['use'] == 'draft')
		{
		?>
		<tr><td><?php echo get_user_by('id', $donnes->receiver)->display_name; ?></td><td><a href="#" class="messagerie_<?php if ($_GET['use'] == 'draft' ) {echo 'draft'; } else { echo 'read';} ?>" id_message="<?php echo $donnes->id; ?>"><?php echo esc_html($donnes->objet); ?></a></td><td><?php echo wp_kses(substr($donnes->message, 0, 20), array('')); ?></td><td><?php echo $donnes->date_envoi; ?></td><?php if ($_GET['use'] == 'draft') { echo '<td><a class="messagerie_delete_draft" href="#" id_message="' . $donnes->id . '"><img alt="Del" src="' .  plugins_url()  .'/messagerie/delete.png" style="width: 25px; height: 25px;"/></a></td>'; }?></tr>
<?php 
		}
		else 
		{ 
		?>
				<tr <?php if ($donnes->unread == 1) { echo 'style="font-weight: bold;"'; }?>><td><?php if ($donnes->unread == 1) { echo '<img style="width: 50%" src="' . plugins_url() . '/messagerie/etoile.png"/>'; }?></td><td><?php echo get_user_by('id', $donnes->sender)->display_name; ?></td><td><a href="#" <?php if ($_GET['use'] == 'trash') {echo ' trash="1" '; } ?>class="messagerie_read" id_message="<?php echo $donnes->id; ?>"><?php echo $donnes->objet; ?></a></td><td><?php echo wp_kses(substr($donnes->message, 0, 20), array('')); ?></td><td><?php echo $donnes->date_envoi; ?></td><td><a href="#" class="<?php if ($_GET['use'] == 'trash') { echo 'messagerie_undo'; } else { echo 'messagerie_delete'; }?>" id_message="<?php echo $donnes->id; ?>"><img alt="<?php if ($_GET['use'] == 'trash') { echo 'Undo';} else { echo 'Del';}?>" style="width: 25px; height: 25px;" src="<?php echo plugins_url(); ?>/messagerie/<?php if ($_GET['use'] == 'trash') { echo 'undo.png';} else { echo 'delete.png';}?>"/></a></td></tr>
		<?php 
		}
	}
	
	echo '</tbody></table>';

