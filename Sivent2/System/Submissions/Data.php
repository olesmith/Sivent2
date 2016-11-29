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
      
      "Compulsory" => TRUE,
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
      "AccessMethod" => "Submission_Authors_May_Show",
    ),
   "Author1" => array
   (
    //Author names MUST come before Friend data
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
      ///"AccessMethod" => "Submission_Authors_May_Show",
   ),
   "Friend" => array
   (
      "Name" => "Cadastro, Autor",
      "Name_UK" => "Registration, Author",

      "Sql" => "INT",

      "SqlClass" => "Friends",
      "Search" => TRUE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "TriggerFunction" => "UpdateSpeaker",
   ),
   "Author2" => array
   (
      "Name" => "Coautor #1",
      "Name_UK" => "Coauthor #1",

      "Sql" => "VARCHAR(256)",
      "Search" => FALSE,

      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
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
      "TriggerFunction" => "UpdateSpeaker",
   ),
   "Author3" => array
   (
      "Name" => "Coautor #2",
      "Name_UK" => "Coauthor #2",

      "Sql" => "VARCHAR(256)",
      "Search" => FALSE,

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
      "TriggerFunction" => "UpdateSpeaker",
   ),
   "Name" => array
   (
      "Name" => "Identificador",
      "Name_ES" => "Identificador",
      "Name_UK" => "Identifier",

      "Sql" => "VARCHAR(256)",

      "Compulsory" => FALSE,
      "Search" => TRUE,
      "Size" => 3,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Status" => array
   (
      "Name" => "Status",
      "Name_UK" => "Status",

      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Aguardando Avaliação","Deferido","Indeferido"),
      "Values_UK" => array("Awaiting Assessment","Selected","Refused"),
      "Default"  => 1,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Title" => array
   (
      "Name" => "Título",
      "Name_ES" => "Titulo",
      "Name_UK" => "Title",

      "Sql" => "VARCHAR(256)",

      "Compulsory" => TRUE,
      "Search" => TRUE,
      "Size" => 35,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   /* "Title_UK" => array */
   /* ( */
   /*    "Name" => "Título (UK)", */
   /*    "Name_UK" => "Title", */

   /*    "Sql" => "VARCHAR(256)", */

   /*    "Search" => FALSE, */
   /*    "Size" => 35, */

   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 2, */
   /*    "Friend"     => 2, */
   /*    "Coordinator" => 2, */
   /*    "Assessor"  => 0, */
   /* ), */
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
   "PreInscriptions" => array
   (
      "Name" => "Preinscrições",
      "Name_UK" => "Preinscriptions",
      "Title" => "Preinscrições para este Atividade",
      "Title_UK" => "Preinscriptions for this Activity",
      
      "Sql" => "ENUM",

      "Search" => TRUE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Values_ES" => array("No","Si"),
      "Default"  => 1,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
   ),
   "Vacancies" => array
   (
      "Name" => "Vagas",
      "Name_UK" => "Vacancies",
      "Title" => "No. Vargas",
      "Title_UK" => "No. Vacancies",


      "Sql" => "INT",
      "Regexp" => "^\d+$",
      "Default" => 40,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
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
      "Compulsory" => TRUE,
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

      "Public"   => 0,
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

      "Public"   => 0,
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

      "Search" => TRUE,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
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

      "Public"   => 0,
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

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   
   "Keywords" => array
   (
      "Name" => "Palavras Chaves",
      "Name_UK" => "Keywords",

      "Sql" => "VARCHAR(256)",

      "Search" => TRUE,
      "Size" => "50",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "Compulsory" => TRUE,
   ),
   "Summary" => array
   (
      "Name" => "Resumo",
      "Name_UK" => "Summary",

      "Sql" => "VARCHAR(1048)",

      "Search" => FALSE,
      "Size" => "50x5",

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "Compulsory" => TRUE,
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
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Result" => array
   (
      "Name" => "Resultado",
      "Title" => "Resultado da Avaliação",
      "Name_UK" => "Result",
      "Title_UK" => "Assessment Result",

      "Sql" => "REAL",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
      "Format"  => "%.1f",
   ),
);
