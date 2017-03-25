array
(
   "Status" => array
   (
      "Name" => "Status",
      "ShortName" => "Status",
      "Title" => "Status",
      
      "Sql" => "ENUM",
      "Values" => array("Aguardando Início das Inscrições","Inscrições Abertas","Inscrições Encerradas"),
      "Values_UK" => array("Awaiting Inscriptions to Open","Inscriptions Open","Inscriptions Closed"),
      "Values_ES" => array("Aguardando Inicio de las Inscriciones","Inscriciones Abiertas","Inscriciones Encerradas"),
      "SearchDefault"   => 0,
      "Default"   => 2,
      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 1,
      "Search"  => TRUE,
      "SearchCheckBox"  => FALSE,
   ),
    "Visible" => array
   (
      "Name" => "Visível",
      "Name_UK" => "Visible",

      "Sql" => "ENUM",
      "Values" => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),
      "Default" => 1,
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 0,
      "Coordinator" => 1,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => FALSE,
   ),
   
   "EventStart" => array
   (
      "Name" => "Início do Evento",
      "ShortName" => "Início",
      "Title" => "Data Início do Evento",
      
      "Name_UK" => "Event Start",
      "ShortName_UK" => "Start",
      "Title_UK" => "Event Start Date",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "EventEnd" => array
   (
      "Name" => "Fim do Evento",
      "ShortName" => "Fim",
      "Title" => "Data Fim do Evento",
      
      "Name_UK" => "Event End",
      "ShortName_UK" => "End",
      "Title_UK" => "Event End Date",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Compulsory" => 1,
      "Search" => FALSE,
      "Compulsory"  => TRUE,
      "IsDate"  => TRUE,
   ),
   "Place" => array
   (
      "Name" => "Local do Evento",
      "Name_UK" => "Place where Event Occurs",

      "Sql" => "VARCHAR(256)",
      "Size" => 50,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "Compulsory"  => TRUE,
   ),
   "Place_Address" => array
   (
      "Name" => "Endereço do Local",
      "Name_UK" => "Place Address",

      "Sql" => "VARCHAR(256)",
      "Size" => 50,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "Compulsory"  => TRUE,
   ),
   "Place_Site" => array
   (
      "Name" => "Site do Local",
      "Name_UK" => "Place Site",

      "Sql" => "VARCHAR(256)",
      "Size" => 50,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
      "Compulsory"  => TRUE,
      "Iconify"  => TRUE,
   ),
   "Info" => array
   (
      "Name" => "Informações",
      "Name_UK" => "Informations",
      "Sql" => "TEXT",
      "Size" => "50x10",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Schedule_Public" => array
   (
      "Name" => "Grade Publicado",
      "Name_UK" => "Schedule Public",
      "SelectCheckBoxes"  => 2,

      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default" => 1,
      
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Default" => 1,
      "Compulsory" => FALSE,
      "Search" => FALSE,
      "Compulsory"  => FALSE,
   ),
   
);
