array
(
   "Basic" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Name","Title","Name_UK","Title_UK",
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

       "Person" => 1,
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

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
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

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Certificates_Has",
    ),
    "Certificate_Latex" => array
    (
       "Name" => "Certificados, Texto",
       "Name_UK" => "Certificates, Text",
       "Data" => array
       (
          "Certificates_Latex",
        ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Certificates_Has",
    ),
);
