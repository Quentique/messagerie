<?php
/*
Plugin Name: Messagerie
Description: Plugin de messagerie interne
Text Domain: messagerie
Version: 0.1
Author: Quentin DE MUYNCK
*/ 


function prefix_admin_send_mail() // Fonction appelé par AJAX pour envoyer les mails
{
	if (!empty($_REQUEST))
	{
		global $wpdb;
		if (empty($_POST['obj']))
		{
				$obj = 'No Subject';
		}
		else
		{
				$obj = $_POST['obj'];
		}
		
		$test = $wpdb->get_var($wpdb->prepare('SELECT can_mail FROM wp_users WHERE id = %d', get_current_user_id()));
		
		if (isset($_REQUEST['envoie']))
		{
			 $folder = 'inbox';
				if ( $test == 0 && $_POST['desti'] != 1)
				{
				 $folder = 'draft';
				}
		}
		else
		{
				$folder = 'draft';	
		}
			
		if (isset($_POST['id_mess']) && isset($_POST['brouillon']))
		{
			$wpdb->update('wp_messagerie', array('receiver' => $_POST['desti'], 'objet' => $obj, 'message' => $_POST['mess']), array('id' => $_POST['id_mess']), array('%d', '%s', '%s'), array('%d', '%s', '%s'));
			$resulte = $wpdb->query('UPDATE wp_messagerie SET date_envoi = NOW() WHERE id = ' . $_POST['id_mess']);
			
			if ($resulte === false)
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=2';
			}
			else
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=3';
			}
			
		}
		else
		{
			$response = $wpdb->query($wpdb->prepare('INSERT INTO wp_messagerie(sender, receiver, unread, objet, message, date_envoi, dossier) VALUES (%d, %d, 1, %s, %s, NOW(), %s);', get_current_user_id(), $_POST['desti'], $obj, $_POST['mess'], $folder));
					
			if (isset($_POST['id_mess']) && isset($_POST['envoie']))
			{
				$result = $wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE id = %d', $_POST['id_mess']));
			}

			if ($result === false && isset($_POST['envoie']))
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=0';
			}
			elseif ($result === false && isset($_POST['brouillon']))
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=2';
			}
			elseif (empty($result) && isset($_POST['brouillon']))
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=3';
			}
			elseif ($test == 0 && $_POST['desti'] != 1)
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=4';
			}
			else
			{
				echo 'admin.php?page=messagerie&use=inbox&ok=1';
			}
		}
	}
	wp_die();
}

function messagerie_options_send() //Fonction AJAX pour mettre à jour les options
{
	global $wpdb;
	$reponses = $wpdb->get_results('SELECT id, display_name, can_mail FROM wp_users');

	global $wpdb;
	$nbre = 0;
	foreach($reponses as $reponse)
	{
		if ($_GET[$reponse->id] == 'on')
		{
			$result =	$wpdb->update('wp_users', array('can_mail' => 1), array('id' => $reponse->id), array('%d'), array('%d'));
		}
		else
		{
			$result =	$wpdb->update('wp_users', array('can_mail' => 0), array('id' => $reponse->id), array('%d'), array('%d'));
		}
	
		if ($result === false)
		{
			$nbre++;
		} 
	}
					
 if ($nbre != 0)
	{
		echo 'admin.php?page=messagerie_options&ok=0';
	}
	else
	{
		echo 'admin.php?page=messagerie_options&ok=1';
	}
	wp_die();
}

function ajax_delete_draft() // Fonction AJAX pour supprimer un brouillon
{
	global $wpdb;
	if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT sender FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
	{
		 $result = $wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE id = %d', $_GET['mail']));
	}
	
	if ($result == false)
	{
		echo 'admin.php?page=messagerie&use=draft&ok=0';
	}
	else
	{
		echo 'admin.php?page=messagerie&use=draft&ok=1';
	}
	wp_die();
}
	
function ajax_delete_mail() {	 // Fonction AJAX pour supprimer un mail
	global $wpdb;
	if (get_current_user_id() == $wpdb->get_var($wpdb->prepare('SELECT receiver FROM wp_messagerie WHERE id = %d', $_GET['mail'])))
	{
		$result = $wpdb->update('wp_messagerie', array('dossier' => 'trash'), array('id' => $_GET['mail']), array('%s'), array('%s'));
	}
	
	if ($result == false)
	{
		echo 'admin.php?page=messagerie&use=inbox&ok=0';
	}
	else
	{
		echo 'admin.php?page=messagerie&use=inbox&ok=1';
	}
	wp_die();
}
	
function ajax_undo() // Fonction AJAX pour remettre un mail supprimé en boîte de réception
{
	global $wpdb;
	$result = $wpdb->update('wp_messagerie', array('dossier' => 'inbox'), array('id' => $_GET['mail']), array('%s'), array('%s'));
	
	if ($result == false) 
	{
		echo 'admin.php?page=messagerie&use=trash&ok=0';
	}
	else
	{
		echo 'admin.php?page=messagerie&use=trash&ok=1';
	}
	wp_die();
}

