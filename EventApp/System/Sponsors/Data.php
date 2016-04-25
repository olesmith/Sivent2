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
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Compulsory" => 1,
   ),
   "Event" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",
      "SqlClass" => "Events",
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Initials" => array
   (
      "Name" => "Sigla",
      "Title" => "Sigla do Patrocinador",
      "Name_UK" => "Initials",
      "Title_UK" => "Sponsor Initials",

      "Size" => "8",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Name" => array
   (
      "Name" => "Nome",
      "Title" => "Nome do Patrocinador",
      "Name_UK" => "Name",
      "Title_UK" => "Sponsor Name",

      "Size" => "50",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Level" => array
   (
      "Name" => "Nível",
      "Title" => "Nível",
      "Name_UK" => "Level",
      "Title_UK" => "Level",
      "Values" => array("Prata","Ouro","Diamante"),
      "Values_UK" => array("Silver","Gold","Diamond"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Value" => array
   (
      "Name" => "Valor",
      "Title" => "Valor",
      "Name_UK" => "Value",
      "Title_UK" => "Value",

      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Size"  => 5,
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
   "URL" => array
   (
      "Name" => "URL",
      "Title" => "URL do Patrocinador",
      "Name_UK" => "URL",
      "Title_UK" => "Sponsor URL",
      "Size" => "50",
      "Sql" => "VARCHAR(255)",
      "Public" => 1,
      "Person" => 0,
      "Admin" => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Text" => array
   (
      "Name" => "Texto",
      "Title" => "Texto do Patrocinador",
      "Name_UK" => "Text",
      "Title_UK" => "Sponsor Text",
      "Size" => "50",
      "Sql" => "VARCHAR(255)",
      "Public" => 1,
      "Person" => 0,
      "Admin" => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Logo" => array
   (
      "Name" => "Logo",
      "Name_UK" => "Logo",

      "Sql" => "FILE",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Extensions" => array("png","jpg"),
      "Iconify" => TRUE,
   ),
   "Place" => array
   (
      "Name" => "Posição",
      "Name_UK" => "Position",

      "Sql" => "ENUM",
      "Values" => array("Esquerdo","Centro","Direito"),
      "Values_UK" => array("Left","Center","Right"),

      "Search" => FALSE,
      "Default" => 2,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => TRUE,
   ),
   "Height" => array
   (
      "Name" => "Altura (pixels)",
      "Name_UK" => "Height (pixels)",

      "Sql" => "INT",
      "Size" => "3",

      "Search" => FALSE,
      "Default" => 100,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
   ),
   "Width" => array
   (
      "Name" => "Largura (pixels)",
      "Name_UK" => "Width (pixels)",

      "Sql" => "INT",
      "Size" => "3",

      "Search" => FALSE,
      "Default" => 150,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
   ),
);
