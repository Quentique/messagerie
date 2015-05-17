<?php if (isset($_POST['desti']))
		{
		  if (empty($_POST['obj']))
				{
		$obj = __('No Subject', 'messagerie');
				}
				else
				{
					$obj = $_POST['obj'];
				}
		
		 if (isset($_POST['envoie']))
			{
				$folder = 'inbox';
			}
			else
			{
			$folder = 'draft';
			}

			if (isset($_POST['id_mess']) && isset($_POST['brouillon']))
			{

				$wpdb->update('wp_messagerie', array('receiver' => $_POST['desti'], 'objet' => $obj, 'message' => $_POST['mess']), array('id' => $_POST['id_mess']), array('%d', '%s', '%s'), array('%d', '%s', '%s'));
				$wpdb->query('UPDATE wp_messagerie SET date_envoi = NOW() WHERE id = ' . $_POST['id_mess']);
			
			}
			else
			{
			
			
		 $response = $wpdb->query($wpdb->prepare('INSERT INTO wp_messagerie(sender, receiver, unread, objet, message, date_envoi, dossier) VALUES (%d, %d, 1, %s, %s, NOW(), %s);', get_current_user_id(), $_POST['desti'], $obj, $_POST['mess'], $folder));
			if (isset($_POST['id_mess']) && isset($_POST['envoie']))
			{
			$wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE id = %d', $_POST['id_mess']));
			}
			
			}
	 	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=inbox"/>';
		}
	?>
	<form method="post" action="">
	<table id="compose">
	<tr><td><?php _e('From :', 'messagerie'); ?></td><td><?php echo wp_get_current_user()->display_name; ?></td></tr>
	<tr><td><label for="desti"><?php _e('To :', 'messagerie');?></label></td><td><select name="desti">
	<?php 
	$users = get_users(array('fields' => array('id', 'display_name' )));
	
	if ($_GET['action'] == answer || $_GET['action'] == 'forward' || $_GET['action'] == 'continue')
	{
	 $mess = $wpdb->get_row($wpdb->prepare('SELECT * FROM wp_messagerie WHERE id = %d', $_GET['mail']));
	}
	foreach($users as $user)
	{
	if (isset($mess) && $user->id == $mess->sender )
	{
				$select = 'selected';
	}
	else { $select = ''; }
	 echo '<option ' . $select . ' value="' . $user->id . '">' . $user->display_name . '</option>';
	 }
	?>
	</select></td></tr>
	<tr><td><label for="obj"><?php _e('Object :', 'messagerie');?></label></td><td><input name="obj" type="text" maxlength="255" <?php if (isset($mess) && $_GET['action'] == 'answer') { echo 'value="RE: '. $mess->objet . '"'; } elseif ($_GET['action'] == 'forward') { echo 'value="FW: '. $mess->objet . '"'; } elseif ($_GET['action'] == 'continue') { echo 'value="' . $mess->objet . '"'; }?>/></td></tr>
	<tr><td><label for="mess"><?php _e('Mail :', 'messagerie');?></label></td><td><textarea rows="10" cols="25" name="mess" id="txt-aref"><?php if (isset($mess) && $_GET['action'] != 'continue') { echo html_entity_decode('<br/><hr/><span>De : ' . get_user_by('id', $mess->sender)->display_name . '</span><br/><span>A : ' . get_user_by('id', $mess->receiver)->display_name . '</span><br/><span>Objet : </span>' . $mess->objet . '</span><br/><span>Date : ' . $mess->date_envoi . '</span><br/><br/> ' . $mess->message); } elseif (isset($mess) && $_GET['action'] == 'continue') { echo $mess->message; }?></textarea></td></tr>
	<tr><td colspan="2"><input type="submit" name="envoie" value="<?php _e('Submit', 'messagerie'); ?>"/><input type="submit" name="brouillon" value="<?php _e('Save Draft', 'messagerie');?>"/><?php if(isset($mess) && $_GET['action'] == 'continue') { echo '<input type="hidden" name="id_mess" value="' . $mess->id . '"/>';}?></td></tr>
	</table>
	</form>
	<script>CKEDITOR.replace('txt-aref');</script>