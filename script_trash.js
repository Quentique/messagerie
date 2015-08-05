jQuery(document).ready(function () {
alert('test');
jQuery('#inbox .messagerie_delete').click(function (g) {
jQuery.ajax({
		url : ajaxurl,
		type : 'GET',
		cache: false,
		data : 'action=undo&mail=' + jQuery(g.target).closest('a').attr('id_message'),

	      success : function(code_html, statut){
		  jQuery('#wpbody-content').load(code_html.substring(7) + ' #wpbody-content', function() {
		  
		   jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_trash.js');
		   if (code_html.endsWith('1'))
		   {
			jQuery('#titre_messagerie').append('<span style="background-color: green" id="popup">Mail correctement restauré !</span>');
			}
			else if (code_html.endsWith('0'))
			{
			jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Erreur lors de la restauration du mail !</span>');
			}
			
			jQuery('#popup').delay(3000).fadeOut('slow');

		  });
		  }
		  });

});

});