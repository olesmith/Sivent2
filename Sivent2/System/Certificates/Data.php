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
      "Values" => array("Participante","Participante de Caravana","Colaborador","Palestrante","Coordenador de Caravana",),
      "Values_UK" => array("Participant","Caravaneer","Collaborator","Speaker","Caravan Coordinator"),
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
   "Inscription" => array
   (
      "Name" => "Inscrição",
      "Name_UK" => "Inscription",
      "SqlClass" => "Inscriptions",

      "Search" => TRUE,
      "Search_Depends" => "Event",
      "SqlTables_Regex"  => "#Unit__\d+__Inscriptions",
      
      "Compulsory"  => FALSE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Submission" => array
   (
      "Name" => "Submissão",
      "Name_UK" => "Submission",
      "SqlClass" => "Submissions",
      
      "Search" => TRUE,
      "Search_Depends" => "Event",
      "Search_Vars" => array("Unit","Event"),
      
      "Compulsory"  => FALSE,
      //"SqlTables_Regex"  => "#Unit__\d+__Submissions",

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Collaborator" => array
   (
      "Name" => "Colaborador",
      "Name_UK" => "Collaborator",
      "SqlClass" => "Collaborators",
      
      "Search" => TRUE,
      "Search_Depends" => "Event",
      "Search_Vars" => array("Unit","Event"),
      
      //"SqlTables_Regex"  => "#Unit__\d+__Collaborations",
  
      "Compulsory"  => FALSE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Collaboration" => array
   (
      "Name" => "Colaboração",
      "Name_UK" => "Collaboration",
      "SqlClass" => "Collaborations",
      
      "Search" => TRUE,
      "Search_Depends" => "Event",
      "Search_Vars" => array("Unit","Event"),
      
      //"SqlTables_Regex"  => "#Unit__\d+__Collaborations",
  
      "Compulsory"  => FALSE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Caravaneer" => array
   (
      "Name" => "Caravaneiro",
      "Name_UK" => "Caravaneer",
      "SqlClass" => "Caravaneers",
      
      "Search" => TRUE,
      "Search_Depends" => "Event",
      "Search_Vars" => array("Unit","Event"),
      
      //"SqlTables_Regex"  => "#Unit__\d+__Caravaneers",

      "Compulsory"  => FALSE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "Caravan" => array
   (
      "Name" => "Caravana",
      "Name_UK" => "Caravan",
      "SqlClass" => "Caravans",
      
      "Search" => TRUE,
      "Search_Depends" => "Event",
      "Search_Vars" => array("Unit","Event"),
      
      //"SqlTables_Regex"  => "#Unit__\d+__Caravaneers",

      "Compulsory"  => FALSE,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
   "TimeLoad" => array
   (
      "Name" => "CH",
      "Title" => "Carga Horario",
      "Name_UK" => "Timeload",
      "Title_UK" => "Timeload",

      "Size" => "2",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
      //"AccessMethod" => "Inscriptions_Certificates_May",
      "TabIndex"  => 5,
   ),
);
