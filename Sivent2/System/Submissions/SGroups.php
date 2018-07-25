array
(
   "Basic" => array
   (
      "Name" => "Básicos",
      "Name_ES" => "Básicos",
      "Name_UK" => "Basic",
      "Data" => array
      (
         "Status",
         //"Friend","Name",
         "Title",
         "Type","Area","Level","Certificate","Certificate_TimeLoad","Result",
         "PreInscriptions","Vacancies",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
    "Info" => array
    (
       "Name" => "Resumo",
       "Name_ES" => "Resumo",
       "Name_UK" => "Summary",
       "Data" => array
       (
           "Keywords","Summary","Contents","File","Proceedings",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Neccessities" => array
    (
       "Name" => "Necessidades",
       "Name_ES" => "Necessidades",
       "Name_UK" => "Neccessities",
       "Data" => array
       (
           "Need_Projector","Need_Computer","Need_Other",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
    "Authors" => array
    (
       "Name" => "Autores",
       "Name_ES" => "Autores",
       "Name_UK" => "Authors",
       "Data" => array("Author"),
       "AuthorData" => array("Author"),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Submission_Authors_SGroup_Gen",
       "Single" => TRUE,
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "Certificate","Certificate_TimeLoad",
        ),
       
       "Admin" => 1,
       "Person" => 0,
       "Public" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
    ),
);
