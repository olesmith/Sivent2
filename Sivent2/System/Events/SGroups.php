array
(
   "Basic" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Initials","Name","Title","Place","Place_Address","Place_Site",
         "EventStart","EventEnd",
         "Date","AnnouncementLink","Announcement",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => TRUE,
    ),
    "Components" => array
    (
       "Name" => "Componentes",
       "Name_UK" => "Components",
       "Data" => array
       (
          "Payments","Selection","Certificates","Collaborations","Caravans","Submissions","Info",
       ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       //"GenTableMethod" => "Event_Collaborations_Table",
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "Certificates","Certificates_Published","Certificates_CH","Certificates_Watermark",
          "GenCert",
          "Certificates_Latex_Sep_Vertical",
          "Certificates_Latex_Sep_Horisontal",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Certificate_Table",
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
       "AccessMethod" => "Event_Collaborations_Has",
    ),
    "Caravans" => array
    (
       "Name" => "Inscrição de Caravanas",
       "Name_UK" => "Caravans Inscription",
       "Data" => array
       (
        "Caravans","Caravans_StartDate","Caravans_EndDate",
        "Caravans_Min","Caravans_Max",
        "Caravans_Timeload",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Caravans_Table_Html",
       "AccessMethod" => "Event_Caravans_Has",
    ),
    "Submissions" => array
    (
       "Name" => "Submissões de Trabalhos",
       "Name_UK" => "Submissions",
       "Data" => array
       (
        "Submissions","Submissions_Inscriptions","Submissions_StartDate","Submissions_EndDate","Submissions_Public",
        "Certificates_Submissions_TimeLoad",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Submissions_Table",
       "AccessMethod" => "Event_Submissions_Has",
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
          "Certificates_Latex","Certificates_Latex_UK"
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
          "Certificates_Submissions_Latex",
          "Certificates_Submissions_Latex_UK",
          
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Submissions_Has","Event_Certificates_Has"),
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
       "AccessMethod" => array("Event_Collaborations_Has","Event_Certificates_Has"),
    ),
    "Caravaneers_Latex" => array
    (
       "Name" => "Caravaneiros, Certificados",
       "Name_UK" => "Caravaneers, Certificates",
       "Data" => array
       (
          "Certificates_Caravaneers_Latex",
          "Certificates_Caravaneers_Latex_UK",         
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Caravans_Has","Event_Certificates_Has"),
    ),
);
