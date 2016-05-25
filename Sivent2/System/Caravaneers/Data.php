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
      "Search" => TRUE,
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
      "Name" => "Coordenador",
      "Name_UK" => "Coordinator",
      
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name","Email"),
      "GETSearchVarName"  => "Coordinator",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Name" => array
   (
      "Name" => "Nome",
      "Title" => "Nome",
      "Name_UK" => "Name",
      "Title_UK" => "Name",

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
   "Email" => array
   (
      "Name" => "Email",
      "Title" => "Email",
      "Name_UK" => "Email",
      "Title_UK" => "Email",

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
   "PRN" => array
   (
      "Name" => "RG",
      "Title" => "RG",
      "Name_UK" => "PRN",
      "Title_UK" => "PRN",

      "Size" => "15",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Status" => array
   (
      "Name" => "Status",
      "Title" => "Status",
      "Name_UK" => "Status",
      "Title_UK" => "Status",

      "Values" => array("OK","Email Vazio","Email mal Formatado","Email Existente"),
      "Values_UK" => array("OK","Empty Email","Malformed Email","Existente Email"),
      "Default"  => "0",
      "NoSelectSort"  => TRUE,
      
      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Registration" => array
   (
      "Name" => "Cadastro",
      "Name_UK" => "Registration",
      
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "SqlDerivedData" => array("Name","Email"),
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
   "Certificate" => array
   (
      "Name" => "Certificado Liberado",
      "Name_UK" => "Certificate Avaliable",

      "Sql" => "ENUM",

      "Search" => FALSE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,

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
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
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
