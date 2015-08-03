<nav>
	<ul id="messagerie_nav">

		<li><a href="#" id="new_email"><?php _e('New', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['use'] == read)
		{
		?>
		
		<li><a href="#" id="answer_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Answer', 'messagerie'); ?></a></li>
		<li><a href="#" id="forward_mail" id_message="<?php echo $_GET['mail'];?>"><?php _e('Forward', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>