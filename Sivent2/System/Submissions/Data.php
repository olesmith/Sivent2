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
      "Name" => "Cadastro, Autor",
      "Name_UK" => "Registration, Author",

      "Sql" => "INT",

      "SqlClass" => "Friends",
      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Author1" => array
   (
      "Name" => "Autor Proponente",
      "Name_UK" => "Proponent Author",

      "Sql" => "VARCHAR(256)",

      "Size" => 35,
      "Search" => TRUE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   "Friend2" => array
   (
      "Name" => "Cadastro, Coautor #1",
      "Name_UK" => "Registration, Coautor #1",

      "Sql" => "INT",

      "SqlClass" => "Friends",
      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Author2" => array
   (
      "Name" => "Coautor #1",
      "Name_UK" => "Coauthor #1",

      "Sql" => "VARCHAR(256)",
      "Search" => TRUE,

      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Author3" => array
   (
      "Name" => "Coautor #2",
      "Name_UK" => "Coauthor #2",

      "Sql" => "VARCHAR(256)",
      "Search" => TRUE,

      "Size" => 50,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Friend3" => array
   (
      "Name" => "Cadastro, Coautor #2",
      "Name_UK" => "Registration, Coautor #2",

      "Sql" => "INT",

      "SqlClass" => "Friends",
      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Title" => array
   (
      "Name" => "Título",
      "Name_UK" => "Title (PT)",

      "Sql" => "VARCHAR(256)",

      "Compulsory" => TRUE,
      "Search" => TRUE,
      "Size" => "35",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Title_UK" => array
   (
      "Name" => "Título (UK)",
      "Name_UK" => "Title",

      "Sql" => "VARCHAR(256)",

      "Search" => TRUE,
      "Size" => "50",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Type" => array
   (
      "Name" => "Tipo",
      "Name_UK" => "Type",

      "Sql" => "TEXT",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Palestra","Minicurso","Oficina"),
      "Values_UK" => array("Talk","Minicourse","Workshop"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   "Area" => array
   (
      "Name" => "Trilha",
      "Name_UK" => "Area of Interest",

      "Sql" => "INT",

      "SqlClass" => "Areas",
      "Search" => TRUE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Level" => array
   (
      "Name" => "Nível",
      "Name_UK" => "Level",

      "Sql" => "TEXT",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Iniciante","Intermediário","Avançada"),
      "Values_UK" => array("Basic","Intermediate","Advanced"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   
   "Need_Projector" => array
   (
      "Name" => "Precisa Datashow",
      "Name_UK" => "Needs Projector",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 2,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
  "Need_Computer" => array
   (
      "Name" => "Precisa Computer",
      "Name_UK" => "Needs Computer",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
  "Need_Other" => array
   (
      "Name" => "Outras Necesidade",
      "Name_UK" => "Other Necessities",

      "Sql" => "VARCHAR(256)",
      "Size" => 35,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
   ),
   "Status" => array
   (
      "Name" => "Selecionado",
      "Name_UK" => "Selected",

      "Sql" => "ENUM",

      "Search" => FALSE,
      "Values" => array("Aguardando Avaliação","Deferido","Indeferido"),
      "Values_UK" => array("Awaiting Assessment","Selected","Refused"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
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
   "Certificate_TimeLoad" => array
   (
      "Name" => "Certificado CH",
      "Name_UK" => "Certificate TimeLoad",

      "Sql" => "VARCHAR(8)",
      "Size" => 2,

      "Search" => FALSE,
      "Regexp" => '^\d+$',
      "Default" => 2,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   
   "Summary" => array
   (
      "Name" => "Resumo",
      "Name_UK" => "Summary",

      "Sql" => "VARCHAR(1048)",

      "Search" => TRUE,
      "Size" => "50x5",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "File" => array
   (
      "Name" => "Arquivo Disponibilizado",
      "Name_UK" => "File",

      "Sql" => "FILE",

      "Search" => FALSE,
      "Extensions" => array("pdf"),

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
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
