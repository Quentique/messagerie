jQuery(document).ready(function(){
alert('hello3');
jQuery('#inbox').on('click', '.messagerie_lien', function (e) {
alert('hello4');
	jQuery('#wpbody-content').load('admin.php?page=messagerie&use=continue&mail=' + jQuery(e.target).attr('id_message') + ' #wpbody-content', function () {
	jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
	});
});
});