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
      "ShortName"     => "Certificado",
      "ShortName_UK"   => "Certificate",
      "Name"     => "Certificado",
      "Name_UK"   => "Certificate",
      
      "Handler"   => "Inscription_Handle_Certificate_Generate",
      "Icon"   => "copy_dark.png",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckCertificateAccess",
  ),
  /*  "Collaborations" => array */
  /*  ( */
  /*     "Href"     => "", */
  /*     "HrefArgs" => "?ModuleName=Friends&Action=Collaborations", */
  /*     "Title"    => "Colaborações", */
  /*     "Title_UK" => "Collaborations", */
  /*     "ShortName"     => "Colaborações", */
  /*     "ShortName_UK"   => "Collaborations", */
  /*     "Name"     => "Colaborações", */
  /*     "Name_UK"   => "Collaborations", */
      
  /*     //"Handler"   => "Handle_Inscription_Collaborations", */

  /*     "Public"   => 0, */
  /*     "Person"   => 0, */
  /*     "Friend"     => 0, */
  /*     "Coordinator" => 1, */
  /*     "Admin"    => 1, */
  /* ), */
);
