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
         "Coordinator" => 1,
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
);
