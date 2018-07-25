array
(
   "ID" => array
   (
      "Name" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
   ),
   "Unit" => array
   (
      "Name" => "Unidade",
      "Name_UK" => "Unit",

      "Sql" => "INT",
      "SqlClass" => "Units",
      "Search" => FALSE,
      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Unit",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Compulsory" => 1,
   ),
   "Event" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",
      
      "SqlClass" => "Events",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Name" => array
   (
      "Name" => "Título",
      "Title" => "Título",
      "Name_UK" => "Title",
      "Title_UK" => "Title",

      "Size" => "35",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Languaged"  => TRUE,
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "TimeLoad" => array
   (
      "Name" => "CH",
      "Title" => "CH Padrão",
      "Name_UK" => "Timeload",
      "Title_UK" => "Default Timeload",

      "Size" => "2",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default"  => 20,
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "CertText" => array
   (
      "Name" => "Texto, Cert",
      "Title" => "Texto, Certificado",
      "Name_UK" => "Text, Cert",
      "Title_UK" => "Text, Certificate",

      "Size" => "15",
      "Sql" => "VARCHAR(256)",
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Languaged"  => TRUE,
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
   "Inscriptions" => array
   (
      "Name" => "Inscrições",
      "Title" => "Colaboração Participa em Inscrições",
      "Name_UK" => "Inscriptions",
      "Title_UK" => "Collaboration Participates in Inscriptions",
      
      "Sql" => "ENUM",
      "Default" => 2,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Comment" => array
   (
      "Name" => "Comentário",
      "Name_UK" => "Comment",
      
      "Sql" => "VARCHAR(256)",
      "Size" => "30",
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
);
