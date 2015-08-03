jQuery(document).ready(function(){
	var i = '';
	jQuery('#sent_folder').click(function () {
		jQuery('#content_messagerie').load('admin.php #content_messagerie', 'page=messagerie&use=sent', function() {
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');});
		});
	
	jQuery('#trash_folder').click(function() {
		jQuery('#content_messagerie').load('admin.php?page=messagerie&use=trash #content_messagerie');
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		});
	
	jQuery('#draft_folder').click(function() {
		jQuery('#content_messagerie').load('admin.php?page=messagerie&use=draft #content_messagerie');
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		});
	
	jQuery('#inbox_folder').click(function () {
		jQuery('#content_messagerie').load('admin.php?page=messagerie&use=inbox #content_messagerie');
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		
	});
		
	function get()
	{

		jQuery.ajax({
		url : ajaxurl,
		type : 'GET',
		dataType : 'html',
		data : 'action=redirect' + i,
		success : 	function(code_html, statut) {
			jQuery('#content_messagerie').replaceWith($(code_html).find('#content_messagerie'));
		},

		error : function(resultat, statut, erreur){
         
		},

		complete : function(resultat, statut){

		}
		});
	}
	});