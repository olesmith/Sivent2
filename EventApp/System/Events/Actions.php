array
(
      'Search' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         //"AccessMethod" => "CheckShowAccess",
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
      ),
      'EditList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
      ),
      'Delete' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
         "AccessMethod"  => "CheckDeleteAccess",
      ),
      'Download' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
      ),
   "Datas" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Events&Action=Datas",
      "Title"    => "Dados do Questionário",
      "Title_UK" => "Questionary Data",
      "Name"     => "Questionário",
      "Name_UK"   => "Questionary",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 0,
      "Coordinator" => 1,

      "Icon"     => "history_light.png",

      "Singular"   => TRUE,
      "Handler"   => "HandleEventDatas",
      "AccessMethod"   => "CheckEditAccess",
   ),
   "GroupDatas" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Events&Action=GroupDatas",
      "Title"    => "Grupos, Questionário",
      "Title_UK" => "Groups, Questionary",
      "Name"     => "Grupos, Questionário",
      "Name_UK"   => "Groups, Questionary",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 0,
      "Coordinator" => 1,

      "Icon"     => "absences_light.png",

      "Singular"   => TRUE,
      "Handler"   => "HandleEventDataGroups",
      "AccessMethod"   => "CheckEditAccess",
   ),


   "OpenEvents" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Events&Action=OpenEvents",
      "Title"    => "Inscrições Abertas",
      "Title_UK" => "Open Inscriptions",
      "Name"     => "Inscrições Abertas",
      "Name_UK"   => "Open Inscriptions",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"       => 2,
      "Friend"     => 1,
      "Coordinator" => 2,

      "Icon"     => "history_light.png",

      "Singular"   => FALSE,
      "Handler"   => "HandleOpenEvents",
   ),
   "Inscribe" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Inscriptions&Action=Inscribe",
      "Title"    => "Efetuar Inscrição no Evento",
      "Title_UK" => "",
      "Name"     => "Inscrever-se",
      "Name_UK"   => "Register",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Singular"   => TRUE,
      "AccessMethod"   => "MayInscribe",
      "Handler"   => "",
   ),
   "Inscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Inscriptions&Action=Inscription",
      "Title"    => "Acessar Inscrição",
      "Title_UK" => "Access Inscription",
      "Name"     => "Acessar Inscrição",
      "Name_UK"   => "Access Inscription",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Singular"   => TRUE,
      "AccessMethod"   => "IsInscribed",
      "Handler"   => "",
   ),
   "Inscriptions" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Inscriptions&Action=Search",
      "Title"    => "Pesuisar Inscrições",
      "Title_UK" => "Search Inscriptions",
      "Name"     => "Inscrições",
      "Name_UK"   => "Inscriptions",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 0,
      "Coordinator" => 1,

      "Singular"   => TRUE,
      "Handler"   => "",
      "Icon"   => "students_light.png",
   ),
);
