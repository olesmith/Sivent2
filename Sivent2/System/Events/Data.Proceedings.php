array
(     
   "Proceedings" => array
   (
      "Name" => "Anais",
      "Name_UK" => "Proceedings",
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
      "Compulsory"  => False,
   ),

   "Proceedings_DocType" => array
   (
      "Name" => "Documentclass",

      "Sql" => "ENUM",
      "Values" => array("article","report","book",),
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => False,
   ),
   "Proceedings_DocType_Options" => array
   (
      "Name" => "Options",

      "Sql" => "VARCHAR(256)",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => "a4paper",
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => False,
   ),

   "Proceedings_Preamble" => array
   (
      "Name" => "Preamble",

      "Sql" => "TEXT",
      "Size" => "100x15",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => '',
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => False,
   ),
   "Proceedings_Postamble" => array
   (
      "Name" => "Postamble",

      "Sql" => "TEXT",
      "Size" => "100x",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => '',
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => False,
   ),

   
);
