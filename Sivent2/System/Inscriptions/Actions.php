array
(
   "Inscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Inscription&Friend=#Friend#1",
      "Title"    => "Inscrição",
      "Title_UK" => "Inscription",
      "Name"     => "Inscrição",
      "Name_UK"   => "Inscrição",
      
      //"Handler"   => "Inscription_Collaborations_Inscription_Handle",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckEditAccess",
  ),
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Event=#Event&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado (PDF)",
      "Title_UK" => "Generate Certificate (PDF)",
      "Name"     => "Certificado",
      "Name_UK"   => "Certificate",
      
      "Handler"   => "Inscription_Handle_Certificate_Generate",
      "Icon"   => "print_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
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
      "AccessMethod"    => "CheckCertificateAccess",
  ),
);
