array
(
   "ID" => array
   (
      "Name" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 1,
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
      "Compulsory"  => TRUE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 1,
      "Compulsory" => 1,
   ),
   "Event" => array
   (
      "Name" => "Processo",
      "Name_UK" => "Process",
      "SqlClass" => "Events",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Size" => "20",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 1,
   ),
   "SortOrder" => array
   (
      "Name" => "Ordem",
      "Name_UK" => "Sort Order",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Size" => 2,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Pertains" => array
   (
      "Name" => "Pertence",
      "Name_UK" => "Pertains to",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Default" => 1,
      "NoSelectSort" => TRUE,

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Text" => array
   (
      "Name" => "Título",
      "Name_UK" => "Title",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Size" => 20,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Text_UK" => array
   (
      "Name" => "Título (UK)",
      "Name_UK" => "Title (UK)",

      "Search" => TRUE,
      "Size" => 20,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Friend" => array
   (
      "Name" => "Acesso, Cadastrante",
      "Name_UK" => "Access, Friend",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 1,
      "Values" => array("Sem Acesso","Mostrar","Editar"),
      "Values_UK" => array("No Access","Read","Write"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Singular" => array
   (
      "Name" => "Singular",
      "Name_UK" => "Singular",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 1,
      "Values" => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
   "Plural" => array
   (
      "Name" => "Plural",
      "Name_UK" => "Plural",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 1,
      "Values" => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
   ),
);
