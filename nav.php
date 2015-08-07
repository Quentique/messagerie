<nav>
	<ul id="messagerie_nav">
		<li><a href="#" id="new_email"><?php _e('Nouveau', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['use'] == read && $_GET['trash'] == "0")
		{ ?>
		<li><a href="#" id="answer_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Répondre', 'messagerie'); ?></a></li>
		<li><a href="#" id="forward_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Transférer', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>