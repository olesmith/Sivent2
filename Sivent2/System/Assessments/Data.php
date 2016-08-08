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
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Event",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Name" => array
   (
      "Name" => "Avaliação",
      "Name_UK" => "Assessment",

      "Size" => 50,
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Friend" => array
   (
      "Name" => "Assessor",
      "Name_UK" => "Assessor",
      
      "SqlClass" => "Friend",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Friend",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Submission" => array
   (
      "Name" => "Atividade",
      "Name_UK" => "Activity",
      
      "SqlClass" => "Submissions",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Submission",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Criteria" => array
   (
      "Name" => "Critério",
      "Name_UK" => "Criteria",
      
      "SqlClass" => "Criterias",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Criteria",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Value" => array
   (
      "Name" => "Avaliação",
      "Name_UK" => "Assesment",

      "Size" => 2,
      "Sql" => "ENUM",
      "Values" => array("01","02","03","04","05","06","07","08","09","10",),
      "EmptyName" => " ",
      "Default" => "0 ",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),   
   "Weighted" => array
   (
      "Name" => "Pontuação",
      "Name_UK" => "Ponded",

      "Size" => 2,
      "Sql" => "REAL",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),   
);
