array
(
   "Basic" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Status","Visible","Initials","Name","Title","Site",
         "Place","Place_Address","Place_Site",
         "EventStart","EventEnd",
         "Date","AnnouncementLink","Announcement",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => FALSE,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
    "Components" => array
    (
       "Name" => "Componentes",
       "Name_UK" => "Components",
       "Data" => array
       (
          "Payments","Selection",
          "Certificates","Certificates_Published","Collaborations","Caravans",
          "Submissions","Assessments","Schedule_Public","Info",
       ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "EditAccessMethod" => "Current_User_Event_May_Edit",
       //"GenTableMethod" => "Event_Collaborations_Table",
    ),
    "Payments" => array
    (
       "Name" => "Pagamentos",
       "Name_UK" => "Payments",
       "Data" => array
       (
          "Payments",
          "Payments_Info","Payments_URL",
          "Payments_Type","Payments_Institution",
          "Payments_Name","Payments_Agency","Payments_Operation","Payments_Account","Payments_Variation",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Payments_Has",
       "SubAction" => "Payments",
       "EditAccessMethod" => "Current_User_Event_Payments_May_Edit",
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
       "SubAction" => "Collaborations",
       "EditAccessMethod" => "Current_User_Event_Collaborations_May_Edit",
    ),
    "Caravans" => array
    (
       "Name" => "Inscrição de Caravanas",
       "Name_UK" => "Caravans Inscription",
       "Data" => array
       (
        "Caravans","Caravans_StartDate","Caravans_EndDate",
        "Caravans_Min","Caravans_Max",
        "Caravans_Coord_Timeload","Caravans_Timeload",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Caravans_Table_Html",
       "AccessMethod" => "Event_Caravans_Has",
       "SubAction" => "Caravans",
       "EditAccessMethod" => "Current_User_Event_Caravans_May_Edit",
    ),
    "Submissions" => array
    (
       "Name" => "Submissão de Atividades",
       "Name_UK" => "Submission of Activities",
       "Data" => array
       (
          "Submissions","Submissions_Public","Submissions_Inscriptions",
          "Submissions_NAuthors",
          "Submissions_StartDate","Submissions_EndDate",
          "Certificates_Submissions_TimeLoad",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Submissions_Table",
       "AccessMethod" => "Event_Submissions_Has",
       "SubAction" => "Submissions",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
    ),
    "PreInscriptions" => array
    (
       "Name" => "Preinscrições",
       "Name_UK" => "PreInscriptions",
       "Data" => array
       (
          "PreInscriptions_StartDate","PreInscriptions_EndDate","PreInscriptions_MustHavePaid"
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       //"GenTableMethod" => "Event_Submissions_Table",
       "AccessMethod" => "Event_PreInscriptions_Has",
       "SubAction" => "PreInscriptions",
       "EditAccessMethod" => "Current_User_Event_PreInscriptions_May_Edit",
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "Certificates","Certificates_Published","TimeLoad","Certificates_Watermark",
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
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
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
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
    ),
    "Certificate_Latex" => array
    (
       "Name" => "Certificados, Participante",
       "Name_UK" => "Certificates, Participant",
       "Data" => array
       (
           "Certificates_Latex",//"Certificates_Latex_UK"
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Certificates_Has",
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
    ),
    "Submissions_Latex" => array
    (
       "Name" => "Atividades, Certificados",
       "Name_UK" => "Activities, Certificates",
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
       "SubAction" => "Submissions",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
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
       "SubAction" => "Collaborations",
       "EditAccessMethod" => "Current_User_Event_Collaborations_May_Edit",
   ),
    "Caravaneers_Latex" => array
    (
       "Name" => "Caravaneiros, Certificados",
       "Name_UK" => "Caravaneers, Certificates",
       "Data" => array
       (
          "Certificates_Caravans_Latex",
          "Certificates_Caravaneers_Latex",         
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Caravans_Has","Event_Certificates_Has"),
       "SubAction" => "Caravans",
       "EditAccessMethod" => "Current_User_Event_Caravans_May_Edit",
    ),
    "Assessments" => array
    (
       "Name" => "Avaliação das Atividades",
       "Name_UK" => "Activities Assessment",
       "Data" => array
       (
          "Assessments","Assessments_StartDate","Assessments_EndDate",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "SubAction" => "Assessments",
       "AccessMethod" => "Event_Assessments_Has",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
    ),
);
