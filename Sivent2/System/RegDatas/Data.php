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
      "Admin"    => 1,
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
      
      "Public"      => 1,
      "Person"      => 0,
      "Admin"       => 1,
      "Friend"      => 1,
      "Coordinator" => 1,
   ),
   "DataKey" => array
   (
      "Name" => "Dado",
      "Name_UK" => "Data",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Size" => "20",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,

      "Unique"  => TRUE,
      #"FieldMethod" => "RegGroup_Key_Field",
   ),
   "Active" => array
   (
      "Name" => "Ativo",
      "Name_UK" => "Active",

      "Sql" => "ENUM",
      "Values" => array("N&atilde;o","Sim"),
      "Values_UK" => array("No","Yes"),
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
      "SelectCheckBoxes"  => 3,
   ),
);
