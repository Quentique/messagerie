jQuery(document).ready(function () {
alert('it works');
jQuery('#send_options').submit(function (e) {
e.preventDefault();
alert('it works2');
jQuery('#messagerie_expli').append('<div class="loader"></div>');
var donnees = jQuery(this).serialize();
jQuery.ajax({
	url : ajaxurl,
	cache : false,
	type : 'GET',
	data : donnees,
	
	success : function (code_html, status) {
	alert('it works3');
	jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
		jQuery.getScript('../wp-content/plugins/messagerie/script_options.js');
		if (code_html.endsWith('0'))
		{
		jQuery('#titre_options').append('<span id ="popup" style="background-color: red;">Erreur lors de la mise à jour</span>');
		}
		else
		{
		jQuery('#titre_options').append('<span id="popup" style="background-color: green;">Mise à jour des paramètres effectuée !</span>');
		}
		
		jQuery('#popup').delay(3000).fadeOut('slow');
	
	});
	}



});
});

});