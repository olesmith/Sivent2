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
          
          "Lots",
          "Types",
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
          
          "Lots" => array("Events"),
          "Types" => array("Events"),
       ),

       "SubModulesVars" => array
       (
         "include_file" => "System/Modules.php",
       ),
       "Module2Groups" => array
       (
           "Events" => "Configuration",
           "Datas" => "Configuration",
           "DataGroups" => "Configuration",
           
           "Inscriptions" => "Inscriptions",
           "Lots" => "Inscriptions",
           "Types" => "Inscriptions",
           
           "Caravans" => "Caravans",
           "Caravaneers" => "Caravans",
           
           "Collaborations" => "Collaborations",
           "Collaborators" => "Collaborations",
           
           "Submissions" => "Submissions",
           "Areas" => "Submissions",
           
           "Assessments" => "Submissions",
           "Assessors" => "Submissions",
           "Criterias" => "Submissions",

           "Schedules" => "Grade",
           "Rooms" => "Grade",
           "Places" => "Grade",
           "Times" => "Grade",
           "Dates" => "Grade",
           "Speakers" => "Grade",

           
           //"PreInscriptions" => "PreInscriptions",
           //"Presences" => "Presences",
           //"Statistics" => "Statistics",
       ),
       "ModuleGroups2Actions" => array
       (
           //Actions should be defined in System/Actions.php (or elsewhere)
           "Configuration" => array
           (
               "Name" => "Configuração",
               "Title" => "Configuração do Evento",
               "Name_UK" => "",
               "Title_UK" => "",
               "Actions" => array
               (
                   "Sponsors",
                   "Event_Configuration","Datas","DataGroups",
               ),
           ),
           "Inscriptions" => array
           (
               "Name" => "Inscrições",
               "Title" => "Inscrições, Certificados e Pagamentos",
               "Name_UK" => "Inscriptions",
               "Title_UK" => "Inscriptions, Certificates and Payments",
               "Actions" => array("Inscriptions","Types","Lots","Certificates","Payments",),
           ),
           "Collaborations" => array
           (
               "Name" => "Colaborações",
               "Title" => "Gerenciar Colaborações e Colaboradores",
               "Name_UK" => "Collaborations",
               "Title_UK" => "Manage Collaborations and Collaborators",
               "Actions" => array("Collaborations","Collaborators","Collaborators_Certificates",),
           ),
           "Caravans" => array
           (
               "Name" => "Caravans",
               "Title" => "Gerenciar Caravans",
               "Name_UK" => "Caravans",
               "Title_UK" => "Manage Caravans",
               "Actions" => array("Caravans","Caravaneers","Caravaneers_Certificates",),
           ),
           "Submissions" => array
           (
               "Name" => "Atividades",
               "Title" => "Atividades e Avaliações",
               "Name_UK" => "Activities",
               "Title_UK" => "Activities and Assessments",
               "Actions" => array
               (
                   "Submissions",
                   "Areas",
                   "Criterias","Assessments","Assessors",
                   "Submissions_Certificates","Speakers",
               ),
           ),
           "Grade" => array
           (
               "Name" => "Grade",
               "Title" => "Gerenciar Grade",
               "Name_UK" => "Schedule",
               "Title_UK" => "Schedule Activities",
               "Actions" => array
               (
                   "Schedule","Submissions",
                   "Dates","Times",
                   "Places","Rooms",
                   "ScheduleEdit","Speakers",
               ),
           ),
       ),
    );
