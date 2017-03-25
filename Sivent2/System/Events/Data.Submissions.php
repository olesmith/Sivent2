array
(     
   "Submissions" => array
   (
      "Name" => "Atividades",
      "Name_UK" => "Activities",
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
   "Submissions_NAuthors" => array
   (
      "Name" => "No. de Autores",
      "Title" => "No. de Autores",
      
      "Name_UK" => "No. of Authors",
      "Title_UK" => "No. of Authors",
      "Sql" => "INT",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Default"  => 3,
      "Size"  => 1,
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
   "Submissions_StartDate" => array
   (
      "Name" => "Submissões Início",
      "Title" => "Atividades, Submissões Início, Data",
      
      "Name_UK" => "Submissions Begins",
      "Title_UK" => "Activity Submissions Begins, Date",
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
   "Submissions_EndDate" => array
   (
      "Name" => "Submissões Até",
      "Title" => "Atividades, Submissões Até, Data",
      
      "Name_UK" => "Submissions Untill",
      "Title_UK" => "Activity Submissions Untill, Date",
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
      "Name" => "Atividades Públicos",
      "Name_UK" => "Activities Public",
      
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
      "Name" => "Atividades, Certificado (LaTeX)",
      "Name_UK" => "Activities, Certificate (LaTeX)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>
      "\\begin{Large}\n".
      "Certificamos que:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Authors}}\\end{center}\n\n".
      
      "\\vspace{0.25cm}\n\n".

      "participou do \\textbf{#Event_Name}, #Event_Title, realizado na \\textit{#Event_Place},\n".
      "nos dias \\textit{#Event_DateSpan},\n".
      "contribuindo com a palestra:\n\n".
      
      "\\begin{center}\\huge{\\textbf{#Submission_Title}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
     "Carga horária: \\textbf{#Submission_Certificate_TimeLoad horas}.\n".
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
      "Name" => "Atividades, Certificado (UK)",
      "Name_UK" => "Activities, Certificate (UK)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>
      "\\begin{Large}\n".
      "We hereby certify, that:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Authors}}\\end{center}\n".
      "\\vspace{0.25cm}\n\n".

      "participated in \\textbf{#Event_Name}, #Event_Title, held at \\textbf{#Event_Place},\n".
      "at the \\textit{#Event_DateSpan},\n\n".
      "contributing with the talk:\n\n".

      "\\begin{center}\\huge{\\textbf{#Submission_Title}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
      "Time Load: \\textbf{#Submission_Certificate_TimeLoad hours}.\n".
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
      "Name" => "Atividades, CH Padrão",
      "Name_UK" => "Activities, Default TimeLoad",

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
