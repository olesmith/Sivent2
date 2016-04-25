array
(     
   "Collaborations" => array
   (
      "Name" => "Colaborações",
      "ShortName" => "Colaborações",
      "Title" => "Colaborações",
      
      "Name_UK" => "Collaborations",
      "ShortName_UK" => "Collaborations",
      "Title_UK" => "Collaborations",
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
      "Compulsory"  => TRUE,
   ),
   "Collaborations_Inscriptions" => array
   (
      "Name" => "Com Inscrições",
      
      "Name_UK" => "Has Inscriptions",

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
      "Compulsory"  => TRUE,
   ),
   "Collaborations_StartDate" => array
   (
      "Name" => "Inscrições Início",
      "ShortName" => "Inscrições Início",
      "Title" => "Inscrições Início, Data",
      
      "Name_UK" => "Inscriptions Begins",
      "ShortName_UK" => "Inscriptions Begins",
      "Title_UK" => "Inscriptions Begins, Date",
      "Sql" => "INT",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
   "Collaborations_EndDate" => array
   (
      "Name" => "Inscrições Até",
      "ShortName" => "Inscrições Até",
      "Title" => "Inscrições Até, Data",
      
      "Name_UK" => "Inscriptions Untill",
      "ShortName_UK" => "Inscriptions Untill",
      "Title_UK" => "Inscriptions Untill, Date",
      "Sql" => "INT",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
);
