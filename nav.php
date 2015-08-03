<nav>
	<ul id="messagerie_nav">

		<li><a href="#" id="new_email"><?php _e('New', 'messagerie'); ?></a></li>
		<?php 
		if ($_GET['action'] == read)
		{
		?>
		
		<li><a href="#" id="answer_mail"><?php _e('Answer', 'messagerie'); ?></a></li>
		<li><a href="#" id="forward_mail"><?php _e('Forward', 'messagerie'); ?></a></li>
		<?php
		} ?>
	</ul>
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
		var i = '';
		jQuery(document).ready(function(){
    jQuery('#new_email').on('click', function () {
				i = '?page=messagerie&action=compose';
				get();
				}
				);
				
			jQuery('#answer_mail').click(function () {
				i = '?page=messagerie&action=answer&mail=<?php echo $_GET['mail'];?>';
				get();
				}
				);
				
				jQuery('#forward_mail').click(function () {
				i = '?page=messagerie&action=forward&mail=<?php echo $_GET['mail'];?>';
				get();
				});
				
				function get()
				{

					jQuery.ajax({
       url : i,
							type : 'GET',
							dataType : 'html',
							success : 	function(code_html, statut) {
											var code = document.createElement('script');
											code.src = '<?php echo plugin_dir_url(__FILE__); ?>script_ck.js';
											code.type = 'text/javascript';
											
											var code2 = document.createElement('script');
											code2.src='<?php echo plugin_dir_url(__FILE__); ?>script_send.js';
											code2.type = 'text/javascript';
											jQuery('#content_messagerie').replaceWith(jQuery(code_html).find('#content_messagerie'));
											document.getElementById('composition').appendChild(code);
											document.getElementById('composition').appendChild(code2);
											},

       error : function(resultat, statut, erreur){
         
       },

       complete : function(resultat, statut){

       }
    });
				
   
}
});



		</script>