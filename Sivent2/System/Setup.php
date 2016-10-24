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
          "MailTypes",
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
          "Presences",
       ),
       "ModuleDependencies" => array
       (
          "Logs" => array(),
          "Units" => array("Friends","MailTypes"),
          "MailTypes" => array("Units"),
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
          "Schedules" => array("Dates","Times","Rooms","Submissions"),
          
          "Speakers" => array("Friends","Submissions"),
          "PreInscriptions" => array("Friends","Inscriptions","Submissions"),
          "Presences" => array("Friends","Schedules"),
       ),

       "SubModulesVars" => array
       (
         "include_file" => "System/Modules.php",
       ),
       "PermissionVars" => array
       (
       ),
    );
