array
(
   "Collaborations" => array
   (
      "Name" => "Você Quer ser Colaborador?",
      "Name_UK" => "Do You Want to be a Collaborator?",

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
      "Assessor"  => 0,
   ),
   "Collaborations_Activity" => array
   (
      "Name" => "Comentário",
      "Name_UK" => "Comment",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,
      "Size" => 50,
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
);
