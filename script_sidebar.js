jQuery(document).ready(function(){
	var i = '';
	jQuery('#sent_folder').click(function () {
		i = '&use=sent';
		get();
		});
	
	jQuery('#trash_folder').click(function() {
		i = '&use=trash';
		get();
		});
	
	jQuery('#draft_folder').click(function() {
		i = '?page=messagerie&use=draft';
		get();
		});
	
	jQuery('#inbox_folder').click(function () {
		i = '?page=messagerie';
		get();
	});
		
	function get()
	{

		jQuery.ajax({
		url : i,
		type : 'GET',
		dataType : 'html',
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