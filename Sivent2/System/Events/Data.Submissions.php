array
(     
   "Submissions" => array
   (
      "Name" => "Submissões",
      "Name_UK" => "Submissions",
      
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
   "Submissions_StartDate" => array
   (
      "Name" => "Submissões Início",
      //"ShortName" => "Inscrições início",
      "Title" => "Submissões Início, Data",
      
      "Name_UK" => "Submissions Begins",
      //"ShortName_UK" => "Inscriptions begins",
      "Title_UK" => "Submissions Begins, Date",
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
   "Submissions_Inscriptions" => array
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
   "Submissions_EndDate" => array
   (
      "Name" => "Submissões Até",
      //"ShortName" => "Inscrições até",
      "Title" => "Submissões Até, Data",
      
      "Name_UK" => "Submissions Untill",
      //"ShortName_UK" => "Inscriptions untill",
      "Title_UK" => "Submissions Untill, Date",
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
   "Submissions_Public" => array
   (
      "Name" => "Submissões Públicos",
      "Name_UK" => "Submissions Public",
      
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
);
