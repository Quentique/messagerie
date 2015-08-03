
	<div id="composition">
	<form method="post" action="" id="send_mail">
		<table id="compose">
		<p><?php echo plugins_url('script_send.js', __FILE__);?>
		<input type="hidden" name="action" value="send_mail"/>
			<tr><td><?php _e('From :', 'messagerie'); ?></td><td><?php echo wp_get_current_user()->display_name; ?></td></tr>
			<tr><td><label for="desti"><?php _e('To :', 'messagerie');?></label></td><td><select name="desti">
			<?php 
			$users = get_users(array('fields' => array('id', 'display_name' )));
	
			if ($_GET['use'] == answer || $_GET['use'] == 'forward' || $_GET['use'] == 'continue')
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
			<tr><td><label for="obj"><?php _e('Object :', 'messagerie');?></label></td><td><input name="obj" type="text" maxlength="255" <?php if (isset($mess) && $_GET['use'] == 'answer') { echo 'value="RE: '. $mess->objet . '"'; } elseif ($_GET['use'] == 'forward') { echo 'value="FW: '. $mess->objet . '"'; } elseif ($_GET['use'] == 'continue') { echo 'value="' . $mess->objet . '"'; }?>/></td></tr>
			<tr><td><label for="mess"><?php _e('Mail :', 'messagerie');?></label></td><td><textarea rows="10" cols="25" name="mess" id="txt-aref"><?php if (isset($mess) && $_GET['use'] != 'continue') { echo html_entity_decode('<br/><hr/><span>De : ' . get_user_by('id', $mess->sender)->display_name . '</span><br/><span>A : ' . get_user_by('id', $mess->receiver)->display_name . '</span><br/><span>Objet : </span>' . $mess->objet . '</span><br/><span>Date : ' . $mess->date_envoi . '</span><br/><br/> ' . $mess->message); } elseif (isset($mess) && $_GET['use'] == 'continue') { echo $mess->message; }?></textarea></td></tr>
			<tr><td colspan="2"><input type="submit" name="envoie" id="envoie" value="<?php _e('Submit', 'messagerie'); ?>"/><input type="submit" name="brouillon" value="<?php _e('Save Draft', 'messagerie');?>"/><?php if(isset($mess) && $_GET['use'] == 'continue') { echo '<input type="hidden" name="id_mess" value="' . $mess->id . '"/>';}?></td></tr>
		</table>
		
	</form>
	</div>