array
(
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
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Collaborators&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado",
      "Title_UK" => "Generate Certificate",
      "Name"     => "Certificado",
      "Name_UK"   => "Certificado",
      
      "Handler"   => "Collaborator_Handle_Certificate_Generate",
      "AccessMethod"  => "CheckCertAccess",

      "Icon"   => "print_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
  ),
   "MailCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Collaborators&Action=MailCert&ID=#ID",
      "Title"    => "Enviar Certificado por Email",
      "Title_UK" => "Send Certificate by Email",
      "Name"     => "Enviar Certificado",
      "Name_UK"   => "Send Certificate",
      
      
      "Handler"   => "Collaborator_Handle_Certificate_Mail_Send",
      "AccessMethod"  => "CheckCertAccess",
      "Target"   => "_blank",

      "Icon"   => "copy_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
   "GenCerts" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Collaborators&Action=GenCerts&Latex=1",

      "Title"    => "Gerar todos os Certificados de Colaboradores",
      "Title_UK" => "Generate All Collaborator Certificates",
      "Name"     => "Certificados dos Colaboradores ",
      "Name_UK"   => "Collaborator Certificates",
       
      "Handler"   => "Collaborator_Handle_Certificates_Generate",

      "Icon"   => "print_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
   "SeeFriend" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Show&ID=#Friend",
      "Title"    => "Cadastro",
      "Title_UK" => "Cadastro do Colaborador",
      "Name"     => "Registration",
      "Name_UK"   => "Collaborator Registration",
      
      "Icon"   => "people_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
     "Collaborations" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Collaborations&Action=Search&Event=".$this->Event("ID"),
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
        "AccessMethod"    => "Event_Collaborations_Has",
      ),
     "Event" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Events&Action=Edit&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Evento",
        "Title_UK" => "Manage Event",
        "Name"     => "Evento",
        "Name_UK"     => "Event",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
      ),
   "FriendTable" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Collaborators&Action=FriendTable&Friend=#Friend",
      "Title"    => "Gerenciar Collaborações do Participante",
      "Title_UK" => "Administer Participants Collaborations",
      "Name"     => "Collaborações do Participante",
      "Name_UK"   => "Participants Collaborations",
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "Event_Collaborations_Has",
      "Handler"    => "Collaborators_Friend_Collaborations_Handle",
   ),
);
