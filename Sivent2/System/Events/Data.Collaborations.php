array
(     
   "Collaborations" => array
   (
      "Name" => "Colaborações",
      "ShortName" => "Colaborações",
      "Title" => "Colaborações",
      "SelectCheckBoxes"  => 2,
      
      "Name_UK" => "Collaborations",
      "ShortName_UK" => "Collaborations",
      "Title_UK" => "Collaborations",
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
   "Collaborations_Inscriptions" => array
   (
      "Name" => "Com Inscrições",
      
      "Name_UK" => "Has Inscriptions",

      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "SelectCheckBoxes"  => 2,
      
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
   "Collaborations_StartDate" => array
   (
      "Name" => "Inscrições Início",
      "ShortName" => "Inscrições Início",
      "Title" => "Inscrições Início, Data",
      
      "Name_UK" => "Inscriptions Begins",
      "ShortName_UK" => "Inscriptions Begins",
      "Title_UK" => "Inscriptions Begins, Date",
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
   "Collaborations_EndDate" => array
   (
      "Name" => "Inscrições Até",
      "ShortName" => "Inscrições Até",
      "Title" => "Inscrições Até, Data",
      
      "Name_UK" => "Inscriptions Untill",
      "ShortName_UK" => "Inscriptions Untill",
      "Title_UK" => "Inscriptions Untill, Date",
      "Sql" => "INT",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
   "Certificates_Collaborations_Latex" => array
   (
      "Name" => "Colaborações, Certificado (LaTeX)",
      "Name_UK" => "Collaborations, Certificate (LaTeX)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>
      "\\begin{Large}\n".
      "Certificamos que:\n\n".

      "\\begin{center}\\huge{\\textbf{#Friend_Name}}\\end{center}\n\n".
      
      "\\vspace{0.25cm}\n\n".

      "participou do \\textbf{#Event_Name}, #Event_Title, realizado na \\textit{#Event_Place},\n".
      "no dia \\textit{#Event_DateSpan},\n".
      "#Collaboration_CertText :\n\n".
      
      "\\begin{center}\\huge{\\textbf{#Collaboration_Name}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
     "Carga horária: \\textbf{#Collaborator_TimeLoad horas}.\n".
      "\\end{Large}\n\n".
      "",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Collaborations_Latex_UK" => array
   (
      "Name" => "Colaborações, Certificado (UK)",
      "Name_UK" => "Collaborations, Certificate (UK)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>
      "\\begin{Large}\n".
      "We hereby certify, that:\n\n".

      "\\begin{center}\\huge{\\textbf{#Friend_Name}}\\end{center}\n".
      "\\vspace{0.25cm}\n\n".

      "participated in \\textbf{#Event_Name}, #Event_Title, held at \\textbf{#Event_Place},\n".
      "at the \\textit{#Event_DateSpan},\n".
      
      "#Collaboration_CertText_UK:\n\n".
      
      "\\begin{center}\\huge{\\textbf{#Collaboration_Name_UK}}\\end{center}\n\n".

      "\\vspace{0.25cm}\n\n".
      
     "Timeload: \\textbf{#Collaborator_TimeLoad horas}.\n".
      "\\end{Large}\n\n".
     
      "",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
);
