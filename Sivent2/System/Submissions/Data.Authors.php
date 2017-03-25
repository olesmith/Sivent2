array
(
    //Do not use data names ending in numbers
   "Friend" => array
   (
      "Name" => "Cadastro, Coautor #n",
      "Name_UK" => "Registration, Coautor #n",

      "Sql" => "INT",

      "SqlClass" => "Friends",
      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "TriggerFunction" => "UpdateSpeaker",
      "EditFieldMethod"  => "Author_Friend_Select",
   ),
   "Author" => array
   (
      "Name" => "Coautor #n",
      "Name_UK" => "Coauthor #n",

      "Sql" => "VARCHAR(256)",
      "Search" => FALSE,

      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "PermsMethod"  => "Submission_Author_Data_Perms",
   ),
   "Author_Email" => array
   (
      "Name" => "Coautor #n, Email",
      "Name_UK" => "Coautor #n, Email",

      "Sql" => "VARCHAR(256)",
      "Search" => FALSE,

      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "PermsMethod"  => "Submission_Author_Data_Perms",
   ),
)