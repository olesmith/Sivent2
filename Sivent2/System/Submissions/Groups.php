array
(
   "Basic" => array
   (
      "Name" => "Básicos",
      "Name_UK" => "Basic",
      "Data" => array
      (
         "No","Edit","Copy","Delete","Print","GenCert","Assessments",
         "Name","Status",
         "Type","Area","Level",
         "Submission_Authors_Cell",
         "Title",
         "File","PreInscriptions","Vacancies",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Inscription" => array
   (
      "Name" => "Inscrição",
      "Name_UK" => "",
      "Data" => array
      (
          "No","Edit",
          #"Edit","Copy","Delete","Print","GenCert","Assessments",
          "Title",
          "Status",
         "Type","Area","Level","Vacancies",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Timess" => array
   (
      "Name" => "Tempos",
      "Name_UK" => "Times",
      "Data" => array
      (
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Name","Status","CTime","MTime","ATime",
         "Type","Area","Level",
         "Submission_Authors_Cell",
         "Title",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
   ),
    "Authors" => array
    (
       "Name" => "Autores",
       "Name_UK" => "Authors",
       "Data" => array
       (
          "No","Edit","Copy",
          "Delete",
          "Assessments",
          "Name","Status",
          "Title","Title_UK","Selected",
        ),
       "NIndent" => 5,

       //"AuthorData" => array("Friend","Author","Author_Email"),
       "AuthorTitles" => array("Autor, Cadastro","Nome","Email"),
       "AuthorTitles_UK" => array("Author Registration","Name","Author"),
       
       "Admin" => 1,
       "Person" => 0,
       "Public" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Submissions_Authors_Group_Gen",
   ),
   "Certificates" => array
   (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "No","Edit","Copy",
          "Delete",
          "GenCert","MailCert","Assessments",
          "Name","Status",
          "Title","Title_UK","Selected",
          "Certificate","Certificate_TimeLoad",
        ),

       "AuthorData" => array("Author"),
       "AuthorTitles" => array("Nome do Autor"),
       "AuthorTitles_UK" => array("Author Name"),
       
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
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Author","Status",
         "Type","Area","Level",
         "Title","File",
      ),
      /* "Data_UK" => array */
      /* ( */
      /*    "No","Edit","Copy","Delete","GenCert","Assessments", */
      /*    "Author","Status", */
      /*    "Type","Area","Level", */
      /*    "Name","Title_UK","File", */
      /* ), */
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
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Name",
         "Type","Area","Level","Submission_Authors_Cell",
         "Title","Vacancies",
         "SubmissionNPreInscriptionsCell","SubmissionVacanciesCell",
      ),
      "Data_UK" => array
      (
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Name",
         "Type","Area","Level","Submission_Authors_Cell",
         "Title_UK","Vacancies",
         "SubmissionNPreInscriptionsCell","SubmissionVacanciesCell",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "AccessMethod" => "Event_PreInscriptions_Has",
   ),
   "Assessments" => array
   (
      "Name" => "Avaliadores & Avaliações",
      "Name_UK" => "Assessors & Assessments",
      "Data" => array
      (
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Name","Title","Friend",
         "Type","Area","Level","Result","Status",
         
      ),
      "Data_UK" => array
      (
         "No","Edit","Copy","Delete","GenCert","Assessments",
         "Name",
         "Title_UK","Friend",
         "Type","Area","Level","Result","Status",
      ),
            
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "GenTableMethod" => "Submissions_Assessors_Table",
      "AccessMethod" => "Event_Assessments_Has",
   ),
);
