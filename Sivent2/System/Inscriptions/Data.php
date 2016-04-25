array
(
   "Name" => array
   (
      "Name" => "Nome",
      "Name_UK" => "Name",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 0,
   ),
   "SortName" => array
   (
      "Name" => "Nome",
      "Name_UK" => "Name",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 0,
   ),
   "Email" => array
   (
      "Name" => "Email",
      "Name_UK" => "Email",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 0,
   ),
   "Homologated" => array
   (
      "Name" => "Homologado",
      "Name_UK" => "Homologated",

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
      "Assessor"  => 0,
   ),
   "Score" => array
   (
      "Name" => "Resultado (Numérico)",
      "Name_UK" => "Result (Numeric)",

      "Sql" => "VARCHAR(256)",
      "Size" => 3,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Selected" => array
   (
      "Name" => "Selecionado",
      "Name_UK" => "Selected",

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
      "Assessor"  => 0,
   ),
   "Comment" => array
   (
      "Name" => "Comentário",
      "Name_UK" => "Comment",

      "Sql" => "TEXT",

      "Search" => FALSE,
      "Size" => "50x3",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Code" => array
   (
      "Name" => "Código",
      "Name_UK" => "Code",

      "Sql" => "VARCHAR(64)",

      "Search" => FALSE,
      "Size" => "50x3",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 0,
   ),
);
