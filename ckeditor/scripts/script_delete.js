jQuery(document).ready(function(){
alert('hellotroisfois');
jQuery('#inbox').on('click', '.messagerie_delete', function (f) {
alert('rf');
jQuery.ajax({
		url : ajaxurl,
		type : 'GET',
		cache: false,
		data : 'action=delete_draft&mail=' + jQuery(f.target).attr('id_message'),

	      success : function(code_htmll, statut){
		  jQuery('#wpbody-content').load(code_htmll.substring(7) + ' #wpbody-content', function() {
		  alert('rfs');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		   if (code_htmll.endsWith('1'))
		   {
			jQuery('#titre_messagerie').append('<span style="background-color: green" id="popup">Mail supprimé !</span>');
			}
			else if (code_html.endsWith('0'))
			{
			jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Erreur lors de la suppression !</span>');
			}

		  
		  });
		  });
});

});