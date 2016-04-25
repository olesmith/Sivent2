array
(
   "Caravans" => array
   (
      "Name" => "Você Quer Coordenar uma Caravana?",
      "Name_UK" => "Do You Want to Coordinate a Caravan?",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,

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
