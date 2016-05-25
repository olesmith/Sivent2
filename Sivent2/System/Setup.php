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
          
          "Certificates",
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
          "Collaborations" => array("Units","Events"),
          "Collaborators" => array("Collaborations","Inscriptions"),
          "Inscriptions" => array("Datas","GroupDatas"),
          "Caravans" => array("Inscriptions"),
          "Caravaneers" => array("Caravans"),
          "Areas" => array("Events"),
          "Submissions" => array("Inscriptions","Areas"),
          "Certificates" => array("Inscriptions","Caravaneers","Collaborations","Submissions"),
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
             "SqlFilter" => "#Friend: #Name",
             "SqlDerivedData" => array("Friend","Title"),

             "ItemName"      => "Submissão",
             "ItemsName"     => "Submissões",
             "ItemsNamer"    => "Title",

             "ItemName_UK"   => "Submission",
             "ItemsName_UK"  => "Submissions",
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
       ),
       "PermissionVars" => array
       (
       ),
    );
?>