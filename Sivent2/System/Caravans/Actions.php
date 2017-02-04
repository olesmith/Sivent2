array
(
      'Export' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowListAccess",
      ),
      'Search' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowListAccess",
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditListAccess",
      ),
      'Copy' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditListAccess",
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
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
         "AccessMethod" => "CheckEditListAccess",
      ),
      'Delete' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDeleteAccess",
      ),
   "Caravaneers_Search" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravaneers&Action=Search",
      "Title"    => "Participantes de Caravanas",
      "Title_UK" => "Caravan Participants",
      "Name"     => "Caravaneiros",
      "Name_UK"   => "Caravaneers",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => TRUE,
      "AccessMethod"    => "CheckShowAccess",
  ),
   "Caravaneers" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravans&Action=Caravaneers&ID=#ID",
      "Title"    => "Participantes da Caravana",
      "Title_UK" => "Caravan Participants",
      "Name"     => "Caravaneiros",
      "Name_UK"   => "Caravaneers",
      
      "Handler"   => "Caravan_Caravaneers_Handle",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => TRUE,
      "AccessMethod"    => "CheckEditAccess",
  ),
    "Emails" => array
    (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Caravans&Action=Emails",
        "Title"    => "Emails",
        "Title_UK" => "Emails",
        "ShortName"     => "Emails",
        "ShortName_UK"   => "Emails",
        "Name"     => "Emails",
        "Name_UK"   => "Emails",
        "Handler"   => "HandleEmails",

        'Public' => 0,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "AccessMethod" => "CheckEditListAccess",
    ),
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravans&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado",
      "Title_UK" => "Generate Certificate",
      "Name"     => "Certificado(s)",
      "Name_UK"   => "Certificado(s)",
      
      "Handler"   => "Caravan_Handle_Certificate_Generate",
      "AccessMethod"  => "CheckCertAccess",

      "Icon"   => "print_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
   "GenCerts" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravans&Action=GenCerts&Latex=1",

      "Title"    => "Gerar Certificados dos Caravanas",
      "Title_UK" => "Generate Caravan Certificates",
      "Name"     => "Certificados dos  Caravanas",
      "Name_UK"   => "Caravan Certificates",
       
      "Handler"   => "Caravans_Handle_Certificates_Generate",

      "Icon"   => "print_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
);
