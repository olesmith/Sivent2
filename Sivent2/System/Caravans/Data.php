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
   "Friend" => array
   (
      "Name" => "Coordenador(a)",
      "Title" => "Coordenador(a) da Caravana",
      
      "Name_UK" => "Coordinator",
      "Title_UK" => "Caravan Coordinator",
      "Sql" => "INT",
      "SqlClass" => "Friends",
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search" => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Status" => array
   (
      "Name" => "Status",
      "Name_UK" => "Status",

      "Sql" => "ENUM",
      "Values" => array("Ativo","Cancelado"),
      "Values_UK" => array("Active","Cancelled"),
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Search" => TRUE,
   ),
   "Homologated" => array
   (
      "Name" => "Homologado",
      "Name_UK" => "Homologated",

      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Search" => TRUE,
   ),
   "Name" => array
   (
      "Name" => "Nome da Caravana",
      "Name_UK" => "Caravan Name",

      "Sql" => "VARCHAR(256)",
      "Size" => 25,

      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   "City" => array
   (
      "Name" => "Cidade",
      "Title" => "Cidade",
      "Name_UK" => "City",
      "Title_UK" => "City",

      "Size" => "30",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "NParticipants" => array
   (
      "Name" => "No. de Participantes",
      "Name_UK" => "No. of Participants",

      "Sql" => "INT",


      "Default" => "0 ",
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Certificate" => array
   (
      "Name" => "Certificado Liberado",
      "Name_UK" => "Certificate Published",

      "Sql" => "ENUM",

      "Search" => FALSE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,
      "SelectCheckBoxes"  => 3,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificate_CH" => array
   (
      "Name" => "Certificado CH",
      "Name_UK" => "Certificate TimeLoad",

      "Sql" => "VARCHAR(8)",
      "Size" => 2,

      "Search" => FALSE,
      "Regexp" => '^\d+$',

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
);
