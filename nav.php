<nav>
	<ul id="messagerie_nav">
		<li><a href="#" id="new_email"><?php _e('Nouveau', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['use'] == read && $_GET['trash'] == "0") // Si on lit et qu'on est pas en train de lire un message supprimé, on affiche les liens qui permettent de répondre et de transmettre
		{ ?>
		<li><a href="#" id="answer_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Répondre', 'messagerie'); ?></a></li>
		<li><a href="#" id="forward_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Transférer', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>