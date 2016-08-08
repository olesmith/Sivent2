array
(     
   "Assessments" => array
   (
      "Name" => "Avaliação de Propostas de Atividades",
      "Title" => "Avaliação de Propostas de Atividades",
      "SelectCheckBoxes"  => 2,
      
      "Name_UK" => "Assessment of Proposed Activities",
      "Title_UK" => "Assessment of Proposed Activities",
      
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
   
   "Assessments_StartDate" => array
   (
      "Name" => "Avaliações Início",
      "Title" => "Avaliações Início, Data",
      
      "Name_UK" => "Assessments Begins",
      "Title_UK" => "Assessments Begins, Date",
      
      "Sql" => "INT",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
   "Assessments_EndDate" => array
   (
      "Name" => "Avaliações Até",
      "Title" => "Avaliações Até, Data",
      
      "Name_UK" => "Assessments Untill",
      "Title_UK" => "Assessments Untill, Date",
      
      "Sql" => "INT",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "IsDate"  => TRUE,
   ),
);
