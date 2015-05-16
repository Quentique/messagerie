<?php
/*
Plugin Name: Messagerie
Description: Plugin de messagerie interne
Text Domain: messagerie
Version: 0.1
Author: Quentin DE MUYNCK
*/ 

class Messagerie
{

 public function __construct()
 {
  register_activation_hook(__FILE__, array('Messagerie', 'install'));
  register_uninstall_hook(__FILE__, array('Messagerie', 'uninstall'));
	 add_action('admin_menu', array($this, 'add_admin_menu'));
		add_action('delete_user', 'messagerie_delete_user');
	}
 
 public static function install()
 {
 
 global $wpdb;
 
 $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}messagerie (id INT AUTO_INCREMENT PRIMARY KEY, sender VARCHAR(255) NOT NULL, receiver VARCHAR(255) NOT NULL, unread INT NOT NULL, objet VARCHAR(255) NOT NULL, message TEXT NOT NULL, date_envoi DATETIME NOT NULL, dossier VARCHAR(255) NOT NULL);");

		}
		
		
public static function uninstall()
{
    global $wpdb;

    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}messagerie;");
}

public function add_admin_menu()
{
global $wpdb;
$reponse = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM wp_messagerie WHERE unread = 1 AND receiver = %d', get_current_user_id()));
if ($reponse == 0)
{
add_menu_page('Messagerie', 'Messagerie', 'manage_options', 'messagerie',  array($this, 'administration'));
}
else
{
add_menu_page('Messagerie', 'Messagerie <span title="' . $reponse . ' nouveaux e-mails" class="update-plugins count-2"><span class="update-count">' . $reponse . '</span></span>', 'manage_options', 'messagerie',  array($this, 'administration'));

}
}
public function messagerie_delete_user($user_id)
{
 global $wpdb;
	$wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE receiver = %d AND sender = %d', $user_id, $user_id));
}
public function administration()
{
_e('<h1>Internal Mail</h1>', 'messagerie');
echo '<script src=" ' . plugins_url() . '/messagerie/ckeditor/ckeditor.js"></script>';
echo '<link rel="stylesheet" content="text/css" href="' . plugins_url() . '/messagerie/style.css"/>';

?>

<nav>
<ul id="messagerie_nav">
<li><a href="?page=messagerie&action=compose"><?php _e('New', 'messagerie'); ?></a></li>
<?php 
if ($_GET['action'] == read)
{
?>
<li><a href="?page=messagerie&action=answer&mail=<?php echo $_GET['mail'];?>"><?php _e('Answer', 'messagerie'); ?></a></li>
<li><a href="?page=messagerie&action=forward&mail=<?php echo $_GET['mail'];?>"><?php _e('Forward', 'messagerie'); ?></a></li>
<?php } ?>
</ul>
</nav>
<div id="messagerie_sidebar">
<ul><?php
global $wpdb;
$reponse = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}messagerie WHERE unread = 1 AND receiver = %d", get_current_user_id()));

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
	</div>
