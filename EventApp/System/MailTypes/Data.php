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
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Compulsory" => 1,
   ),
   "Language" => array
   (
      "Name" => "Idioma",
      "Name_UK" => "Language",
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "Size" => "2",
      "Sql" => "VARCHAR(4)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Name" => array
   (
      "Name" => "Tipo",
      "Title" => "Tipo Mail",
      "Name_UK" => "Type",
      "Title_UK" => "Mail Type",

      "Size" => "50",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Subject" => array
   (
      "ShortName"    => "Assunto",
      "ShortName_UK" => "Subject",
      "Name"         => "Assunto",
      "Name_UK"      => "Subject",
      "Title"        => "Assunto dos Emails",
      "Title_UK"     => "Email Subjects",
      
      "Default"      => "",
      "Default_UK"   => "",
      
      "Size" => "50",
      "Sql" => "TEXT",
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
   "Body" => array
   (
      "ShortName"    => "Corpo",
      "ShortName_UK" => "Body",
      "Name"         => "Corpo",
      "Name_UK"      => "Body",
      "Title"        => "Corpo dos Email",
      "Title_UK"     => "Email Body",
      
      "Default"      => "",
      "Default_UK"   => "",
      
      "Size" => "50x25",
      "Sql" => "TEXT",
      
      "Public"   => 0,
      "Friend"    => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
 );
