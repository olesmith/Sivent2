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
      "EmptyName" => "Todos Eventos",
      "EmptyName_UK" => "All Events",
      
      "SqlClass" => "Events",
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Type" => array
   (
      "Name" => "Tipo",
      "Name_UK" => "Type",
      "Title" => "Tipo de Coordenador",
      "Title_UK" => "Coordinator Type",
      "EmptyName" => "Todos",
      "EmptyName_UK" => "All",
      
      //always add to these lists!
      "Values" => array
      (
         "Evento",
         "Inscrições",
         "Colaborações",
         "Caravanas",
         "Submissões",
         "PreInscrições",
         "Presenças",         
         "Pagamentos",         
         "Patrocinadores",         
      ),
      "Values_UK" => array
      (
         "Event",
         "Inscriptions",
         "Collaborations",
         "Caravans",
         "Submissions",
         "PreInscriptions",
         "Presences",         
         "Payments",         
         "Sponsors",         
      ),
      
      "Default" => "0 ",
      
      "NoSelectSort" => TRUE,
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "User" => array
   (
      "Name" => "Usuário",
      "Name_UK" => "User",
      
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "SqlWhere"  => array("Profile_Coordinator" => 2),

      "SqlDerivedData" => array("Name","Email"),
      "GETSearchVarName"  => "User",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
   "Comment" => array
   (
      "Name" => "Comentário",
      "Title" => "Comentário",
      "Name_UK" => "Comment",
      "Title_UK" => "Comment",

      "Size" => "35",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
);
