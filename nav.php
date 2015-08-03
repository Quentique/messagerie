<nav>
	<ul id="messagerie_nav">

		<li><a href="#" id="new_email"><?php _e('New', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['use'] == read)
		{
		?>
		
		<li><a href="#" id="answer_mail"><?php _e('Answer', 'messagerie'); ?></a></li>
		<li><a href="#" id="forward_mail"><?php _e('Forward', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
		<script>
		var i = '';
		jQuery(document).ready(function(){
    jQuery('#new_email').on('click', function () {
				jQuery('#content_messagerie').load('admin.php?page=messagerie&use=compose #content_messagerie', function(){;
				get();});
				}
				);
				
			jQuery('#answer_mail').click(function () {
				jQuery('#content_messagerie').load('admin.php?page=messagerie&use=answer&mail=<?php echo $_GET['mail'];?> #content_messagerie', function() { get();});
				get();
				}
				);
				
				jQuery('#forward_mail').click(function () {
				jQuery('#content_messagerie').load('admin.php?page=messagerie&use=forward&mail=<?php echo $_GET['mail'];?> #content_messagerie', function() { get();});
				get();
				});
				
				function get()
				{
											/*var code = document.createElement('script');
											code.src = '<?php echo plugin_dir_url(__FILE__); ?>script_ck.js';
											code.type = 'text/javascript';
											*/
											jQuery.getScript('<?php echo plugin_dir_url(__FILE__); ?>script_ck.js');
											jQuery.getScript('<?php echo plugin_dir_url(__FILE__); ?>script_send.js');
											
											/*var code2 = document.createElement('script');
											code2.src='<?php echo plugin_dir_url(__FILE__); ?>script_send.js';
											code2.type = 'text/javascript';
											document.getElementById('composition').appendChild(code);
											document.getElementById('composition').appendChild(code2);*/
											}


    
				
   

});



		</script>