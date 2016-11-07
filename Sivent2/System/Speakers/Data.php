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

      "Public"   => 0,
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
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Compulsory" => 1,
    ),
   "Friend" => array
   (
      "Name" => "Cadastro",
      "Name_UK" => "Registration",
      
      "SqlClass" => "Friends",
      "Sql" => "INT",
      
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name","Email"),
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Name" => array
   (
      "Name" => "Nome",
      "Title" => "Nome do Palestrante",
      "Name_UK" => "Name",
      "Title_UK" => "Speaker's Name",

      "Size" => "25",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 0,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
   ),
    "Confirmed" => array
   (
      "Name" => "Confirmado pelo Autor",
      "Name_UK" => "Confirmed by Author",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Values_ES" => array("No","Si"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "PermsMethod" => "Submission_Confirm_Should",
   ),
  "Carrier" => array
   (
      "Name" => "Empresa",
      "Name_UK" => "Carrier",
      "Title" => "Empresa Resp. da Viagem",
      "Title_UK" => "Carrier",


      "Sql" => "VARCHAR(256)",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,

      "Search" => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Origin" => array
   (
      "Name" => "Origem",
      "Name_UK" => "Origin",

      "Sql" => "VARCHAR(256)",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,

      "Search" => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Hotel" => array
   (
      "Name" => "Hotel",
      "Name_UK" => "Hotel",

      "Sql" => "VARCHAR(256)",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,

      "Search" => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Allocated" => array
   (
      "Name" => "Alocado na Grade",
      "Name_UK" => "Scheduled",

      "Sql" => "ENUM",
      "Values"    => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),
      "Values_ES" => array("Si","No"),

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,

      "Default"  => 1,
      "Compulsory"  => FALSE,
   ),
   "Other" => array
   (
      "Name" => "Outras Informações",
      "Name_UK" => "Other Info",

      "Sql" => "VARCHAR(256)",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,

      "Search" => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Confirmed" => array
   (
      "Name" => "Confirmo Presença",
      "Name_UK" => "I Confirm Presence",
      "Name_ES" => "Confirmo Presencia",

      "Sql" => "ENUM",
      "Values"    => array("Não","Sim",),
      "Values_UK" => array("No","Yes",),
      "Values_ES" => array("No","Si",),

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,

      "Default"  => 1,
      "Compulsory"  => FALSE,
   ),
);
