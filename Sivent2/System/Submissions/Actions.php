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
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckAddAccess",
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'Edit' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
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
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDeleteAccess",
      ),
      'Download' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDownloadAccess",
      ),
   "Submissions" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Inscription&Type=Submission&Friend=#Friend#1",
      "Title"    => "Atividades",
      "Title_UK" => "Activities",
      "Name"     => "Atividade",
      "Name_UK"   => "Activity",
      
      //"Handler"   => "Inscription_Collaborations_Inscription_Handle",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
  ),
   "GenCert" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Submissions&Action=GenCert&Latex=1&ID=#ID",
      "Title"    => "Gerar Certificado",
      "Title_UK" => "Generate Certificate",
      "Name"     => "Certificado",
      "Name_UK"   => "Certificado",
      
      "Handler"   => "Submission_Handle_Certificate_Generate",
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
      "HrefArgs" => "?ModuleName=Submissions&Action=MailCert&ID=#ID",
      "Title"    => "Enviar Certificado por Email",
      "Title_UK" => "Send Certificate by Email",
      "Name"     => "Enviar Certificado",
      "Name_UK"   => "Send Certificate",
      
      
      "Handler"   => "Submission_Handle_Certificate_Mail_Send",
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
      "HrefArgs" => "?ModuleName=Submissions&Action=GenCerts&Latex=1",
      "Title"    => "Gerar todos os Certificados de Palestrantes",
      "Title_UK" => "Generate All Speaker Certificates",
      "Name"     => "Certificados de Palestrantes",
      "Name_UK"   => "Speaker Certificates",
      
      "Handler"   => "Submission_Handle_Certificates_Generate",

      "Icon"   => "print_dark.png",
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
   ),
   "FriendTable" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Submissions&Action=FriendTable&Friend=#Friend",
      "Title"    => "Gerenciar Atividades do Participante",
      "Title_UK" => "Administer Participant Activities",
      "Name"     => "Atividades do Participante",
      "Name_UK"   => "Participant Activities",
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "Event_Submissions_Has",
      "Handler"    => "Collaborators_Friend_Submissions_Handle",
   ),
     "Details" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Details&Event=#Event&ID=#ID",
        "Title"    => "Detalhes da Submissão",
        "Title_UK" => "Submission Details",
        "Name"     => "Detalhes",
        "Name_UK"     => "Details",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 1,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "Singular"      => TRUE,
        "Handler"    => "Submissions_Handle_Submission",
      ),
     "Assessments" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Assessments&Event=#Event&ID=#ID",

        "Name"     => "Avaliadores e Avaliações",
        "Name_UK"     => "Assessors and Assessments",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 1,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "Handler"    => "Submissions_Handle_Assessments",
        "AccessMethod"    => "Event_Assessments_Has",
        "Singular"      => TRUE,
        "Icon"      => "absences_light.png",
      ),
);