<?php
if (!isset($_GET['action']) || $_GET['action'] == 'inbox' || $_GET['action'] == 'sent' || $_GET['action'] == 'trash' || $_GET['action'] == 'draft')
{
?>
<table id="inbox">
 <thead>
	 <?php if ($_GET['action'] == 'sent' || $_GET['action'] == 'draft')
		{?>
		
	 <tr><td><?php _e('Receiver', 'messagerie');?></td><td><?php _e('Object', 'messagerie');?></td><td><?php _e('Mail', 'messagerie');?></td><td><?php _e('Date of Sending', 'messagerie');?></td></tr>
		<?php
		}
		else
		{?>
	 <tr><td></td><td><?php _e('Sender', 'messagerie');?></td><td><?php _e('Object', 'messagerie');?></td><td><?php _e('Mail', 'messagerie');?></td><td><?php _e('Date of Sending', 'messagerie');?></td></tr>
<?php }?>
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

<?php }
else { ?>
<tr <?php if ($donnes->unread == 1) { echo 'style="font-weight: bold;"'; }?>><td><?php if ($donnes->unread == 1) { echo '<img style="width: 50%" src="' . plugins_url() . '/messagerie/etoile.png"/>'; }?></td><td><?php echo get_user_by('id', $donnes->sender)->display_name; ?></td><td><a href="?page=messagerie&action=read&mail=<?php echo $donnes->id; ?>"><?php echo $donnes->objet; ?></a></td><td><?php echo wp_kses(substr($donnes->message, 0, 20), array('')); ?></td><td><?php echo $donnes->date_envoi; ?></td><td><a href="?page=messagerie&action=<?php if($_GET['action'] == 'trash') {echo 'undo'; } else { echo 'delete';}?>&mail=<?php echo $donnes->id; ?>"><img alt="<?php if ($_GET['action'] == 'trash') { echo 'Undo';} else { echo 'Del';}?>" style="width: 25px; height: 25px;" src="<?php echo plugins_url(); ?>/messagerie/<?php if ($_GET['action'] == 'trash') { echo 'undo.png';} else { echo 'delete.png';}?>"/></a></td></tr>
<?php }
}
echo '</tbody></table>';
}
elseif ($_GET['action'] == read)
{
 if (!isset($_GET['mail']))
	{
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie"/>';
	}
	 
	global $wpdb;
	$reponse = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}messagerie WHERE id = %d", $_GET['mail']));
	
	if(empty($reponse))
	{
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie"/>';
	}
	else
	{
	$wpdb->update('wp_messagerie', array('unread' => '0'), array('id' => $_GET['mail']), array('%d'), array('%d'));
	}
	?>
	<table>
	<tr><td><?php _e('From :', 'messagerie');?></td><td><?php echo get_user_by('id', $reponse->sender)->display_name; ?></td></tr>
	<tr><td><?php _e('To :', 'messagerie'); ?></td><td><?php echo get_user_by('id', $reponse->receiver)->display_name; ?></td></tr>
	<tr><td><?php _e('Object :', 'messagerie');?></td><td><?php echo $reponse->objet; ?></td></tr>
	<tr><td><?php _e('Mail :', 'messagerie');?></td><td><textarea id="test2"><?php echo $reponse->message; ?></textarea><script>CKEDITOR.replace('test2');</script><script>var editor;

		// The instanceReady event is fired, when an instance of CKEditor has finished
		// its initialization.
		CKEDITOR.on( 'instanceReady', function( ev ) {
			editor = ev.editor;
editor.setReadOnly(true);

		});  </script></td></tr>
	</table>
	<?php 
	} elseif ($_GET['action'] == 'compose' || $_GET['action'] == 'answer' || $_GET['action'] == 'forward')
	{
	 if (isset($_POST['desti']))
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
			
		 $response = $wpdb->query($wpdb->prepare('INSERT INTO wp_messagerie(sender, receiver, unread, objet, message, date_envoi, dossier) VALUES (%d, %d, 1, %s, %s, NOW(), %s);', get_current_user_id(), $_POST['desti'], $obj, $_POST['mess'], $folder));
			
	 	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=inbox"/>';
		}
	?>
	<form method="post" action="">
	<table id="compose">
	<tr><td><?php _e('From :', 'messagerie'); ?></td><td><?php echo wp_get_current_user()->display_name; ?></td></tr>
	<tr><td><label for="desti"><?php _e('To :', 'messagerie');?></label></td><td><select name="desti">
	<?php 
	$users = get_users(array('fields' => array('id', 'display_name' )));
	
	if ($_GET['action'] == answer || $_GET['action'] == 'forward')
	{
	 $mess = $wpdb->get_row($wpdb->prepare('SELECT * FROM wp_messagerie WHERE id = %d', $_GET['mail']));
	}
	foreach($users as $user)
	{
	if (isset($mess) && $user->id == $mess->sender && $_GET['action'] == 'answer')
	{
				$select = 'selected';
	}
	 echo '<option ' . $select . ' value="' . $user->id . '">' . $user->display_name . '</option>';
	}
	?>
	</select></td></tr>
	<tr><td><label for="obj"><?php _e('Object :', 'messagerie');?></label></td><td><input name="obj" type="text" maxlength="255" <?php if (isset($mess) && $_GET['action'] == 'answer') { echo 'value="RE: '. $mess->objet . '"'; } elseif ($_GET['action'] == 'forward') { echo 'value="FW: '. $mess->objet . '"'; }?>/></td></tr>
	<tr><td><label for="mess"><?php _e('Mail :', 'messagerie');?></label></td><td><textarea rows="10" cols="25" name="mess" id="txt-aref"><html><body><?php if (isset($mess)) { echo html_entity_decode('<br/><hr/><span>De : ' . get_user_by('id', $mess->sender)->display_name . '</span><br/><span>A : ' . get_user_by('id', $mess->receiver)->display_name . '</span><br/><span>Objet : </span>' . $mess->objet . '</span><br/><span>Date : ' . $mess->date_envoi . '</span><br/><br/> ' . $mess->message); }?></body></html></textarea></td></tr>
	<tr><td colspan="2"><input type="submit" name="envoie" value="<?php _e('Submit', 'messagerie'); ?>"/><input type="submit" name="brouillon" value="<?php _e('Save Draft', 'messagerie');?>"/></td></tr>
	</table>
	</form>
	<script>CKEDITOR.replace('txt-aref');</script>
	<?php 
	}
	elseif ($_GET['action'] == 'delete')
	{

			if (!isset($_GET['mail']) || empty($_GET['mail']))
			{
			echo '<meta htpp-equiv="refresh" content="0;URL=?page=messagerie&action=inbox" />';
			}
			
		global $wpdb;
		if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT receiver FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
		{

	$wpdb->update('wp_messagerie', array('dossier' => 'trash'), array('id' => $_GET['mail']), array('%s'), array('%s'));
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie" />';
		}
			
	}
	elseif ($_GET['action'] == 'undo')
	{
	
	global $wpdb;
	$wpdb->update('wp_messagerie', array('dossier' => 'inbox'), array('id' => $_GET['mail']), array('%s'), array('%s'));
	echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie"/>';
	}
	elseif($_GET['action'] == 'deldraft')
	{
	 if(!isset($_GET['mail']) || empty($_GET['mail']))
		{
		 echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=draft"/>';
		}
		global $wpdb;
		if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT sender FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
		{
		  $wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE id = %d', $_GET['mail']));
		}
		 echo '<meta http-equiv="refresh" content="0;URL=?page=messagerie&action=draft"/>';
	}
	
}
}


new Messagerie();
?>