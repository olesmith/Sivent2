array
(
      'Search' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
      ),
      'Show' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         //"AccessMethod" => "CheckShowAccess",
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         //"AccessMethod" => "CheckEditAccess",
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
         //"AccessMethod"  => "CheckDeleteAccess",
      ),
   "Validate" => array
   (
      "HrefArgs" => "?ModuleName=Certificates&Action=Validate",
      
      "Title"    => "Validar Certificados Emitidos por Sivent2",
      "Title_UK" => "Validate Certificates Emitted by Sivent2",
      "Name"     => "Validar Certificados",
      "Name_UK"   => "Validate Certificates",
      
      "Public"   => 1,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Admin"    => 1,
      
      "Handler"    => "Certificates_Validate",
      /* "NameMethod"    => "Inscriptions_Collaborations_Show_Name", */
      /* "TitleMethod"    => "Inscriptions_Collaborations_Show_Title", */
      /* "AccessMethod"    => "Inscriptions_Collaborations_Show_Should", */
  ),
   "Generate" => array
   (
      "HrefArgs" => "?ModuleName=Certificates&Action=Generate&Event=#Event&Latex=1&Code=#Code",
      
      "Title"    => "Gerar Certificado",
      "Title_UK" => "Generate Certificate2",
      "Name"     => "Gerar",
      "Name_UK"   => "Generate",
      
      "Public"   => 1,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Icon"    => "print_dark.png",
      
      "AccessMethod"    => "CheckGenerateAccess",
      "Handler"    => "Certificates_Generate_Handle_ByCode",
      /* "NameMethod"    => "Inscriptions_Collaborations_Show_Name", */
      /* "TitleMethod"    => "Inscriptions_Collaborations_Show_Title", */
      /* "AccessMethod"    => "Inscriptions_Collaborations_Show_Should", */
  ),
);
