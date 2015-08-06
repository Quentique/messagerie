		var i = '';
		jQuery(document).ready(function(){
		alert('hellol');
    jQuery('#new_email').on('click', function () {
	jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=compose #wpbody-content', function(){;
				get();
				});
				}
				);
				
			jQuery('#answer_mail').click(function (e) {
			jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=answer&mail=' + jQuery(e.target).attr('id_message')+ ' #wpbody-content', function() { get();});
				get();
				}
				);
				
				jQuery('#forward_mail').click(function (e) {
				jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=forward&mail=' + jQuery(e.target).attr('id_message')+ ' #wpbody-content', function() { get();});
				get();
				});
				
				function get()
				{
											/*var code = document.createElement('script');
											code.src = '<?php echo plugin_dir_url(__FILE__); ?>script_ck.js';
											code.type = 'text/javascript';
											*/
											jQuery.getScript('../wp-content/plugins/messagerie/script_ck.js');
											jQuery.getScript('../wp-content/plugins/messagerie/script_send.js');
											jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
											
											/*var code2 = document.createElement('script');
											code2.src='<?php echo plugin_dir_url(__FILE__); ?>script_send.js';
											code2.type = 'text/javascript';
											document.getElementById('composition').appendChild(code);
											document.getElementById('composition').appendChild(code2);*/
											}


    
				
   

});