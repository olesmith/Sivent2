array
(
   "ID" => array
   (
      "Admin" => "1",
      "Coordinator" => "1",
      "Friend" => "1",
      "Name" => "ID",
      "Name_ES" => "ID",
      "Name_UK" => "ID",
      "Person" => "0",
      "Public" => "1",
      "ShortName" => "ID",
      "ShortName_ES" => "ID",
      "ShortName_UK" => "ID",
      "Sql" => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
      "Title" => "ID",
      "Title_ES" => "ID",
      "Title_UK" => "ID",
   ),
   "Unit" => array
   (
      "Admin" => "1",
      "Compulsory" => "1",
      "Coordinator" => "1",
      "Friend" => "1",
      "GETSearchVarName" => "Unit",
      "Name" => "Entidade",
      "Name_ES" => "Entidade",
      "Name_UK" => "Entity",
      "Person" => "0",
      "Public" => "1",
      "Search" => "",
      "ShortName" => "Entidade",
      "ShortName_ES" => "Entidade",
      "ShortName_UK" => "Entity",
      "Sql" => "INT",
      "SqlClass" => "Units",
      "SqlDerivedData" => array("Name"),
      "Title" => "Entidade",
      "Title_ES" => "Entidade",
      "Title_UK" => "Entity",
   ),
   "Event" => array
   (
      "Admin" => "2",
      "Compulsory" => "1",
      "Coordinator" => "1",
      "Friend" => "1",
      "GETSearchVarName" => "Event",
      "Name" => "Evento",
      "Name_ES" => "Evento",
      "Name_UK" => "Event",
      "Person" => "0",
      "Public" => "1",
      "Search" => "",
      "ShortName" => "Evento",
      "ShortName_ES" => "Evento",
      "ShortName_UK" => "Event",
      "Size" => "20",
      "Sql" => "INT",
      "SqlClass" => "Events",
      "SqlDerivedData" => array("Name"),
      "Title" => "Evento",
      "Title_ES" => "Evento",
      "Title_UK" => "Event",
   ),
   "Friend" => array
   (
      "Admin" => "2",
      "Compulsory" => "1",
      "Coordinator" => "1",
      "Friend" => "1",
      "GETSearchVarName" => "Friend",
      "Name" => "Cadastro",
      "Name_ES" => "Registro",
      "Name_UK" => "Registration",
      "Person" => "0",
      "Public" => "1",
      "Search" => "1",
      "ShortName" => "Cadastro",
      "ShortName_ES" => "Registro",
      "ShortName_UK" => "Registration",
      "Size" => "20",
      "Sql" => "INT",
      "SqlClass" => "Friends",
      "Title" => "Cadastro",
      "Title_ES" => "Registro",
      "Title_UK" => "Registration",
   ),
   "Name" => array
   (
      "Admin" => "1",
      "Compulsory" => "1",
      "Coordinator" => "1",
      "Friend" => "1",
      "Name" => "Nome",
      "Name_ES" => "Nombre",
      "Name_UK" => "Name",
      "Person" => "0",
      "Public" => "1",
      "Search" => "1",
      "Size" => "20",
      "Sql" => "VARCHAR(256)",
   ),
   "Status" => array
   (
      "Admin" => "1",
      "Assessor" => "0",
      "Coordinator" => "1",
      "Default" => "2",
      "Friend" => "1",
      "Name" => "Status",
      "Name_ES" => "Status",
      "Name_UK" => "Status",
      "Person" => "0",
      "Public" => "1",
      "Search" => True,
      "ShortName" => "Status",
      "ShortName_ES" => "Status",
      "ShortName_UK" => "Status",
      "Sql" => "ENUM",
      "Title" => "Status",
      "Title_ES" => "Status",
      "Title_UK" => "Status",
      "Values" => array("Não Inscrito","Inscrito"),
      "Values_UK" => array("Not Inscribed","Inscribed"),
   ),
   "Complete" => array
   (
      "Admin" => "1",
      "Assessor" => "0",
      "Coordinator" => "1",
      "Default" => "1",
      "Friend" => "1",
      "Name" => "Dados Completos",
      "Name_ES" => "Dados Completos",
      "Name_UK" => "Data Complete",
      "Person" => "0",
      "Public" => "1",
      "Search" => True,
      "ShortName" => "Completa",
      "ShortName_ES" => "Completa",
      "ShortName_UK" => "Complete",
      "Sql" => "ENUM",
      "Title" => "Dados Completos",
      "Title_ES" => "Dados Completos",
      "Title_UK" => "Data Complete",
      
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
   ),
   "Homologated" => array
   (
      "Admin" => "2",
      "Assessor" => "0",
      "Coordinator" => "2",
      "Default" => "1",
      "Friend" => "1",
      "Name" => "Homologado",
      "Name_ES" => "Homologado",
      "Name_UK" => "Homologated",
      "Person" => "0",
      "Public" => "1",
      "Search" => "1",
      "ShortName" => "Homologado",
      "ShortName_ES" => "Homologado",
      "ShortName_UK" => "Homologated",
      "Sql" => "ENUM",
      "Title" => "Homologado",
      "Title_ES" => "Homologado",
      "Title_UK" => "Homologated",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
   ),
   "Score" => array
   (
      "Admin" => "2",
      "Assessor" => "0",
      "Coordinator" => "2",
      "Friend" => "1",
      "Name" => "Resultado",
      "Name_ES" => "Resultado",
      "Name_UK" => "Result",
      "Person" => "0",
      "Public" => "1",
      "Search" => "",
      "ShortName" => "Resultado",
      "ShortName_ES" => "Resultado",
      "ShortName_UK" => "Result",
      "Size" => "3",
      "Sql" => "VARCHAR(256)",
      "Title" => "Resultado",
      "Title_ES" => "Resultado",
      "Title_UK" => "Result",
   ),
   "Selected" => array
   (
      "Admin" => "2",
      "Assessor" => "0",
      "Coordinator" => "2",
      "Default" => "1",
      "Friend" => "1",
      "Name" => "Selecionado",
      "Name_ES" => "Selecionado",
      "Name_UK" => "Selected",
      "Person" => "0",
      "Public" => "1",
      "Search" => "1",
      "ShortName" => "Selecionado",
      "ShortName_ES" => "Selecionado",
      "ShortName_UK" => "Selected",
      "Sql" => "ENUM",
      "Title" => "Selecionado",
      "Title_ES" => "Selecionado",
      "Title_UK" => "Selected",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      #"SelectCheckBoxes" => "3",
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
);

