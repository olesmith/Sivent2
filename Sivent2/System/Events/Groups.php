array
(
   "Basic" => array
   (
      "Name" => "Básicos",
      "Name_UK" => "Basic",
      "Data" => array
      (
         "No",
         "Edit",
         "Delete",
         //"Datas","GroupDatas",
         "Date","Title","Site","Place","Place_Address","Place_Site",
         "EventStart","EventEnd",
         "Visible","Status","Inscriptions_Public","Payments",
         "Inscribe","Inscription",
         "NoOfInscriptionsCell"
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Short" => array
   (
      "Name" => "Breve",
      "Name_UK" => "Short",
      "Data" => array
      (
         "No",
         "Details",
         "Date","Event_Title_Show","Site",
         "Event_Period_Show",
         "Event_Place_Show",
         "Event_Inscriptions_Period_Show",
         "Status","Payments",
         "Event_Inscription_Action",
         "NoOfInscriptionsCell"
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Inscriptions" => array
   (
      "Name" => "Inscrições",
      "Name_UK" => "Inscriptions",
      "Data" => array
      (
         "No","Edit","Delete",
         "Inscription",
         "Title",
         "Event_Date_Span_Cell",
         "Event_Inscriptions_Date_Span_Cell",
         "Events_Status_Cell",
         "EditDate",
         "Statistics",
         "Inscription",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Certificates","TimeLoad","Certificates_Published","Certificates_Watermark"
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Collaborations" => array
    (
       "Name" => "Colaboraçoes",
       "Name_UK" => "Collaborators",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Collaborations",
          "Collaborations_Inscriptions","Collaborations_StartDate","Collaborations_EndDate",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Caravans" => array
    (
       "Name" => "Caravanas",
       "Name_UK" => "Caravans",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Caravans","Caravans_StartDate","Caravans_EndDate",
          "Caravans_Min","Caravans_Max",
          "Caravans_Public","Caravans_Coord_Timeload","Caravans_Timeload",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Submissions" => array
    (
       "Name" => "Atividades",
       "Name_UK" => "Activities",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Submissions","Submissions_Public","Submissions_Inscriptions",
          "Submissions_NAuthors",
          "Submissions_StartDate","Submissions_EndDate",
          "Proceedings",
          "Certificate_Submission_TimeLoad"
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Assessments" => array
    (
       "Name" => "Avaliação das Atividades",
       "Name_UK" => "Activities Assessment",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Assessments","Assessments_StartDate","Assessments_EndDate",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Payments" => array
    (
       "Name" => "Pagamentos",
       "Name_UK" => "Payments",
       "Data" => array
       (
          "No","Edit","Delete",
          "Name",//"Friend",
          "Payment",
          "Payments_Type","Payments_Institution",
          "Payments_Name","Payments_Agency","Payments_Operation","Payments_Account","Payments_Variation",
          "Payments_Info","Payments_URL",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
);