// On enregistre les actions avec WordPress
add_action('wp_ajax_send_mail', 'prefix_admin_send_mail' );
add_action('wp_ajax_delete_draft', 'ajax_delete_draft');
add_action('wp_ajax_delete_mail', 'ajax_delete_mail');
add_action('wp_ajax_undo', 'ajax_undo');
add_action('wp_ajax_messagerie_options_send', 'messagerie_options_send');

class Messagerie
{
	public function __construct() // Constructeur
 {
  register_activation_hook(__FILE__, array('Messagerie', 'install'));
  register_deactivation_hook(__FILE__, array('Messagerie', 'uninstall'));
	 add_action('admin_menu', array($this, 'add_admin_menu'));
		add_action('delete_user', 'messagerie_delete_user');
	}
 
 public static function install() // Installation du plugins et créations des tables et des colonnes
 {
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}messagerie (id INT AUTO_INCREMENT PRIMARY KEY, sender VARCHAR(255) NOT NULL, receiver VARCHAR(255) NOT NULL, unread INT NOT NULL, objet VARCHAR(255) NOT NULL, message TEXT NOT NULL, date_envoi DATETIME NOT NULL, dossier VARCHAR(255) NOT NULL);");
	 $wpdb->query("ALTER TABLE {$wpdb->prefix}users  ADD can_mail BOOLEAN DEFAULT true" );
	}
			
	public static function uninstall() // À la désactivation du plugin
	{
		global $wpdb;
  $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}messagerie;");
		$wpdb->query("ALTER TABLE {$wpdb->prefix}users DROP can_mail;");
	}
	
	public function add_admin_menu() // On rajoute les interfaces
	{
		global $wpdb;
		$reponse = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM wp_messagerie WHERE unread = 1 AND receiver = %d AND dossier = "inbox"', get_current_user_id()));

		// En fonction du nombres de mails non-lus, on rajoute le nombre au titre (ou pas)
		if ($reponse == 0)
		{
				add_menu_page('Messagerie', 'Messagerie', 'edit_posts', 'messagerie',  array($this, 'administration'), 'dashicons-email-alt');
		}
		else
		{
				add_menu_page('Messagerie', 'Messagerie <span title="' . $reponse . ' nouveaux e-mails" class="update-plugins count-2"><span class="update-count">' . $reponse . '</span></span>', 'edit_posts', 'messagerie',  array($this, 'administration'), 'dashicons-email-alt');
		}
		add_submenu_page('messagerie', 'Options', 'Options', 'delete_users', 'messagerie_options', array($this, 'options'));
	}
	
	public function messagerie_delete_user($user_id) // Suppression d'un utilisateur
	{
		global $wpdb;
		$wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE receiver = %d', $user_id));
		$wpdb->query($wpdb->prepare('DELETE FROM wp_messagerie WHERE sender = %d AND dossier = %s OR %s', $user_id, 'draft', 'trash'));
	}
	
	public function options() // Affichage de la page d'options
	{
		_e('<h1 id="titre_options">Paramètres de Messagerie</h1>');
		echo '<link rel="stylesheet" content="text/css" href="' . plugins_url() . '/messagerie/style.css"/>';
		echo '<script src="' . plugins_url() . '/messagerie/script_options.js"></script>';
		_e('<p id="messagerie_expli">Ici, vous pouvez paramètrer le plugin : par exemple, vous pouvez empêcher certains utilisateurs d\'utiliser la messagerie</p>');
		
		global $wpdb;
		$reponses = $wpdb->get_results('SELECT id, display_name, can_mail FROM wp_users');
		echo '<form method="get" action="" id="send_options"/><input type="hidden" name="action" value="messagerie_options_send"/><table><thead><tr><th>Utilisateur</th><th>Peut envoyer des mails</th></tr></thead>';
		// On affiche le formulaire
		foreach ($reponses as $reponse)
		{?>
				<tr><td><label for="<?php echo $reponse->id; ?>"> <?php echo $reponse->display_name;?></label> </td><td><input type="checkbox" name="<?php echo $reponse->id;?>" <?php checked($reponse->can_mail); ?> /></td></tr>
		<?php
		}
		?>
		<tr><td colspan="2"><input type="submit"/></td></tr>
		</table>
		</form>
<?php
	}
	
	public function administration() // Affichage de la page 
	{
		_e('<h1 id="titre_messagerie" style="display: inline-block;">Messagerie Interne</h1>', 'messagerie');
		// On inclut les scripts et CSS
		echo '<script src=" ' . plugins_url() . '/messagerie/ckeditor/ckeditor.js"></script>';
		echo '<script src=" ' . plugins_url() . '/messagerie/script.js"></script>';
		echo '<link rel="stylesheet" content="text/css" href="' . plugins_url() . '/messagerie/style.css"/>';

		include_once('nav.php');?>

		<div id="messagerie_sidebar">
		<?php include_once('sidebar.php'); ?>
		</div>
		<div id="content_messagerie">
<?php
  include_once('inbox.php');
	}
}
?> </div><?php 

new Messagerie();
?>