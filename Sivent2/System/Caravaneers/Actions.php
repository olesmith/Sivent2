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
         "Friend"     => 0,
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
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDeleteAccess",
      ),
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravaneers&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado",
      "Title_UK" => "Generate Certificate",
      "Name"     => "Certificado",
      "Name_UK"   => "Certificado",
      
      "Handler"   => "Caravaneer_Handle_Certificate_Generate",
      "AccessMethod"  => "CheckCertAccess",

      "Icon"   => "fas fa-certificate",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
     "Caravans" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Caravans&Action=Search&Event=".$this->Event("ID"),
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
        //'AccessMethod'    => "Current_User_Event_Caravans_May_Edit",
      ),
   "GenCerts" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravaneers&Action=GenCerts&Latex=1",

      "Title"    => "Gerar Certificados dos Caravaneiros",
      "Title_UK" => "Generate Caravaneer Certificates",
      "Name"     => "Certificados dos  Caravaneiros",
      "Name_UK"   => "Caravaneer Certificates",
       
      "Handler"   => "Caravaneers_Handle_Certificates_Generate",

      "Icon"   => "fas fa-file-pdf",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
    "Import" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Importar #ItemsName de outro Evento",
        "Title_UK" => "Import #ItemsName_UK from other Event",
        "Title_ES"    => "Importar #ItemsName_ES de outro Evento",
        "Name"     => "Importar",
        "Name_UK"  => "Import",
        "Name_ES"     => "Importar",
        //"Icon"     => "rubik.png",
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Coordinator"   => 1,
        "Handler"   => "EventMod_Import_Events_Handle",
        "Singular"   => FALSE,
    ),
);
