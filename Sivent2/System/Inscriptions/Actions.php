array
(
      'Import' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditListAccess",
         "Handler" => "MyMod_Handle_Import",
      ),
      'Export' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowListAccess",
      ),
      'Emails' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditListAccess",
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
      'Search' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowListAccess",
      ),
      'EditList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditListAccess",
      ),
   "Friend" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Edit&ID=#Friend#1",
      "Title"    => "Cadastro",
      "Title_UK" => "Registration",
      "Name"     => "Cadastro",
      "Name_UK"   => "Registration",
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckEditAccess",
      "Singular"    => TRUE,
  ),
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Event=#Event&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado(s) (PDF)",
      "Title_UK" => "Generate Certificate(s) (PDF)",
      "Name"     => "Certificado(s)",
      "Name_UK"   => "Certificate(s)",
      
      "Handler"   => "Inscription_Handle_Certificate_Generate",
      "Icon"   => "print_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => True,
      "AccessMethod"    => "CheckCertificateAccess",
   ),
   "MailCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Event=#Event&Action=MailCert&ID=#ID",
      "Title"    => "Enviar Certificado por Email",
      "Title_UK" => "Send Certificate by Email",
      "Name"     => "Enviar Certificado",
      "Name_UK"   => "Send Certificate",
      
      "Handler"   => "Inscription_Handle_Certificate_Mail_Send",
      "Icon"   => "copy_dark.png",
      "Target"   => "_blank",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckCertificateAccess",
   ),
   "GenCerts" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=GenCerts&Latex=1",
      "Title"    => "Gerar Certificados de todos os Participantes",
      "Title_UK" => "Generate Certificates for all Participants",
      "Name"     => "Certificados, todos os Participantes",
      "Name_UK"   => "Certificates, all Participants",
      
      "Handler"   => "Inscription_Handle_Certificates_Generate",
      "Icon"   => "print_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckCertificatesAccess",
  ),
   "FriendCollaborations" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Collaborators&Action=FriendTable&Friend=#Friend",
      "Title"    => "Gerenciar Collaborações do Participante",
      "Title_UK" => "Administer Participants Collaborations",
      "Name"     => "Collaborações do Participante",
      "Name_UK"   => "Participant's Collaborations",
      
      //"Handler"   => "Inscription_Handle_Certificates_Generate",
      //"Icon"   => "print_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => 1,
      "AccessMethod"    => "Event_Collaborations_Has",
  ),
   "FriendSubmissions" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Submissions&Action=FriendTable&Friend=#Friend",
      "Title"    => "Gerenciar Atividades do Participante",
      "Title_UK" => "Administer Participant Activities",
      "Name"     => "Atividades do Participante",
      "Name_UK"   => "Participant Activities",
      
      //"Handler"   => "Inscription_Handle_Certificates_Generate",
      //"Icon"   => "print_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => 1,
      "AccessMethod"    => "Event_Submissions_Has",
  ),
   "FriendCaravan" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravans&Action=Caravaneers&ID=#ID",
      "Title"    => "Gerenciar Caravana do Participante",
      "Title_UK" => "Administer Participant's Caravan",
      "Name"     => "Caravana do Participante",
      "Name_UK"   => "Participant's Caravan",
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => 1,
      "AccessMethod"    => "Event_Caravans_Has",
  ),
);
