array
(     
   "Submissions" => array
   (
      "Name" => "Submissões",
      "Name_UK" => "Submissions",
      "SelectCheckBoxes"  => 2,

      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
   ),
   "Submissions_StartDate" => array
   (
      "Name" => "Inscrições Início",
      "Title" => "Submissões, Inscrições Início, Data",
      
      "Name_UK" => "Inscriptions Begins",
      "Title_UK" => "Submission Inscriptions Begins, Date",
      "Sql" => "INT",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
   "Submissions_Inscriptions" => array
   (
      "Name" => "Com Inscrições",
      
      "Name_UK" => "Has Inscriptions",

      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
   ),
   "Submissions_EndDate" => array
   (
      "Name" => "Inscrições Até",
      "Title" => "Submissões, Inscrições Até, Data",
      
      "Name_UK" => "Inscriptions Untill",
      "Title_UK" => "Submission Inscriptions Untill, Date",
      "Sql" => "INT",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
   "Submissions_Public" => array
   (
      "Name" => "Submissões Públicos",
      "Name_UK" => "Submissions Public",
      
      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
   ),
   "Certificates_Submissions_Latex" => array
   (
      "Name" => "Submissões, Certificado (LaTeX)",
      "Name_UK" => "Submissions, Certificate (LaTeX)",

      "Sql" => "TEXT",
      "Size" => "100x10",

      "Search" => FALSE,
      "Default" =>

      "\n\n\\hspace{1cm}\\vspace{4.5cm}\n\n".

      "\\begin{Large}\n".
      "Certificamos que:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Authors}}\\end{center}\n\n".
      
      "\\vspace{0.25cm}\n\n".

      "participou do \\textbf{#Event_Name}, #Event_Title, realizado na \\textit{#Event_Place},\n".
      "no dia \\textit{#Event_DateSpan},\n".
      "contribuindo com a palestra:\n\n".
      
      "\\begin{center}\\huge{\\textbf{#Submission_Title}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
     "Carga horária de \\textbf{#Submission_Certificate_TimeLoad horas}.\n".
      "\\end{Large}\n\n".
      
      "",


      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Submissions_Latex_UK" => array
   (
      "Name" => "Submissões, Certificado (UK)",
      "Name_UK" => "Submissions, Certificate (UK)",

      "Sql" => "TEXT",
      "Size" => "100x10",

      "Search" => FALSE,
      "Default" =>
      
      "\n\n\\hspace{1cm}\\vspace{5.5cm}\n\n".

      "\\begin{Large}\n".
      "We hereby certify, that:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Authors}}\\end{center}\n".
      "\\vspace{0.25cm}\n\n".

      "participated in \\textbf{#Event_Name}, #Event_Title, held at \\textbf{#Event_Place},\n".
      "at the \\textit{#Event_DateSpan},\n\n".
      "contributing with the talk:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Title}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
      "Timeload: \\textbf{#Submission_Certificate_TimeLoad hours}.\n".
      "\\end{Large}\n\n".
      
      "",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Submissions_TimeLoad" => array
   (
      "Name" => "Submissões, CH Padrão",
      "Name_UK" => "Submissions, Default TimeLoad",

      "Sql" => "VARCHAR(8)",
      "Default" => "2",
      "Size" => 2,
      "Regexp" => '^\d+$',

      "Search" => FALSE,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),

);
