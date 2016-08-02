array
(     
   "PreInscriptions_StartDate" => array
   (
      "Name" => "Inscrições Início",
      "Title" => "Preinscrições, Inscrições Início, Data",
      
      "Name_UK" => "Inscriptions Begins",
      "Title_UK" => "PreInscriptions, Inscriptions Begins, Date",
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
   "PreInscriptions_EndDate" => array
   (
      "Name" => "Inscrições Até",
      "Title" => "Preinscrições, Inscrições Até, Data",
      
      "Name_UK" => "Inscriptions Untill",
      "Title_UK" => "Preinscrições, Inscriptions Untill, Date",
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
   "PreInscriptions_MustHavePaid" => array
   (
      "Name" => "Pagamento Exigido",
      "Title" => "Preinscrições, Pagamento Exigido",
      
      "Name_UK" => "Payment Required",
      "Title_UK" => "Preinscrições, Payment Required",
      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"   => 1,
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
   ),
);
