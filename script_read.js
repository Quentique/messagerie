jQuery(document).ready(function(){
alert('hello');
jQuery('#inbox .messagerie_lien').click(function (e) {
alert('hello2');
	jQuery('#wpbody-content').load('admin.php?page=messagerie&use=read&mail=' + jQuery(e.target).attr('id_message') + ' #wpbody-content', function (){
	jQuery.getScript('../wp-content/plugins/messagerie/script_ck2.js');
	jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
	jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
	});
	});

jQuery('#inbox .messagerie_action').click(function (f) {
alert(jQuery(f.target).closest("a").attr('id_message'));
jQuery.ajax({
		url : ajaxurl,
		type : 'GET',
		cache: false,
		data : 'action=delete_mail&mail=' + jQuery(f.target).closest('a').attr('id_message'),

	      success : function(code_html, statut){
		  jQuery('#wpbody-content').load(code_html.substring(7) + ' #wpbody-content', function() {
		  
		   jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		   if (code_html.endsWith('1'))
		   {
			jQuery('#titre_messagerie').append('<span style="background-color: green" id="popup">Mail supprimé !</span>');
			}
			else if (code_html.endsWith('0'))
			{
			jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Erreur lors de la suppression !</span>');
			}
			
			jQuery('#popup').delay(3000).fadeOut('slow');

		  });
		  }
		  });

});

});