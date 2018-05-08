array
(
   "Type" => array
   (
      "Name" => "Tipo de Inscrição",
      "Name_UK" => "Inscription Type",

      "Sql" => "INT",
      "SqlClass" => "Types",


      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Search" => TRUE,
      "Compulsory" => TRUE,
   ),
   "Lot" => array
   (
      "Name" => "Lote",
      "Name_UK" => "Lot",

      "Sql" => "INT",
      "SqlClass" => "Lots",


      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Search" => TRUE,
      "PermsMethod" => "Inscriptions_Payment_Data_Access",
   ),
   "Has_Paid" => array
   (
      "Name" => "Confirmado",
      "Name_UK" => "Confirmed",
      "Title" => "Pagamento Confirmado",
      "Title_UK" => "Inscription Fee Confirmed",

      "Sql" => "ENUM",

      "Values" => array("Não","Sim","Isento"),
      "Values_UK" => array("No","Yes","Exonerated"),
      "Default"  => 1,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Search" => TRUE,
      "TriggerFunction" => "Inscription_Payment_Update_Register",
   ),
   "Date_Paid" => array
   (
      "Name" => "Data",
      "Name_UK" => "Date",
      "Title" => "Data do Pagamento",
      "Title_UK" => "Fee Paid Date",

      "Sql" => "INT",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Search" => FALSE,
      "IsDate" => TRUE,
      "PermsMethod" => "Inscriptions_Payment_Data_Access",
   ),
   "Value_Nominal" => array
   (
      "Name" => "Valor Nominal",
      "Name_UK" => "Nominal Value",

      "Sql" => "REAL",
      "Format"   => "%.02f",
      "Size"   => 2,
      
      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Search" => FALSE,
   ),
   "Value_Paid" => array
   (
      "Name" => "Valor",
      "Name_UK" => "Value",
      "Title" => "Valor Pago",
      "Title_UK" => "Value Paid",

      "Sql" => "REAL",
      "Format"   => "%.02f",
      "Size"   => 4,

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Search" => FALSE,
      "PermsMethod" => "Inscriptions_Payment_Data_Access",
   ),
   "Receit_Paid" => array
   (
      "Name" => "Recibo",
      "Name_UK" => "Receit",
      "Title" => "Recibo do Pagamento",
      "Title_UK" => "Payment Receit",

      "Sql" => "FILE",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Extensions" => array("pdf","jpg","jpeg","png"),
   ),
   "PagSeguro_Code" => array
   (
      "Name" => "Code (PagSeguro)",
      "Name_UK" => "Code (PagSeguro)",

      "Sql" => "VARCHAR(256)",

      "Public"   => 0,
      "Person"   => 0,
      "Admin"    => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
   ),
);
