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
         "Coordinator" => 0,
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'Print' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
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
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'Unlink' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
      ),
      'Zip' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
      ),
   "Details" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=&Action=",
      "Title"    => "Detalhes",
      "Title_UK" => "Details",
      "Name"     => "Detalhes",
      "Name_UK"   => "Details",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Icon"     => "fas fa-search-plus",

      "Singular"   => TRUE,
      "AccessMethod"   => "CheckShowAccess",
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

      "Icon"     => "fab fa-wpforms",

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

      "Icon"     => "fab fa-wpforms",

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

      "Icon"     => "fas fa-comments",

      "Singular"   => FALSE,
      "Handler"   => "MyEvents_Handle_Open",
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
      "Access_No_Warnings"   => True,
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
      "Icon"   => "fas fa-users",
   ),
   "Inscriptions_Add" => array
   (
      "Href"     => "",
      "HrefArgs" => "?Event=#ID&ModuleName=Inscriptions&Action=Add",
      "Title"    => "Inscrição Avulsa",
      "Title_UK" => "Add Inscriptions",
      "Name"     => "Inscrição Avulsa",
      "Name_UK"   => "Add Inscriptions",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 0,
      "Coordinator" => 1,

      "Singular"   => TRUE,
      "Handler"   => "",
      "Icon"   => "fas fa-user-plus",
   ),
   "Conf" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Events&Action=Conf",
      
      "Name"     => "Configurações",
      "Name_UK"   => "Configurations",
      "Title"    => "Configuraçõesdo Evento",
      "Title_UK" => "Event Configurations",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"       => 2,
      "Friend"     => 1,
      "Coordinator" => 2,

      "Icon"     => "fas fa-screwdriver",

      "Singular"   => FALSE,
      "Handler"   => "MyEvents_Handle_Conf",
   ),
);
