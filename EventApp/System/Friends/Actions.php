array
(
   "Clean" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Clean",
      "Title"    => "Limpar Cadastros",
      "Title_UK" => "Clean Registrations",
      "Name"     => "Limpar",
      "Name_UK"     => "Clean",
      "Handler"   => "HandleCleanFriends",
      'Public' => 0,
      'Person' => 0,
      "Admin" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
   ),
   "Logon" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=&Action=Logon",
      "Title"    => "Efetuar Login",
      "Title_UK" => "Logon",
      "Name"     => "Efetuar Login",
      "Name_UK"  => "Logon",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 0,
      "Handler"   => "HandleNewRegistration",
   ),
   "Recover" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Recover",
      "Title"    => "Recuperar Senha",
      "Title_UK" => "Recover Password",
      "Name"     => "Recuperar Senha",
      "Name_UK"  => "Recover Password",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 0,
      "Handler"   => "HandleNewRegistration",
   ),
    "Inscribe" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Announcement=AID&Action=Inscription",
      "Title"    => "Inscriver-me",
      "Title_UK" => "Inscribe to",
      "Name"     => "Inscrever-me",
      "Name_UK"   => "Inscribe",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Admin"    => 1,
      "Handler"   => "HandleFriend",
   ),
   "Inscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Announcement=AID&Action=Inscription",
      "Title"    => "Minha Inscrição",
      "Title_UK" => "My Inscription",
      "Name"     => "Inscrição",
      "Name_UK"   => "Inscription",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Admin"    => 1,
      "Handler"   => "HandleFriend",
   ),
   "Receit" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Announcement=#Announcement&Action=Receit&Latex=1",
      "Title"    => "Gerar Recibo da Inscrição",
      "Title_UK" => "Generate Inscription Receit",
      "Name"     => "Gerar Recibo",
      "Name_UK"   => "Generate Receit",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,

      "Admin"    => 1,
      "Handler"   => "HandleFriend",
      "NoHeads"   => TRUE,
      "NoInterfaceMenu"   => TRUE,
   ),
   "AddInscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Add&Friend=#ID",
      "Title"    => "Inscrever",
      "Title_UK" => "Inscribe",
      "Name"     => "Inscrever Cadastro",
      "Name_UK"   => "Inscribe Registration",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,

      "Admin"    => 1,
      "Handler"   => "",
   ),
   "Emails" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Emails",
      "Title"    => "Emails",
      "Title_UK" => "Emails",
      "ShortName"     => "Emails",
      "ShortName_UK"   => "Emails",
      "Name"     => "Emails",
      "Name_UK"   => "Emails",
      "Handler"   => "HandleEmails",
      "Icon"   => "copy_light.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Admin"    => 1,
  ),

         
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
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,

       ),
      'Show' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,

         "AccessMethod"  => "CheckShowAccess",
      ),
      'ShowList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,

         "AccessMethod"  => "CheckShowAccess",
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckEditAccess",
      ),
      'EditList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,

         "AccessMethod"  => "CheckEditAccess",
      ),
      'Delete' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
      ),
 );
