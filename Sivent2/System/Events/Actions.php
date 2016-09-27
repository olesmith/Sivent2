array
(
      "GenCert" => array
      (
         "Href"     => "",
         "HrefArgs" => "?ModuleName=Events&Event=#ID&Action=GenCert&Latex=1",
         "Title"    => "Visualizar Certificado",
         "Title_UK" => "Visualize Certificate",
         "Name"     => "Visualizar",
         "Name_UK"   => "Visualize",
      
         "Handler"   => "Event_Handle_Certificate_Generate",
         "Icon"   => "print_dark.png",

         "Public"   => 0,
         "Person"   => 0,
         "Friend"     => 1,
         "Coordinator" => 1,
         "Admin"    => 1,
         "AccessMethod"    => "CheckEditAccess",
     ),
     "Collaborations" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Collaborations&Action=Search&Event=#ID",
        "Title"    => "Gerenciar Colaborações",
        "Title_UK" => "Manage Collaborations",
        "Name"     => "Colaborações",
        "Name_UK"     => "Collaborations",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Collaborations_May",
      ),
     "Collaborators" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Collaborators&Action=Search&Event=#ID",
        "Title"    => "Gerenciar Colaboradores",
        "Title_UK" => "Manage Collaborators",
        "Name"     => "Colaboradores",
        "Name_UK"     => "Collaborators",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Collaborations_Has",
      ),
     "Submissions" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Search&Event=#ID",
        "Title"    => "Gerenciar Atividades",
        "Title_UK" => "Manage Activities",
        "Name"     => "Atividades",
        "Name_UK"     => "Activities",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Submissions_Has",
      ),
     "Caravans" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Caravans&Action=Search&Event=#ID",
        "Title"    => "Gerenciar Caravanas",
        "Title_UK" => "Manage Caravans",
        "Name"     => "Caravanas",
        "Name_UK"     => "Caravans",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Caravans_Has",
      ),
);
