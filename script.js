jQuery(document).ready(function(){
console.log('alert3');
jQuery('#inbox .messagerie_draft').click(function (e) {
alert('hello4');
jQuery('#inbox').append('<div class="loader"></div>');
	jQuery('#wpbody').load('admin.php?page=messagerie&use=continue&mail=' + jQuery(e.target).attr('id_message') + ' #wpbody-content', function () {
	jQuery.getScript('../wp-content/plugins/messagerie/script.js');
	});
});
jQuery('#inbox .messagerie_read').click(function (a) {
alert('hello2');
alert(jQuery(a.target).attr('trash'));
	if (typeof jQuery(a.target).attr('trash') == 'undefined')
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
alert(jQuery(f.target).closest("a").attr('id_message'));
jQuery('#inbox').append('<div class="loader"></div>');
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
alert(jQuery(f.target).closest("a").attr('id_message'));
jQuery('#inbox').append('<div class="loader"></div>');
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

		alert('hellol');
    jQuery('#new_email').on('click', function () {
	jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=compose #wpbody-content', function(){;
				get();
				});
				}
				);
				
			jQuery('#answer_mail').click(function (h) {
			jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=answer&mail=' + jQuery(h.target).attr('id_message')+ ' #wpbody-content', function() { get();});
				get();
				}
				);
				
				jQuery('#forward_mail').click(function (b) {
				jQuery('#inbox').append('<div class="loader"></div>');
				jQuery('#wpbody').load('admin.php?page=messagerie&use=forward&mail=' + jQuery(b.target).attr('id_message')+ ' #wpbody-content', function() { get();});
				get();
				});
				
				function get()
				{
											/*var code = document.createElement('script');
											code.src = '<?php echo plugin_dir_url(__FILE__); ?>script_ck.js';
											code.type = 'text/javascript';
											*/
											jQuery.getScript('../wp-content/plugins/messagerie/script.js');
											
											/*var code2 = document.createElement('script');
											code2.src='<?php echo plugin_dir_url(__FILE__); ?>script_send.js';
											code2.type = 'text/javascript';
											document.getElementById('composition').appendChild(code);
											document.getElementById('composition').appendChild(code2);*/
											}

jQuery('#inbox .messagerie_undo').click(function (g) {
jQuery('#inbox').append('<div class="loader"></div>');
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
jQuery('#inbox').append('<div class="loader"></div>');
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
		   jQuery('#wpbody').load(code_html.substring(7) + ' #wpbody-content', function() {
		   jQuery.getScript('../wp-content/plugins/messagerie/script.js');
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
	jQuery('#inbox').append('<div class="loader"></div>');
    jQuery("input[type=submit]", jQuery(this).parents("form")).removeAttr("clicked");
    jQuery(this).attr("clicked", "true");
});
	jQuery('#sent_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php #wpbody-content', 'page=messagerie&use=sent', function() {
		jQuery.getScript('../wp-content/plugins/messagerie/script.js');});
		});
	
	jQuery('#trash_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=trash #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script.js');});
		});
	
	jQuery('#draft_folder').click(function() {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=draft #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script.js');
		//jQuery.getScript('../wp-content/plugins/messagerie/script_delete.js');
		});
		});
	
	jQuery('#inbox_folder').click(function () {
		jQuery('#inbox').append('<div class="loader"></div>');
		jQuery('#wpbody').load('admin.php?page=messagerie&use=inbox #wpbody-content', function () {
		jQuery.getScript('../wp-content/plugins/messagerie/script.js');});
		
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
}
);
	}
});
