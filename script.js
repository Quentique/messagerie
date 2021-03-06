jQuery(document).ready(function(){

	jQuery('#inbox .messagerie_draft').click(function (e) { 
	// Quand on appuie sur le lien pour continuer le mail
		jQuery('#inbox').append('<div class="loader"></div>'); // Affiche un div qui fait un loader
		jQuery('#wpbody').load('admin.php?page=messagerie&use=continue&mail=' + jQuery(e.target).attr('id_message') + ' #wpbody-content', function () {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js'); // On ré-injecte le script
		});
	});
	
	jQuery('#inbox .messagerie_read').click(function (a) {
		if (typeof jQuery(a.target).attr('trash') == 'undefined') // Permet de savoir si on est dans le dossier poubelle
		{
			var trash = "&trash=0";
		}
		else
		{
		var trash = "&trash=1";
		}
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=read&mail=' + jQuery(a.target).attr('id_message') + trash + ' #wpbody-content', function (){
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});

	jQuery('#inbox .messagerie_delete').click(function (f) {
		jQuery('#inbox').append('<div class="loader"></div>');
		// Requête AJAX pour supprimer le message
		jQuery.ajax({
			url : ajaxurl,
			type : 'GET',
			cache: false,
			data : 'action=delete_mail&mail=' + jQuery(f.target).closest('a').attr('id_message'),

			success : function(code_html, statut){
				jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
					jQuery.getScript('../wp-content/plugins/messagerie/script.js');
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
	
	jQuery('#inbox .messagerie_delete_draft').click(function (f) {
		jQuery('#inbox').append('<div class="loader"></div>');
		// Requête pour supprimer le BROUILLON
		jQuery.ajax({
			url : ajaxurl,
			type : 'GET',
			cache: false,
			data : 'action=delete_draft&mail=' + jQuery(f.target).closest("a").attr('id_message'),

			success : function(code_html, statut){
				jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
					jQuery.getScript('../wp-content/plugins/messagerie/script.js');
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


		
    jQuery('#new_email').on('click', function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=compose #wpbody-content', function(){;
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});		
				
	jQuery('#answer_mail').click(function (h) {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=answer&mail=' + jQuery(h.target).attr('id_message')+ ' #wpbody-content', function() {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});
				
	jQuery('#forward_mail').click(function (b) {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=forward&mail=' + jQuery(b.target).attr('id_message')+ ' #wpbody-content', function() { 
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});			

	jQuery('#inbox .messagerie_undo').click(function (g) {
		jQuery('#inbox').append('<div class="loader"></div>');
		// Requête pour remettre un message supprimé en boîte de réception
		jQuery.ajax({
			url : ajaxurl,
			type : 'GET',
			cache: false,
			data : 'action=undo&mail=' + jQuery(g.target).closest('a').attr('id_message'),

			success : function(code_html, statut){
				jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
		  
					jQuery.getScript('../wp-content/plugins/messagerie/script.js');
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

	jQuery('#messagerie_send_mail').submit(function (e) {
		e.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire
		jQuery('#messagerie_send_mail').append('<div class="loader"></div>'); // LOADER
		
		// On update les textareas en ré_injectant la valeur dans les textareas
		for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
		}
	
		var idbouton = jQuery("input[type=submit][clicked=true]").attr('name'); // On récupère le bouton cliqué
		var donnees = jQuery(this).serialize(); // On créer une variable content le formulaire sérialisé
		var texte = '';
		if (idbouton == 'envoie') // Permet de savoir si on envoie ou on sauvegarde l'email
		{
			texte = '&envoie=';
		}
		else
		{
			texte = '&brouillon=';
		}
		
		// REQUETE
		jQuery.ajax({
			url : ajaxurl,
			type : 'POST',
			cache: false,
			data : donnees + texte,

			success : function(code_html, statut){
				jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
					jQuery.getScript('../wp-content/plugins/messagerie/script.js');
					
					// On affiche un message en fonction de le réponse
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
					else if (code_html.endsWith('4'))
					{
						jQuery('#titre_messagerie').append('<span style="background-color: red" id="popup">Vous ne pouvez pas envoyer de messages, votre message a été placé dans les brouillons. Vous pouvez envoyer un message à votre administrateur pour de plus amples informations</span>');
					}
					jQuery('#popup').delay(3000).fadeOut('slow');
				});
			},	
		});
	});

	jQuery("form input[type=submit]").click(function() {
		// Ajoute l'attribut permettant de savoir quel bouton a été cliqué.
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery("input[type=submit]", jQuery(this).parents("form")).removeAttr("clicked");
		jQuery(this).attr("clicked", "true");
	});
	
	jQuery('#sent_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php #wpbody-content', 'page=messagerie&use=sent', function() {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});
	
	jQuery('#trash_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=trash #wpbody-content', function () {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});
	
	jQuery('#draft_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=draft #wpbody-content', function () {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		});
	});
	
	jQuery('#inbox_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=inbox #wpbody-content', function () {
			jQuery.getScript('../wp-content/plugins/messagerie/script.js');
			});
	});

	if (jQuery('#test2').length)
	{
		CKEDITOR.replace('test2'); 
		var editor;

		CKEDITOR.on( 'instanceReady', function( ev ) {
			editor = ev.editor;
			editor.setReadOnly(true);
		});
	}
	
	if (jQuery('#txt-aref').length)
	{
		var editor; 
		CKEDITOR.replace('txt-aref');
		CKEDITOR.on( 'instanceReady', function( ev ) { 
			editor = ev.editor; 
			editor.setReadOnly(false);
		});
	}
});