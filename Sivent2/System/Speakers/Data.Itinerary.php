array
(
   "Transport" => array
   (
      "Name" => "Meio de Viagem",
      "Name_UK" => "Travel By",
      "Name_ES" => "Viaje por",
      "Title" => "Meio de Viagem",
      "Title_UK" => "Travel By",
      "Title_ES" => "Viaje por",

      "Sql" => "ENUM",
      "Values"    => array("Conta Própria","Avião","Ônibus","Trem","Carro","Outro"),
      "Values_UK" => array("By Own Means","Air","Bus","Train","Car","Other"),
      "Values_ES"    => array("Própria Cuenta ","Avion","Onibus","Tren","Coche","Outro"),
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Date" => array
   (
      "Name" => "Data de Viagem",
      "Name_UK" => "Travel Date",
      "Title" => "Data de Viagem",
      "Title_UK" => "Travel Date",

      "Sql" => "INT",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "IsDate"  => TRUE,
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "Hour" => array
   (
      "Name" => "Hora de Viagem",
      "Name_UK" => "Travel Date",
      "Title" => "Hora de Viagem",
      "Title_UK" => "Travel Date",

      "Sql" => "VARCHAR(16)",
      "Size" => 4,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Regexp"  => '\d\d?(:\d\d?)',
      "Search"  => TRUE,
      "Compulsory"  => FALSE,
   ),
   "CarrierID" => array
   (
      "Name" => "No. Vôo, Ônibus ou outro",
      "Name_UK" => "No. Flight, Bus or other",
      "Title" => "Vôo, Ônibus ou outro",
      "Title_UK" => "Flight, Bus or other",

      "Sql" => "VARCHAR(16)",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
      
      "Search"  => FALSE,
      "Compulsory"  => FALSE,
   ),
   "Transfer" => array
   (
      "Name" => "Traslado",
      "Name_UK" => "Transfer",
      "Title" => "Traslado",
      "Title_UK" => "Transfer",

      "Sql" => "ENUM",
      "Values"    => array("Sim","Não"),
      "Values_UK" => array("Yes","No"),

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend" => 2,
      "Coordinator" => 2,
   ),
   "Collaborator" => array
   (
      "Name" => "Colaborador",
      "Name_UK" => "Collaborator",
      "Title" => "Colaborador",
      "Title_UK" => "Collaborator",
      
      "SqlClass" => "Friends",
      "Sql" => "INT",
      "Search" => TRUE,
      "Compulsory"  => FALSE,

      "SqlDerivedData" => array("Name","Email","Phone","Cell"),
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
    ),
 );
