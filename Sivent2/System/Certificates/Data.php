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
      "Name" => "Entidade",
      "Name_UK" => "Entity",

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
      "Name" => "Cadastro",
      "Name_UK" => "Registration",
      "SqlClass" => "Friends",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "GETSearchVarName"  => "Friend",
      "Size" => "20",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Inscription" => array
   (
      "Name" => "Inscrição",
      "Name_UK" => "Inscription",
      "SqlClass" => "Inscriptions",
      "Search" => TRUE,
      "Compulsory"  => TRUE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Name" => array
   (
      "Name" => "Destinatário",
      "Name_UK" => "Destined to",
      "Title" => "Destinatário do Certificado",
      "Title_UK" => "Certificate Destined to",

      "Size" => "50",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
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
      "Compulsory"  => TRUE,
   ),
   "Type" => array
   (
      "Name" => "Tipo",
      "Title" => "Tipo do Certificado",
      "Name_UK" => "Type",
      "Title_UK" => "Certificate Type",

      "Size" => "50",
      "Sql" => "ENUM",
      "Values" => array("Participante","Participante de Caravana","Colaborador","Palestrante"),
      "Values_UK" => array("Participant","Caravaneer","Collaborator","Speaker"),
      "Default" => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "Generated" => array
   (
      "Name" => "Gerado",
      "Title" => "Certificado Gerado",
      "Name_UK" => "Generated",
      "Title_UK" => "Certificate Generated",

      "Sql" => "INT",
      "Search" => FALSE,
      "ReadOnly" => TRUE,
      "AdminReadOnly" => TRUE,
      "TimeType" => TRUE,
      "Default" => 0,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
   "Mailed" => array
   (
      "Name" => "Enviado",
      "Title" => "Certificado Enviado",
      "Name_UK" => "Mailed",
      "Title_UK" => "Certificate Mailed",

      "Sql" => "INT",
      "Search" => FALSE,
      "ReadOnly" => TRUE,
      "AdminReadOnly" => TRUE,
      "TimeType" => TRUE,
      "Default" => 0,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
);
