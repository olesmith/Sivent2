array
(
      'Search' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Add' => array
      (
          "Name"     => "Inscrição Avulsa",
          "Name_ES"     => "Adicionar Inscricion",
          "Name_UK"   => "Add Inscription",
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Copy' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
      ),
      'Show' => array
      (
         "HrefArgs" => "?ModuleName=Inscriptions&Event=".$this->Event("ID")."&Action=Edit&ID=#ID",
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'ShowList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Edit' => array
      (
         "HrefArgs" => "?ModuleName=Inscriptions&Event=".$this->Event("ID")."&Action=Edit&ID=#ID",
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
      'Download' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'Zip' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
      ),
   "Inscribe" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Inscribe&Event=".$this->Event("ID"),
      "Title"    => "Efetuar Inscrição no Processo Seletivo",
      "Title_UK" => "Inscribe to Selection Process",
      "Name"     => "Inscrever-se",
      "Name_UK"   => "Inscribe",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,


      "Singular"   => TRUE,
      "Handler"   => "HandleInscribe",
   ),
   "Inscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Inscription&Event=".$this->Event("ID"),
      "Title"    => "Acessar Inscrição",
      "Title_UK" => "Access Inscription",
      "Name"     => "Inscrição",
      "Name_UK"   => "Inscription",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,


      "Singular"   => TRUE,
      "Handler"   => "HandleInscribe",
      "AccessMethod"   => "MayInscribe",
   ),
   "Receit" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Receit&Latex=1&ID=#ID&Event=".$this->Event("ID"),
      "Title"    => "Gerar Recibo da Inscrição (PDF)",
      "Title_UK" => "Generate Inscription Receit (PDF)",
      "Name"     => "Recibo da Inscrição",
      "Name_UK"   => "Inscription Receit",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 1,
      "Coordinator" => 1,


      "Singular"   => TRUE,
      "Handler"   => "HandleReceit",
      "AccessMethod"   => "CheckEditAccess",
   ),
   "Receits" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Receits&Latex=1&ID=#ID&Event=".$this->Event("ID"),
      "Title"    => "Gerar Recibos (PDF)",
      "Title_UK" => "Generate Receits (PDF)",
      "Name"     => "Recibos",
      "Name_UK"   => "Receits",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"       => 1,
      "Friend"     => 0,
      "Coordinator" => 1,


      "Singular"   => TRUE,
      "Handler"   => "HandleReceits",
      "AccessMethod"   => "CheckEditAccess",
   ),
   "Emails" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Emails",
      "Title"    => "Emails",
      "Title_UK" => "Emails",
      "ShortName"     => "Emails",
      "ShortName_UK"   => "Emails",
      "Name"     => "Emails",
      "Name_UK"   => "Emails",
      "Handler"   => "HandleEmails",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Admin"    => 1,
  ),
   "Zips" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Zips&ID=#ID",
      "Title"    => "Zipar",
      "Title_UK" => "Zip",
      "ShortName"     => "Zipar",
      "ShortName_UK"   => "Zip",
      "Name"     => "Zipar Arquivos",
      "Name_UK"   => "Zip Files",
      
      "Handler"   => "MyMod_Handle_Zip",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"   => TRUE,
      "NoHeads"   => 1,
      "NoInterfaceMenu"   => 1,
  ),
);
