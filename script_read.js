jQuery(document).ready(function(){
alert('hello');
jQuery('#inbox').on('click', '.messagerie_lien', function (e) {
alert('hello2');
	jQuery('#wpbody-content').load('admin.php?page=messagerie&use=read&mail=' + jQuery(e.target).attr('id_message') + ' #wpbody-content', function (){
	jQuery.getScript('../wp-content/plugins/messagerie/script_ck2.js');
	jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
	jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
	});
	});
});