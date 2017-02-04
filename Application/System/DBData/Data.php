array
(
   "ID" => array
   (
      "Name" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      //"Friend"     => 1,
      "Coordinator" => 1,
      //"Assessor"  => 1,
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
      //"Friend"     => 1,
      "Coordinator" => 1,
      //"Assessor"  => 1,
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
      //"Friend"     => 1,
      "Coordinator" => 1,
      //"Assessor"  => 1,
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
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Type" => array
   (
      "Name" => "HTML, Tipo",
      "Name_UK" => "HTML, Type",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Values" => array
      (
         "INPUT",
         "SELECT",
         "FILE",
         "RADIO",
         "CHECKBOX",
         "AREA",
         "PASSWORD",
         "INFO"
      ),
      "SQLDefault" => array
      (
         "VARCHAR(256)",
         "ENUM",
         "FILE",
         "ENUM",
         "ENUM",
         "TEXT",
         "VARCHAR(256)",
         "VARCHAR(256)",
      ),
      "NoSelectSort" => TRUE,

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
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
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "SqlKey" => array
   (
      "Name" => "SQL, Nome da Coluna",
      "Name_UK" => "SQL, Column Name",

      "Compulsory"  => TRUE,
      "Unique" => TRUE,
      "Search" => TRUE,
      "Size" => 20,
      "FieldMethod" => "SqlKeyField",
      "TriggerFunction" => "UpdateSqlKeyField",

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
      "Search"  => TRUE,
      "Compulsory"  => TRUE,
   ),
   "SqlDef" => array
   (
      "Name" => "SQL, Definição",
      "Name_UK" => "SQL, Definition",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Size" => 20,
      "FieldMethod" => "SqlDefField",
      //"TriggerFunction" => "UpdateSqlDefField",

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "SqlDefault" => array
   (
      "Name" => "SQL, Valor Padrão",
      "Name_UK" => "SQL, Default Value",

      "Compulsory"  => FALSE,
      "Search" => TRUE,
      "Size" => 20,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Text" => array
   (
      "Name" => "Nome",
      "Name_UK" => "Name",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Size" => 35,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Text_UK" => array
   (
      "Name" => "Nome (UK)",
      "Name_UK" => "Name (UK)",

      "Search" => TRUE,
      "Size" => 35,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Title" => array
   (
      "Name" => "Título",
      "Name_UK" => "Title",

      "Compulsory"  => TRUE,
      "Search" => TRUE,
      "Size" => 35,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Title_UK" => array
   (
      "Name" => "Título (UK)",
      "Name_UK" => "Title (UK)",

      "Search" => TRUE,
      "Size" => 35,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Compulsory" => array
   (
      "Name" => "Obrigatório",
      "Name_UK" => "Compulsory",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 1,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Friend" => array
   (
      "Name" => "Acesso, Candidato",
      "Name_UK" => "Access, Candidate",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 3,
      "Values" => array("Sem Acesso","Mostrar","Editar"),
      "Values_UK" => array("No Access","Read","Write"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Assessor" => array
   (
      "Name" => "Acesso, Avaliador",
      "Name_UK" => "Access, Assessor",

      "Search" => TRUE,
      "Compulsory"  => TRUE,
      "Default" => 2,
      "Values" => array("Sem Acesso","Mostrar","Editar"),
      "Values_UK" => array("No Access","Read","Write"),

      "Sql" => "ENUM",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "CSS" => array
   (
      "Name" => "CSS Class",
      "Name_UK" => "CSS Class",

      "Compulsory"  => FALSE,
      "Search" => TRUE,
      "Size" => 10,

      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Width" => array
   (
      "Name" => "Largura",
      "Name_UK" => "Width",

      "Compulsory"  => FALSE,
      "Search" => TRUE,
      "Size" => 2,
      "Default" => 10,

      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Height" => array
   (
      "Name" => "Altura",
      "Name_UK" => "Height",

      "Compulsory"  => FALSE,
      "Search" => TRUE,
      "Size" => 2,
      "Default" => 1,

      "Sql" => "VARCHAR(64)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "SValues" => array
   (
      "Name" => "Valores, ENUM",
      "Name_UK" => "Values, ENUM",

      "Compulsory"  => FALSE,
      "Search" => FALSE,
      "Size" => 30,

      "Sql" => "VARCHAR(2096)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "SValues_UK" => array
   (
      "Name" => "Valores, ENUM (UK)",
      "Name_UK" => "Values, ENUM (UK)",

      "Compulsory"  => FALSE,
      "Search" => FALSE,
      "Size" => 30,

      "Sql" => "VARCHAR(2096)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "Extensions" => array
   (
      "Name" => "Extensões Permitidos",
      "Name_UK" => "Permitted Extensions",

      "Compulsory"  => FALSE,
      "Search" => FALSE,
      "Size" => 30,

      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
   "DataGroup" => array
   (
      "Name" => "Grupo de Dados",
      "Name_UK" => "Data Group",

      "SqlClass" => "GroupDatas",
      "Search" => FALSE,
      "SqlDerivedData" => array("Text","Text_UK"),
      "GETSearchVarName"  => "GroupData",

      "Compulsory"  => FALSE,
      "Search" => TRUE,
      "Size" => 30,

      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      //"Friend"     => 1,
      "Coordinator" => 2,
      //"Assessor"  => 1,
   ),
);
