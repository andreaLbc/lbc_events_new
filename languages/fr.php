<?php
$french = array(
/**
 * Menu items and titles
 */
			"item:object:events" => "Agenda",
	        "blockmenu:events" => "Agenda",
		    "groups:enableevents"=>"Autoriser l'Agenda du groupe",
			"events:toolbar" => "Agenda",			
			"events:add" => "Ajouter un événement",
			"events:owner" => "Vos agenda",
		    "events:group"=>"Agenda du groupe",
			
		    "events:title:user_event" => 'Agenda du group %s',
			"events:all" => "Tous les événements",
			"events:invite" => "Invitations",
	        "events:view" => "Voir l'événement",
	        "events:edit"=>"Modifier l'événement",	
			"events:all_title" => "événement",
		    'events:calendar'=>'Agenda',
		
			"events:list_title" => "Vos événements",
			"events:view_title" => "Vos événements",
			"events:edit_title" => "Modifier un événement",
			"events:add_title" => "Ajouter un événement",			
			"events:view:type" =>"Type",
			"events:view:pays" =>"Pays",
			"events:view:rubrique" =>"Rubrique",
			"events:view:theme" =>"Thème",			
	        "events:view:title" => "Titre de l'événement",
			"events:view:description" => "Texte de l'événement",
			"events:view:lieu" =>"Lieu",
			"events:view:datedebut" =>"Date de début",
			"events:view:datefin" =>"Date de fin",
			"events:view:heuredebut" =>"Heure de début",		
			"events:view:heurefin" =>"Heure de fin",
			"events:view:url" =>"Lien",
			"events:view:files" =>"Fichier-s",
			"events:view:tags" =>"Mots-clés",

		
			"events:formAdd:type" =>"Type *",
			"events:formAdd:pays" =>"Pays *",
			"events:formAdd:rubrique" =>"Rubrique *",
			"events:formAdd:theme" =>"Thème *",
	        "events:formAdd:title" => "Titre de l'événement *",
			"events:formAdd:description" => "Texte de l'événement *",
		    "events:formAdd:excerpt "=>'Excerpt',
			"events:formAdd:lieu" =>"Lieu",
			"events:formAdd:datedebut" =>"Date de début *",
			"events:formAdd:datefin" =>"Date de fin *",
			"events:formAdd:heuredebut" =>"Heure de début",		
			"events:formAdd:heurefin:view" =>"Heure de fin",
			"events:formAdd:heuredebut:view" =>"Heure de début",		
			"events:formAdd:heurefin" =>"Heure de fin",			
            "events:formAdd:url" =>"Lien ",
			"events:formAdd:uploadFile" => "Charger un fichier",
			"events:formAdd:uploadImage" => "Charger une image",
			"events:formAdd:tags" =>"Mots-clés",
	        "events:formAdd:access" =>"Accès",

		
	        "events:edit:succes"=>"Votre événement a été enregistré avec succès.",
	        "events:edit:notsucces"=>"Votre événement n'a pas été correctement enregistré. Contactez le-a super administrateur-trice.",
	        "events:delete:confirm"=>"Etes-vous sûr-e de vouloir supprimer cet événement ?",
	        "events:delete:succes"=>"Votre événement a été supprimé avec succès.",
			"events:delete:notsucces"=>"Votre événement n'a pas été correctement supprimé. Contactez le-a super administrateur-trice",
			"events:error:values" =>"Erreur !<br>Vérifiez que tous les champs obligatoires (*) sont remplis.",
			"events:river:create" => "%s a mis a jour une page intitulée",
			"events:river:update" => "%s a mis a jour une page intitulée",
			"events:river:annotate" => "un commentaire sur l'événement",
			"events:actusevenement"=>"Actualités et événement",
			"events:formAdd:uploadFileNew" => "Charger un autre fichier",
			"events:suite" =>"Accéder à l'événement",
			"events:invited:title"=>"Vos invitations à des événements",
			"events:invited:confirmed" =>"(%s) participeront",
			"events:invited:peut-etre" =>"(%s) participeront peut-être",
			"events:invited:attente" =>"(%s) en attente de réponse",
		    "events:invite:title"=>"Vous prendrez part à cet événement?",
			"events:invite:confirm"=>"Oui",
			"events:invite:peut-etre"=>"Peut-être",
			"events:invite:refuse"=>"Non",
			"events:invite:confirm:confirm"=>"Êtes-vous sûr(e) de participer ?",
			"events:invite:peut-etre:confirm"=>"Êtes-vous sûr(e) de participer peut-être ?",
			"events:invite:refuse:confirm"=>"Êtes-vous sûr(e) de ne pas participer ?",
			

/**
 * notification messages
 */

			"events:new" => "Rendez-vous Epodrome.fr",		

	
			"evenement:new:message" => 
"%s %s

Epodrome.fr a inscrit un nouvel événement sur son agenda.
\"%s\" aura lieu le \"%s\".

Cliquez ici pour y obtenir plus de détails sur cet événement : %s

Pour en savoir plus, rendez-vous sur votre espace info sur www.epodrome.fr.",

 "events:invitation:message" => 
"%s %s

Epodrome.fr vous invite à l'événement \"%s\" qui se tiendra à %s le %s.

Cliquez ici pour y obtenir plus de détails sur cet événement : %s

Pour en savoir plus, rendez-vous sur Epodrome.fr." ,

			"events:invitation:subject" => "Invitation à l'événement %s du www.epodrome.fr",
			"events:invite:groups_member"=>"Inviter des groupes / membres",
			"events:invite:all"=>"Inviter tous les membres",
			"events:invite:groups"=>"Groupes",
			"events:invite:members"=>"Inviter de membres",
			
			'Jan' => "Janv",
			'Feb' => "Févr",
			'Mar' => "Mars",
			'Apr' => "Avr",
			'May' => "Mai",
			'Jun' => "Juin",
			'Jul' => "Juil",
			'Aug' => "Août",
			'Sep' => "Sept",
			'Oct' => "Oct",
			'Nov' => "Nov",
			'Dec' => "Déc",

);
add_translation("fr",$french);