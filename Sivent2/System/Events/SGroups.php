array
(
   "Basic" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Name","Title","Place",
         "EventStart","EventEnd",
         "Date","AnnouncementLink","Announcement"
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => TRUE,
    ),
    "Collaborations" => array
    (
       "Name" => "Colaborações",
       "Name_UK" => "Collaborations",
       "Data" => array
       (
          "Collaborations","Collaborations_Inscriptions","Collaborations_StartDate","Collaborations_EndDate",
       ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Collaborations_Table",
    ),
    "Caravans" => array
    (
       "Name" => "Inscrição de Caravanas",
       "Name_UK" => "Caravans Inscription",
       "Data" => array
       (
          "Caravans","Caravans_StartDate","Caravans_EndDate","Caravans_Min","Caravans_Max"
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Caravans_Table",
    ),
    "Submissions" => array
    (
       "Name" => "Submissões de Trabalhos",
       "Name_UK" => "Submissions",
       "Data" => array
       (
          "Submissions","Submissions_Inscriptions","Submissions_StartDate","Submissions_EndDate","Submissions_Public"
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Submissions_Table",
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
        "Certificates","Certificates_Published","Certificates_CH","Certificates_Watermark",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Certificate_Table",
    ),
    "Certificate_Signatures" => array
    (
       "Name" => "Certificados, Assinaturas",
       "Name_UK" => "Certificates, Signatures",
       "Data" => array
       (
          "Certificates_Signature_1","Certificates_Signature_1_Text1","Certificates_Signature_1_Text2",
          "Certificates_Signature_2","Certificates_Signature_2_Text1","Certificates_Signature_2_Text2",
          "Certificates_Signature_3","Certificates_Signature_3_Text1","Certificates_Signature_3_Text2",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Certificates_Has",
    ),
    "Certificate_Latex" => array
    (
       "Name" => "Certificados, Participante",
       "Name_UK" => "Certificates, Participant",
       "Data" => array
       (
          "Certificates_Latex","Certificates_Latex_UK",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Certificates_Has",
    ),
    "Submissions_Latex" => array
    (
       "Name" => "Submissões, Certificados",
       "Name_UK" => "Submissions, Certificates",
       "Data" => array
       (
          "Certificates_Submissions_TimeLoad",
          "Certificates_Submissions_Latex",
          "Certificates_Submissions_Latex_UK",
          
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Submissions_Has",
    ),
    "Collaborators_Latex" => array
    (
       "Name" => "Colaborações, Certificados",
       "Name_UK" => "Collaborators, Certificates",
       "Data" => array
       (
          "Certificates_Collaborations_Latex",
          "Certificates_Collaborations_Latex_UK",         
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Collaborators_Has",
    ),
);
