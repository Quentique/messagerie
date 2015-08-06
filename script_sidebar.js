jQuery(document).ready(function(){
console.log('hello456');
	var i = '';
	jQuery('#sent_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php #wpbody-content', 'page=messagerie&use=sent', function() {
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');});
		});
	
	jQuery('#trash_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=trash #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		jQuery.getScript('../wp-content/plugins/messagerie/script_trash.js');});
		});
	
	jQuery('#draft_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=draft #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script_draft.js');
		//jQuery.getScript('../wp-content/plugins/messagerie/script_delete.js');
		});
		});
	
	jQuery('#inbox_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=inbox #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');});
		
	});
		
	});