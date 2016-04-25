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
   "Caravans_StartDate" => array
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
   "Caravans_EndDate" => array
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
   "Caravans_Min" => array
   (
      "Name" => "Min. de Inscrições",
      "Title" => "Mínimo de Inscrições",
      
      "Name_UK" => "Min. Inscriptions",
      "Title_UK" => "Minimum No of Inscriptions",
      "Sql" => "INT",
      "Regexp" => '^\d+$',
      "Size" => 2,
     
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
   ),
   "Caravans_Max" => array
   (
      "Name" => "Max. de Inscrições",
      "Title" => "Máximo de Inscrições",
      
      "Name_UK" => "Max. Inscriptions",
      "Title_UK" => "Maximum No of Inscriptions",
      "Sql" => "INT",
      "Size" => 2,
      "Regexp" => '^\d+$',
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => FALSE,
      "Search" => FALSE,
   ),
);
