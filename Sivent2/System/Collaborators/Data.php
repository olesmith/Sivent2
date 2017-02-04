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
      "Name" => "Usuário",
      "Name_UK" => "User",
      
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name","Email"),
      "GETSearchVarName"  => "Friend",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Collaboration" => array
   (
      "Name" => "Colaboração",
      "Name_UK" => "Collaboration",
      
      "SqlClass" => "Collaborations",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name"),
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
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
      "TabIndex" => 20,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Homologated" => array
   (
      "Name" => "Homologado",
      "Title" => "Colaboração Homologado",
      "Name_UK" => "Homologated",
      "Title_UK" => "Collaboration Homologated",

      "Default" => 1,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      
      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      "TabIndex" => 30,
      "SelectCheckBoxes"  => 3,

      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Name" => array
   (
      "Name" => "Nome",
      "Title" => "Nome",
      "Name_UK" => "Name",
      "Title_UK" => "Name",

      
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Certificate" => array
   (
      "Name" => "Certificado Liberado",
      "Name_UK" => "Certificate Avaliable",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,
      "TabIndex" => 40,
      "SelectCheckBoxes"  => 3,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Code" => array
   (
      "Name" => "Código",
      "Title" => "Código do Certificado",
      "Name_UK" => "Code",
      "Title_UK" => "Certificate Code",

      "Size" => "50",
      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
);
