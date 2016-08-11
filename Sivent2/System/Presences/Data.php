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
   "Event" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",
      
      "Sql" => "INT",
      "SqlClass" => "Events",
      "Search" => FALSE,
      "Compulsory"  => TRUE,

      "SqlDerivedData" => array("Name"),
      "GETSearchVarName"  => "Event",
      "Sql" => "INT",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Compulsory" => 1,
    ),
   "Name" => array
   (
      "Name" => "Nome",
      "Title" => "Name",
      "Name_UK" => "Nome",
      "Title_UK" => "Name",

      "Size" => "8",
      "Sql" => "VARCHAR(256)",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend" => 1,
      "Coordinator" => 1,
      
      "Search"  => TRUE,
   ),
   /* "Date" => array */
   /* ( */
   /*    "Name" => "Data", */
   /*    "Name_UK" => "Date", */
      
   /*    "Sql" => "INT", */
   /*    "SqlClass" => "Dates", */
   /*    "Search" => TRUE, */
   /*    "Compulsory"  => TRUE, */

   /*    "GETSearchVarName"  => "Date", */
   /*    "Sql" => "INT", */
   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 1, */
   /*    "Friend"     => 1, */
   /*    "Coordinator" => 1, */
   /*  ), */
   /* "Time" => array */
   /* ( */
   /*    "Name" => "Horário", */
   /*    "Title" => "Horário", */
   /*    "Name_UK" => "Time Slot", */
   /*    "Title_UK" => "Time Slot", */

   /*    "GETSearchVarName"  => "Time", */
      
   /*    "Sql" => "INT", */
   /*    "SqlClass" => "Times", */
   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 1, */
   /*    "Friend" => 1, */
   /*    "Coordinator" => 1, */
      
   /*    "Search"  => TRUE, */
   /* ), */
   /* "Place" => array */
   /* ( */
   /*    "Name" => "Local", */
   /*    "Title" => "Local", */
   /*    "Name_UK" => "Place", */
   /*    "Title_UK" => "Place", */
      
   /*    "GETSearchVarName"  => "Place", */

   /*    "Sql" => "INT", */
   /*    "SqlClass" => "Places", */
   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 1, */
   /*    "Friend" => 1, */
   /*    "Coordinator" => 1, */
      
   /*    "Search"  => TRUE, */
   /* ), */
   /* "Room" => array */
   /* ( */
   /*    "Name" => "Sala", */
   /*    "Title" => "Sala", */
   /*    "Name_UK" => "Room", */
   /*    "Title_UK" => "Room", */
      
   /*    "GETSearchVarName"  => "Room", */

   /*    "Sql" => "INT", */
   /*    "SqlClass" => "Rooms", */
   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 1, */
   /*    "Friend" => 1, */
   /*    "Coordinator" => 1, */
      
   /*    "Search"  => TRUE, */
   /* ), */
   /* "Submission" => array */
   /* ( */
   /*    "Name" => "Submissão", */
   /*    "Title" => "Submission", */
   /*    "Name_UK" => "Submissão", */
   /*    "Title_UK" => "Submission", */
      
   /*    "GETSearchVarName"  => "Submission", */
      
   /*    "Sql" => "INT", */
   /*    "SqlClass" => "Submissions", */
   /*    "Public"   => 1, */
   /*    "Person"   => 0, */
   /*    "Admin"    => 1, */
   /*    "Friend" => 1, */
   /*    "Coordinator" => 1, */
      
   /*    "Search"  => TRUE, */
   /* ), */
   "Schedule" => array
   (
      "Name" => "Slot",
      "Title" => "Time Slot",
      "Name_UK" => "Slot",
      "Title_UK" => "Time Slot",
      
      "GETSearchVarName"  => "Schedule",
      
      "Sql" => "INT",
      "SqlClass" => "Schedules",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
   ),
   "Friend" => array
   (
      "Name" => "Cadastro",
      "Title" => "Cadastro",
      "Name_UK" => "Registration",
      "Title_UK" => "Registration",
      
      "GETSearchVarName"  => "Friend",


      "Sql" => "INT",
      "SqlClass" => "Friends",
      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 1,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
   ),
);
