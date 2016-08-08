array
(
   "Basic" => array
   (
      "Name" => "Básicos",
      "Name_UK" => "Basic",
      "Data" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Status",
         "Event","Type","Area","Level",
         "SubmissionAuthorsCell","Name","Title",
         "File","PreInscriptions","Vacancies",
      ),
      "Data_UK" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Status",
         "Event","Type","Area","Level",
         "SubmissionAuthorsCell","Name","Title_UK",
         "File","PreInscriptions","Vacancies",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
    "Authors" => array
    (
       "Name" => "Autores & Certificados",
       "Name_UK" => "Authors & Certificates",
       "Data" => array
       (
          "No","Edit",
          //"Delete",
          "GenCert","MailCert","Assessments",
          "Status",
          "Event","Name","Title","Title_UK","Selected",
          "Certificate","Certificate_TimeLoad",
          "Author1","Author2","Author3",
        ),

       "Admin" => 1,
       "Person" => 0,
       "Public" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
   ),
   "Submission" => array
   (
      "Name" => "Detalhes",
      "Name_UK" => "Details",
      "Data" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Author1","Status",
         "Type","Area","Level",
         "Name","Title","Keywords",
      ),
      "Data_UK" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Author1","Status",
         "Type","Area","Level",
         "Name","Title_UK","Keywords",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "PreInscriptions" => array
   (
      "Name" => "PreInscrições",
      "Name_UK" => "PreInscriptions",
      "Data" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Name",
         "Type","Area","Level","Friend",
         "Title","Vacancies",
         "SubmissionNPreInscriptionsCell","SubmissionVacanciesCell",
      ),
      "Data_UK" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Name","Status",
         "Type","Area","Level","Friend",
         "Title_UK","Vacancies",
         "SubmissionNPreInscriptionsCell","SubmissionVacanciesCell",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "AccessMethod" => "Event_PreInscriptions_Has",
   ),
   "Assessments" => array
   (
      "Name" => "Avaliações",
      "Name_UK" => "Assessments",
      "Data" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Name","Title","Friend",
         "Type","Area","Level","Result","Status",
         
      ),
      "Data_UK" => array
      (
         "No","Edit","Delete","GenCert","Assessments",
         "Name",
         "Title_UK","Friend",
         "Type","Area","Level","Result","Status",
      ),
            
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "GenTableMethod" => "Submission_Assessments_Table",
      "AccessMethod" => "Event_Assessments_Has",
   ),
);
