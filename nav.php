<nav>
	<ul id="messagerie_nav">
		<li><a href="?page=messagerie&action=compose"><?php _e('New', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['action'] == read)
		{
		?>
		<li><a href="?page=messagerie&action=answer&mail=<?php echo $_GET['mail'];?>"><?php _e('Answer', 'messagerie'); ?></a></li>
		<li><a href="?page=messagerie&action=forward&mail=<?php echo $_GET['mail'];?>"><?php _e('Forward', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>