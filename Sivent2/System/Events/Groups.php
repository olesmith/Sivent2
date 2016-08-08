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
         "Date","Title","Place","Place_Address","Place_Site",
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
   "Inscriptions" => array
   (
      "Name" => "Inscrições",
      "Name_UK" => "Inscriptions",
      "Data" => array
      (
         "No","Edit","Delete",
         "Title",
         "Event_Date_Span","Inscription",
         "StartDate","EndDate","EditDate",
         "InscribeLink",
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
          "Event","Friend",
          "Certificates","Certificates_CH","Certificates_Published","Certificates_Watermark"
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
          "Event","Friend",
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
          "Event","Friend",
          "Caravans","Caravans_StartDate","Caravans_EndDate",
          "Caravans_Min","Caravans_Max",
          "Caravans_Public","Caravans_Timeload",
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
          "Event","Friend",
          "Submissions","Submission_Public",
          "Submissions_Inscriptions","Submissions_StartDate","Submissions_EndDate",
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
          "Event","Friend",
          "Assessments","Assessments_StartDate","Assessments_EndDate",
        ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
);
