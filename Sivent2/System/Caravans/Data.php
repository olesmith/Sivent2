array
(     
   "Caravans" => array
   (
      "Name" => "Caravanas",
      "ShortName" => "Caravanas",
      "Title" => "Caravanas",
      
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
   "Caravans_Name" => array
   (
      "Name" => "Nome da Caravana",
      "Name_UK" => "Caravan Name",

      "Sql" => "VARCHAR(256)",
      "Size" => 25,

      "Search" => TRUE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   "Caravans_NParticipants" => array
   (
      "Name" => "No. de Participantes",
      "Name_UK" => "No. of Participants",

      "Sql" => "INT",


      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Caravans_Status" => array
   (
      "Name" => "Min. no de Participantes",
      "Name_UK" => "Min. no. of Participants",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,


      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
 
);
