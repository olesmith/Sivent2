array
(
   "ID" => array
   (
      "Name" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Public"   => 0,
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

      "Public"   => 0,
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

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Sql" => "INT",
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Friend" => array
   (
      "Name" => "Avaliador",
      "Name_UK" => "Assessor",
      
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Friend",
      
      "Sql" => "INT",
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 0,
      "Coordinator" => 2,
    ),
   "Submission" => array
   (
      "Name" => "Atividade",
      "Name_UK" => "Activity",
      
      "SqlClass" => "Submissions",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Submission",
      
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Name" => array
   (
      "Name" => "Nome",
      "Name_UK" => "Name",

      "Size" => 50,
      "Sql" => "VARCHAR(256)",
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 0,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
   "HasAssessed" => array
   (
      "Name" => "Completou Avaliação",
      "Name_UK" => "Assessment Completed",

      "Size" => 50,
      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"   => 1,
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "HasAccessed" => array
   (
      "Name" => "Acessou Avaliação",
      "Name_UK" => "Accessed Completed",

      "Size" => 50,
      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"   => 1,
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Result" => array
   (
      "Name" => "Resultado",
      "Name_UK" => "Result",

      "Sql" => "REAL",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
      "Align"  => "right",
      "Format"  => "%.1f",
   ),
   "CoordComment" => array
   (
      "Name"    => "Comentário para Coordenação",
      "Name_ES" => "Comentário para Coordenacion",
      "Name_UK" => "Comment to Coordination",

      "Sql" => "REAL",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 0,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
      "Format"  => "%.1f",
   ),
   "FriendComment" => array
   (
      "Name"    => "Comentário para Autor",
      "Name_ES" => "Comentário para Autor",
      "Name_UK" => "Comment to Author",

      "Sql" => "REAL",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
      "Format"  => "%.1f",
   ),

);
