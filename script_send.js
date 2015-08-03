
	jQuery('#send_mail').submit(function (e) {
	 e.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire

    for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
    }

	 var idbouton = jQuery("input[type=submit][clicked=true]").attr('name');
    var donnees = jQuery(this).serialize(); // On créer une variable content le formulaire sérialisé
	 var texte = '';
	 alert(idbouton);
	 if (idbouton == 'envoie')
	 {
	 texte = '&envoie=';
	 }
	 else
	 {
	 texte = '&brouillon=';
	 }
	alert(donnees);
	console.log('hello');
	jQuery.ajax({
		url : ajaxurl,
		type : 'POST',
		cache: false,
		data : donnees + texte,

	      success : function(code_html, statut){
		  alert(code_html);
           //jQuery(code_html).appendTo("#composition"); // On passe code_html à jQuery() qui va nous créer l'arbre DOM !
		   jQuery('#wpbody-content').load(code_html.substring(7) + ' #wpbody-content', function() {
		   jQuery.getScript('../wp-content/plugins/messagerie/script_nav.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_sidebar.js');
		   jQuery.getScript('../wp-content/plugins/messagerie/script_read.js');
		   if (code_html.endsWith('1'))
		   {
	jQuery('#titre_messagerie').append('<span style="background-color: green" id="popup">Mail correctement envoyé !</span>');
	}
	else if (code_html.endsWith('0'))
	{
	jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Erreur lors de l\'envoi</span>');
	}
	else if (code_html.endsWith('2'))   
	{
	jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Erreur lors de la sauvegarde</span>');
	}
	else if (code_html.endsWith('3'))
	{
	jQuery('#titre_messagerie').append('<span style="background-color: green" id="popup">Mail sauvegardé! </span>');
	}
	
	jQuery('#popup').delay(3000).fadeOut('slow');
	
	});
       },
	
	
	
	});
});

jQuery("form input[type=submit]").click(function() {
	 /*(function (){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
		alert(CKEDITOR.instances[instance].getData());
});*/
/*var instance = CKEDITOR.instances.content;
instance.updateElement();*/

    jQuery("input[type=submit]", jQuery(this).parents("form")).removeAttr("clicked");
    jQuery(this).attr("clicked", "true");
});
