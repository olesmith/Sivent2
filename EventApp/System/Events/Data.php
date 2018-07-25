array
(
   "ID" => array
   (
      "Name" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
   ),
   "Unit" => array
   (
      "Name" => "Unidade",
      "Name_UK" => "Unit",

      "Sql" => "INT",
      "SqlClass" => "Units",
      "Search" => FALSE,
      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Unit",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Compulsory" => 1,
   ),
   "Name" => array
   (
      "Name" => "Nome",
      "Name_UK" => "Name",
      "Name_ES" => "Nombre",
      "Title" => "Nome do Evento",
      "Title_UK" => "Event Name",
      "Title_ES" => "Nombre del Evento",

      "Size" => "20",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Search_Joined" => array("Title","Initials"),
      "Compulsory"  => TRUE,
   ),
   "Title" => array
   (
      "Name" => "Título",
      "Name_UK" => "Title",
      "Name_ES" => "Título",
      
      "Title" => "Título do Evento",
      "Title_UK" => "Event Title",
      "Title_ES" => "Título del Evento",
      
      "Size" => "50",
      "Sql" => "VARCHAR(255)",
      "Public" => 1,
      "Person" => 0,
      "Admin" => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => False,
      "Compulsory"  => TRUE,
   ),
   "Date" => array
   (
      "Name" => "Data de Publicação",
      "ShortName" => "Publicação",
      "Title" => "Data de Publicação",
      
      "Name_UK" => "Publication Date",
      "ShortName_UK" => "Publication",
      "Title_UK" => "Publication Date",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "Inscriptions_Public" => array
   (
      "Title" => "Inscrições Abertas ao Público",
      "Name" => "Inscrições Públicas",
      
      "Name_UK" => "Public Inscriptions",
      "ShortName_UK" => "Publication",
      "Title_UK" => "Inscriptions are Public",
      
      "Sql" => "ENUM",
      "Values" => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),
      "Default" => 1,
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
   ),
   "StartDate" => array
   (
      "Name" => "Início das Inscrições",
      "ShortName" => "Início",
      "Title" => "Data de Início das Inscrições",
      
      "Name_UK" => "Inscriptions Starts",
      "ShortName_UK" => "Start",
      "Title_UK" => "Inscriptions Starts Date",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "EndDate" => array
   (
      "Name" => "Novas Inscrições Até",
      "ShortName" => "Inscrições Até",
      "Title" => "Novas Inscrições Até",
      
      "Name_UK" => "Inscriptions Ends",
      "ShortName_UK" => "End",
      "Title_UK" => "Inscriptions Ends Date",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "EditDate" => array
   (
      "Name" => "Editar Inscrições Até",
      "ShortName" => "Editar Até",
      "Title" => "Editar Inscrições Até",
      
      "Name_UK" => "Inscriptions Editable Until",
      "ShortName_UK" => "Editable",
      "Title_UK" => "Inscriptions Editable until Date",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "Announcement" => array
   (
      "Name" => "Edital",
      "Name_UK" => "Announcement",

      "Sql" => "FILE",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 0,
      "Extensions" => "pdf",
      "Icon" => "fas fa-file-pdf",
      "Iconify" => TRUE, 
   ),
   "Site" => array
   (
      "Name" => "Site do Evento",
      "Name_UK" => "Event Site",
      "Title" => "Site Oficial do Evento",
      "Title_UK" => "Official Event Site",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,
      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 0,
      "Iconify" => TRUE, 
   ),
   "HtmlLogoHeight" => array
   (
      "Name" => "Altura do Logotipo (px)",
      "Name_UK" => "Logo Height (px)",

      "Sql" => "INT",

      "Search" => FALSE,
      "Size" => 3,
      "Default"  => "0",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "HtmlLogoWidth" => array
   (
      "Name" => "Largura do Logotipo (px)",
      "Name_UK" => "Logo Width (px)",

      "Sql" => "INT",
      "Size" => 3,

      "Search" => FALSE,
      "Default"  => "0",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Updated_From" => array
   (
      "Name" => "Evento Fonte",
      "Name_UK" => "Event Source",

      "Sql" => "INT",
      "Size" => 3,
      "SqlClass" => "Events",

      "Search" => FALSE,
      "Default"  => "0",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),

);