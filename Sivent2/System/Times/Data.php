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
      "Compulsory" => 1,
    ),
   "Date" => array
   (
      "Name" => "Data",
      "Name_UK" => "Date",
      
      "SqlClass" => "Dates",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      //"SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Date",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Sort" => array
   (
      "Name" => "Ordem",
      "Name_UK" => "Order",

      "Size" => "8",
      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
   ),
   "Name" => array
   (
      "Name" => "Horário",
      "Title" => "Horário",
      "Name_UK" => "Time",
      "Title_UK" => "Time",

      "Size" => "8",
      "Sql" => "VARCHAR(16)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
   ),
   "Duration" => array
   (
      "Name" => "Duração",
      "Name_UK" => "Duration",

      "Size" => "8",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
   ),
   "StartHour" => array
   (
      "Name" => "Hora Início",
      "Name_UK" => "Start Hour",

      "Size" => "2",
      "Sql" => "VARCHAR(8)",
      "Format" => "%02d",
      "Default" => "00",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory" => 1,
   ),
   "StartMin" => array
   (
      "Name" => "Minute Início",
      "Name_UK" => "Start Minute",

      "Size" => "2",
      "Sql" => "VARCHAR(8)",
      "Format" => "%02d",
      "Default" => "00",
      "Regexp" => "^[0-5]?[0-9]",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory" => 1,
   ),
   "EndHour" => array
   (
      "Name" => "Hora Fim",
      "Name_UK" => "End Hour",

      "Size" => "2",
      "Sql" => "VARCHAR(8)",
      "Format" => "%02d",
      "Default" => "00",
      "Regexp" => "^[0-2]?[0-9]",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory" => 1,
   ),
   "EndMin" => array
   (
      "Name" => "Minute Fim (MM)",
      "Name_UK" => "End Minute (MM)",

      "Size" => "2",
      "Sql" => "VARCHAR(8)",
      "Format" => "%02d",
      "Regexp" => "^[0-5]?[0-9]",
      "Default" => "00",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory" => 1,
   ),
   "Type" => array
   (
      "Name" => "Tipo",
      "Title" => "Tipo",
      "Name_UK" => "Type",
      "Title_UK" => "Type",

      "Size" => "8",
      "Sql" => "ENUM",
      "Values" => array("Individual","Comum"),
      "Default" => 1,
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
   ),
   "Activity" => array
   (
      "Name" => "Atividade",
      "Name_UK" => "Activity",

      "Size" => "25",
      "Sql" => "VARCHAR(256)",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
   ),
);
