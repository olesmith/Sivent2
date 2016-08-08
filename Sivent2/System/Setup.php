<?php
    array
    (
       "DefaultAction" => "Start",
       "CSSFile"       => "sipos.css",
       "DefaultProfile" => 2,
       "LoginPermissionVars" => array(),
       "SqlTableVars" => array("SqlVars"),
       "CommonData" => array
       (
          "Hashes" => array
          (
             "Login" => "Auth.Data.php",
             "MySql" => ".DB.php",
             "Mail" => ".Mail.php",
          ),
       ),
       "AllowedModules" => array
       (
          "Logs",
          "Units",
          "Friends",
          
          "Events",
          "Datas",
          "GroupDatas",
          
          "Permissions",
          
          "Sponsors",

          "Collaborations",
          "Collaborators",
          
          "Inscriptions",
          "Caravans",
          "Caravaneers",
          
          "Areas",
          "Submissions",
          
          "Criterias",
          "Assessors",
          "Assessments",
          
          "Certificates",
          
          "Dates",
          "Times",
          "Places",
          "Rooms",
          "Schedules",
          
          "Speakers",
          "PreInscriptions",
       ),
       "ModuleDependencies" => array
       (
          "Logs" => array(),
          "Units" => array("Friends"),
          "Friends" => array("Units"),
          "Events" => array("Friends","Datas","GroupDatas"),
          "Datas" => array("Events"),
          "GroupDatas" => array("Events"),
          "Sponsors" => array("Units","Events"),
          "Permissions" => array("Units","Events"),
          "Inscriptions" => array("Datas","GroupDatas"),
          
          "Collaborations" => array("Units","Events"),
          "Collaborators" => array("Collaborations","Inscriptions"),

          "Caravans" => array("Inscriptions"),
          "Caravaneers" => array("Caravans"),
          
          "Areas" => array("Events"),
          
          "Submissions" => array("Inscriptions","Areas"),
          
          "Criterias" => array("Submissions"),
          "Assessors" => array("Submissions"),
          "Assessments" => array("Assessors","Criterias"),
          
          "Certificates" => array("Inscriptions","Caravaneers","Collaborations","Submissions"),
          
          "Dates" => array("Events"),
          "Times" => array("Dates"),
          "Places" => array("Events"),
          "Rooms" => array("Places"),
          "Schedules" => array("Dates","Times","Rooms"),
          
          "Speakers" => array("Friends","Submissions"),
          "PreInscriptions" => array("Friends","Inscriptions","Submissions"),
       ),
       "SubModulesVars" => array
       (
         "Logs" => array
          (
             "SqlObject" => "LogsObject",
             "SqlClass" => "Logs",
             "SqlFile" => "Logs.php",
             "SqlHref" => TRUE,
             "SqlTable" => "Logs",
             "SqlFilter" => "#Message",
             "SqlDerivedData" => array("Message"),

             "ItemName"      => "Log Entry",
             "ItemsName"     => "Log Entries",
             "ItemNamer"    => "ID",

             "ItemName_UK"   => "Log Entry",
             "ItemsName_UK"  => "Log Entries",
             "ItemNamer_UK" => "ID",
         ),
         "Friends" => array
          (
             "SqlObject" => "FriendsObject",
             "SqlClass" => "Friends",
             "SqlFile" => "Friends.php",
             "SqlHref" => TRUE,
             "SqlTable" => "Friends",
             "SqlFilter" => "#Name (#Email)",
             "SqlFilter_Public" => "#Name",
             "SqlDerivedData" => array("Name","Email"),

             "ItemName"      => "Usuário",
             "ItemsName"     => "Usuários",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "User",
             "ItemsName_UK"  => "Users",
             "ItemsNamer_UK" => "Name",
         ),
         "Units" => array
          (
             "SqlAccessor" => "UnitsObj",
             "SqlObject" => "UnitsObject",
             "SqlClass" => "Units",
             "SqlFile" => "Units.php",
             "SqlHref" => TRUE,
             "SqlTable" => "Units",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Entidade",
             "ItemsName"     => "Entidades",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Entity",
             "ItemsName_UK"  => "Entities",
             "ItemsNamer_UK" => "Name",
         ),
         "Events" => array
          (
             "SqlAccessor" => "EventsObj",
             "SqlObject" => "EventsObject",
             "SqlClass" => "Events",
             "SqlFile" => "Events.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Events",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name","Unit"),

             "ItemName"      => "Evento",
             "ItemsName"     => "Eventos",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Event",
             "ItemsName_UK"  => "Events",
             "ItemsNamer_UK" => "Name_UK",
         ),
         "Datas" => array
          (
             "SqlAccessor" => "DatasObj",
             "SqlObject" => "DatasObject",
             "SqlClass" => "Datas",
             "SqlFile" => "Datas.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Datas",
             "SqlFilter" => "#SqlKey",
             "SqlDerivedData" => array("SqlKey","Event"),

             "ItemName"      => "Dado, Questionário",
             "ItemsName"     => "Dados, Questionário",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Data, Questionary",
             "ItemsName_UK"  => "Datas, Questionary",
             "ItemsNamer_UK" => "Name",
         ),
         "GroupDatas" => array
          (
             "SqlAccessor" => "GroupDatasObj",
             "SqlObject" => "GroupDatasObject",
             "SqlClass" => "GroupDatas",
             "SqlFile" => "GroupDatas.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__GroupDatas",
             "SqlFilter" => "#Text",
             "SqlDerivedData" => array("Text","Event"),

             "ItemName"      => "Grupo, Questionário",
             "ItemsName"     => "Grupos, Questionário",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Group, Questionary",
             "ItemsName_UK"  => "Groups, Questionary",
             "ItemsNamer_UK" => "Name",
         ),
         "Inscriptions" => array
          (
             "SqlAccessor" => "InscriptionsObj",
             "SqlObject" => "InscriptionsObject",
             "SqlClass" => "Inscriptions",
             "SqlFile" => "Inscriptions.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Inscriptions",
             "SqlFilter" => "#Friend",
             "SqlDerivedData" => array("Friend","Event"),

             "ItemName"      => "Inscrição",
             "ItemsName"     => "Inscrições",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Inscription",
             "ItemsName_UK"  => "Inscriptions",
             "ItemsNamer_UK" => "Name",
         ),
         "Sponsors" => array
          (
             "SqlAccessor" => "SponsorsObj",
             "SqlObject" => "SponsorsObject",
             "SqlClass" => "Sponsors",
             "SqlFile" => "Sponsors.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Sponsors",
             "SqlFilter" => "#Initials - #Name",
             "SqlDerivedData" => array("Initials","Name"),

             "ItemName"      => "Patrocinador",
             "ItemsName"     => "Patrocinadores",
             "ItemsNamer"    => "Initials",

             "ItemName_UK"   => "Sponsor",
             "ItemsName_UK"  => "Sponsors",
             "ItemsNamer_UK" => "Initials",
         ),
         "Permissions" => array
          (
             "SqlAccessor" => "PermissionsObj",
             "SqlObject" => "PermissionsObject",
             "SqlClass" => "Permissions",
             "SqlFile" => "Permissions.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Permissions",
             "SqlFilter" => "#ID #Event",
             "SqlDerivedData" => array("ID","Event"),

             "ItemName"      => "Permissão",
             "ItemsName"     => "Permissões",
             "ItemsNamer"    => "ID",

             "ItemName_UK"   => "Permission",
             "ItemsName_UK"  => "Permissions",
             "ItemsNamer_UK" => "ID",
         ),
         "Collaborations" => array
          (
             "SqlAccessor" => "CollaborationsObj",
             "SqlObject" => "CollaborationsObject",
             "SqlClass" => "Collaborations",
             "SqlFile" => "Collaborations.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Collaborations",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Colaboração",
             "ItemsName"     => "Colaborações",
             "ItemsNamer"    => "ID",

             "ItemName_UK"   => "Collaboration",
             "ItemsName_UK"  => "Collaborations",
             "ItemsNamer_UK" => "ID",
         ),
         "Collaborators" => array
          (
             "SqlAccessor" => "CollaboratorsObj",
             "SqlObject" => "CollaboratorsObject",
             "SqlClass" => "Collaborators",
             "SqlFile" => "Collaborators.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Collaborators",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Colaborador",
             "ItemsName"     => "Colaboradores",
             "ItemsNamer"    => "ID",

             "ItemName_UK"   => "Collaborator",
             "ItemsName_UK"  => "Collaborators",
             "ItemsNamer_UK" => "ID",
         ),
         "Caravaneers" => array
          (
             "SqlAccessor" => "CaravaneersObj",
             "SqlObject" => "CaravaneersObject",
             "SqlClass" => "Caravaneers",
             "SqlFile" => "Caravaneers.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Caravaneers",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Caravaneiro(a)",
             "ItemsName"     => "Caravaneiro(a)s",
             "ItemsNamer"    => "ID",

             "ItemName_UK"   => "Caravaneer",
             "ItemsName_UK"  => "Caravaneers",
             "ItemsNamer_UK" => "ID",
         ),
         "Caravans" => array
          (
             "SqlAccessor" => "CaravansObj",
             "SqlObject" => "CaravansObject",
             "SqlClass" => "Caravans",
             "SqlFile" => "Caravans.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Inscriptions",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Caravana",
             "ItemsName"     => "Caravanas",
             "ItemsNamer"    => "ID",

             "ItemName_UK"   => "Caravan",
             "ItemsName_UK"  => "Caravans",
             "ItemsNamer_UK" => "ID",
         ),
         "Submissions" => array
          (
             "SqlAccessor" => "SubmissionsObj",
             "SqlObject" => "SubmissionsObject",
             "SqlClass" => "Submissions",
             "SqlFile" => "Submissions.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Submissions",
             "SqlFilter" => "#Name: #Title",
             "SqlDerivedData" => array("Name","Title"),

             "ItemName"      => "Atividade",
             "ItemsName"     => "Atividades",
             "ItemsNamer"    => "Title",

             "ItemName_UK"   => "Activity",
             "ItemsName_UK"  => "Activities",
             "ItemsNamer_UK" => "Title_UK",
         ),
         "Areas" => array
          (
             "SqlAccessor" => "AreasObj",
             "SqlObject" => "AreasObject",
             "SqlClass" => "Areas",
             "SqlFile" => "Areas.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Areas",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Trilha",
             "ItemsName"     => "Trilhas",
             "ItemsNamer"    => "Title",

             "ItemName_UK"   => "Area of Interest",
             "ItemsName_UK"  => "Areas of Interest",
             "ItemsNamer_UK" => "Title_UK",
         ),
         "Certificates" => array
          (
             "SqlAccessor" => "CertificatesObj",
             "SqlObject" => "CertificatesObject",
             "SqlClass" => "Certificates",
             "SqlFile" => "Certificates.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Certificates",
             "SqlFilter" => "#Code, #Name",
             "SqlDerivedData" => array("Code","Name"),

             "ItemName"      => "Certificado",
             "ItemsName"     => "Certificados",
             "ItemsNamer"    => "Code",

             "ItemName_UK"   => "Certificate",
             "ItemsName_UK"  => "Certificates",
             "ItemsNamer_UK" => "Code",
         ),
         "Dates" => array
          (
             "SqlAccessor" => "DatesObj",
             "SqlObject" => "DatesObject",
             "SqlClass" => "Dates",
             "SqlFile" => "Dates.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Dates",
             "SqlFilter" => "#Title",
             "SqlDerivedData" => array("Name","Title"),

             "ItemName"      => "Data",
             "ItemsName"     => "Datas",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Date",
             "ItemsName_UK"  => "Dates",
             "ItemsNamer_UK" => "Name",
         ),
         "Times" => array
          (
             "SqlAccessor" => "TimesObj",
             "SqlObject" => "TimesObject",
             "SqlClass" => "Times",
             "SqlFile" => "Times.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Times",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Horário",
             "ItemsName"     => "Horários",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Time Slot",
             "ItemsName_UK"  => "Time Slots",
             "ItemsNamer_UK" => "Name",
         ),
         "Places" => array
          (
             "SqlAccessor" => "PlacesObj",
             "SqlObject" => "PlacesObject",
             "SqlClass" => "Places",
             "SqlFile" => "Places.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Places",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Local",
             "ItemsName"     => "Locais",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Place",
             "ItemsName_UK"  => "Places",
             "ItemsNamer_UK" => "Name",
         ),
         "Rooms" => array
          (
             "SqlAccessor" => "RoomsObj",
             "SqlObject" => "RoomsObject",
             "SqlClass" => "Rooms",
             "SqlFile" => "Rooms.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Rooms",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Sala",
             "ItemsName"     => "Salas",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Room",
             "ItemsName_UK"  => "Rooms",
             "ItemsNamer_UK" => "Name",
         ),
         "Schedules" => array
          (
             "SqlAccessor" => "SchedulesObj",
             "SqlObject" => "SchedulesObject",
             "SqlClass" => "Schedules",
             "SqlFile" => "Schedules.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__Schedules",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Slot",
             "ItemsName"     => "Slots",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Slot",
             "ItemsName_UK"  => "Slots",
             "ItemsNamer_UK" => "Name",
         ),
         "Speakers" => array
          (
             "SqlAccessor" => "SpeakersObj",
             "SqlObject" => "SpeakersObject",
             "SqlClass" => "Speakers",
             "SqlFile" => "Speakers.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Speakers",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Palestrante",
             "ItemsName"     => "Palestrantes",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Speaker",
             "ItemsName_UK"  => "Speakers",
             "ItemsNamer_UK" => "Name",
         ),
         
         "PreInscriptions" => array
          (
             "SqlAccessor" => "PreInscriptionsObj",
             "SqlObject" => "PreInscriptionsObject",
             "SqlClass" => "PreInscriptions",
             "SqlFile" => "PreInscriptions.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_PreInscriptions",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Preinscrição",
             "ItemsName"     => "Preinscrições",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Preinscription",
             "ItemsName_UK"  => "Preinscriptions",
             "ItemsNamer_UK" => "Name",
         ),

         
         "Criterias" => array
          (
             "SqlAccessor" => "CriteriasObj",
             "SqlObject" => "CriteriasObject",
             "SqlClass" => "Criterias",
             "SqlFile" => "Criterias.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Criterias",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Critério",
             "ItemsName"     => "Critérios",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Criteria",
             "ItemsName_UK"  => "Criterias",
             "ItemsNamer_UK" => "Name",
         ),
         "Assessors" => array
          (
             "SqlAccessor" => "AssessorsObj",
             "SqlObject" => "AssessorsObject",
             "SqlClass" => "Assessors",
             "SqlFile" => "Assessors.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Assessors",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Avaliador",
             "ItemsName"     => "Avaliadores",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Assessor",
             "ItemsName_UK"  => "Assessors",
             "ItemsNamer_UK" => "Name",
         ),
         "Assessments" => array
          (
             "SqlAccessor" => "AssessmentsObj",
             "SqlObject" => "AssessmentsObject",
             "SqlClass" => "Assessments",
             "SqlFile" => "Assessments.php",
             "SqlHref" => TRUE,
             "SqlTable" => "#Unit__#Event_Assessments",
             "SqlFilter" => "#Name",
             "SqlDerivedData" => array("Name"),

             "ItemName"      => "Avaliador",
             "ItemsName"     => "Avaliadores",
             "ItemsNamer"    => "Name",

             "ItemName_UK"   => "Assessor",
             "ItemsName_UK"  => "Assessments",
             "ItemsNamer_UK" => "Name",
         ),
       ),
       "PermissionVars" => array
       (
       ),
    );
?>