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
$reponse = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM wp_messagerie WHERE unread = 1 AND receiver = %d AND dossier = "inbox"', get_current_user_id()));
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



include_once('nav.php');?>

<div id="messagerie_sidebar">
<?php include_once('sidebar.php'); ?>
	</div>
<?php
if (!isset($_GET['action']) || $_GET['action'] == 'inbox' || $_GET['action'] == 'sent' || $_GET['action'] == 'trash' || $_GET['action'] == 'draft')
{
 include_once('inbox.php'); ?>
<?php
}
elseif ($_GET['action'] == read)
{
 include_once('read.php');
	
	} elseif ($_GET['action'] == 'compose' || $_GET['action'] == 'answer' || $_GET['action'] == 'forward' || $_GET['action'] == 'continue' )
	{
	 include_once('compose.php');
	
	}
	elseif ($_GET['action'] == 'delete')
	{

		include_once('delete.php');
			
	}
	elseif ($_GET['action'] == 'undo')
	{
	
	 include_once('undo.php');
	}
	elseif($_GET['action'] == 'deldraft')
	{
	   include_once('delete_draft.php');
	}
	
}
}


new Messagerie();
?>