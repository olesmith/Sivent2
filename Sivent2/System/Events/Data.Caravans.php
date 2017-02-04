array
(     
   "Caravans" => array
   (
      "Name" => "Caravanas",
      "ShortName" => "Caravanas",
      "Title" => "Caravanas",
      "SelectCheckBoxes"  => 2,
      
      "Name_UK" => "Caravans",
      "ShortName_UK" => "Caravans",
      "Title_UK" => "Caravans",
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
   
   "Caravans_StartDate" => array
   (
      "Name" => "Inscrições Início",
      "ShortName" => "Inscrições Início",
      "Title" => "Inscrições Início, Data",
      
      "Name_UK" => "Inscriptions Begins",
      "ShortName_UK" => "Inscriptions Begins",
      "Title_UK" => "Inscriptions Begins, Date",
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
   "Caravans_EndDate" => array
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
   "Caravans_Min" => array
   (
      "Name" => "Min. de Inscrições",
      "Title" => "Mínimo de Inscrições",
      
      "Name_UK" => "Min. Inscriptions",
      "Title_UK" => "Minimum No of Inscriptions",
      "Sql" => "INT",
      "Regexp" => '^\d+$',
      "Size" => 2,
     
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Default" => 20,
   ),
   "Caravans_Max" => array
   (
      "Name" => "Max. de Inscrições",
      "Title" => "Máximo de Inscrições",
      
      "Name_UK" => "Max. Inscriptions",
      "Title_UK" => "Maximum No of Inscriptions",
      "Sql" => "INT",
      "Size" => 2,
      "Regexp" => '^\d+$',
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Default" => 40,
   ),
   "Caravans_Timeload" => array
   (
      "Name" => "CH Padrão Participantes",
      "Title" => "CH Padrão Participantes (Cert)",
      "Default" => "10",
      
      "Name_UK" => "Default Timeload Participants",
      "Title_UK" => "Default Timeload Participants (Cert)",
      "Sql" => "INT",
      "Size" => 2,
      "Regexp" => '^\d+$',
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
   ),
   "Caravans_Coord_Timeload" => array
   (
      "Name" => "CH Padrão Coordenador",
      "Title" => "CH Padrão Coordenador (Cert)",
      "Default" => "20",
      
      "Name_UK" => "Default Timeload Coordinator",
      "Title_UK" => "Default Timeload Coordinator (Cert)",
      "Sql" => "INT",
      "Size" => 2,
      "Regexp" => '^\d+$',
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
   ),
   "Certificates_Caravans_Latex" => array
   (
      "Name" => "Caravanas, Certificado (LaTeX)",
      "Name_UK" => "Caravans, Certificate (LaTeX)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>

      "\\begin{Large}\n".
      "Certificamos que:\n\n".

      "\\begin{center}\\huge{\\textbf{#Friend_Name}}\\end{center}\n\n".
      
      "\\vspace{0.25cm}\n\n".

      "participou do \\textbf{#Event_Name}, #Event_Title, realizado na \\textit{#Event_Place},\n".
      "no dia \\textit{#Event_DateSpan}, coordenando a caravana #Name.\n\n".
      "Carga horária: \\textbf{#TimeLoad horas}.\n".
      "\\end{Large}\n\n".
      
      "",


      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Caravaneers_Latex" => array
   (
      "Name" => "Caravaneiros, Certificado (LaTeX)",
      "Name_UK" => "Caravaneers, Certificate (LaTeX)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>

      "\\begin{Large}\n".
      "Certificamos que:\n\n".

      "\\begin{center}\\huge{\\textbf{#Caravaneer_Name}}\\end{center}\n\n".
      
      "\\vspace{0.25cm}\n\n".

      "participou do \\textbf{#Event_Name}, #Event_Title, realizado na \\textit{#Event_Place},\n".
      "no dia \\textit{#Event_DateSpan}, como participante da caravana #Caravan_Name.\n\n".
      "Carga horária: \\textbf{#Caravaneer_TimeLoad horas}.\n".
      "\\end{Large}\n\n".
      
      "",


      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Caravaneers_Latex_UK" => array
   (
      "Name" => "Caravaneiros, Certificado (UK)",
      "Name_UK" => "Caravaneers, Certificate (UK)",

      "Sql" => "TEXT",
      "Size" => "100x",

      "Search" => FALSE,
      "Default" =>
      
      "\\begin{Large}\n".
      "We hereby certify, that:\n\n".

      "\\begin{center}\\huge{\\textbf{#Caravaneer_Name}}\\end{center}\n".
      "\\vspace{0.25cm}\n\n".

      "participated in \\textbf{#Event_Name}, #Event_Title, held at \\textbf{#Event_Place},\n".
      "at the \\textit{#Event_DateSpan} as a caravan participant. Timeload: \\textbf{#Caravaneer_TimeLoad hours}.\n".
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
