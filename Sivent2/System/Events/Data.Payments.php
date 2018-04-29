array
(     
   "Payments" => array
   (
      "Name" => "Taxa de Inscrição",
      "Name_UK" => "Paid Event",
      "Title" => "Evento Pago?",
      "Title_UK" => "Paid Event?",
      "Sql" => "ENUM",
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => "1",
      "SelectCheckBoxes"  => 2,

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Type" => array
   (
      "Name" => "Forma de Pagamento",
      "Name_UK" => "Way of Payment",
      "Sql" => "ENUM",
      "Values" => array
      (
          "Depôsito Bancária",
          "PagSeguro",
      ),
      "Values_UK" => array
      (
          "Bank Deposit",
          "PagSeguro",
      ),
      "Default"  => "1",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_URL" => array
   (
      "Name" => "Informações do Pagamento (URL)",
      "Name_UK" => "Payment Information (URL)",
      "Sql" => "VARCHAR(64)",
      "Size"  => "50",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Info" => array
   (
      "Name" => "Mensagem",
      "Name_UK" => "Message",
      "Sql" => "VARCHAR(256)",
      "Size"  => "50x4",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Institution" => array
   (
      "Name" => "Instituição Financeira do Depósito",
      "Name_UK" => "Deposit Financial Institution",
      "Sql" => "VARCHAR(64)",
      "Size"  => "50",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Name" => array
   (
      "Name" => "Favorecido",
      "Name_UK" => "In Favor",
      "Sql" => "VARCHAR(64)",
      "Size"  => "50",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Agency" => array
   (
      "Name" => "Agência do Depósito",
      "Name_UK" => "Deposit Agency",
      "Sql" => "VARCHAR(64)",
      "Size"  => "6",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Operation" => array
   (
       "Name" => "Operação",
      "Name_UK" => "Operation",
      "Sql" => "VARCHAR(64)",
      "Size"  => "3",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_Account" => array
   (
      "Name" => "Conta do Depósito",
      "Name_UK" => "Deposit Account",
      "Sql" => "VARCHAR(64)",
      "Size"  => "10",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   
   "Payments_Variation" => array
   (
      "Name" => "Variação",
      "Name_UK" => "Variation",
      "Sql" => "VARCHAR(64)",
      "Size"  => "3",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_PagSeguro_Login" => array
   (
      "Name" => "Usuário PagSeguro",
      "Name_UK" => "User PagSeguro",
      "Sql" => "VARCHAR(64)",
      "Size"  => "35",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
   "Payments_PagSeguro_Code" => array
   (
      "Name" => "Token PagSeguro",
      "Name_UK" => "Token PagSeguro",
      "Sql" => "VARCHAR(64)",
      "Size"  => "35",

      "Public"   => 1,
      "Person"   => 1,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 1,
      "Search"  => FALSE,
   ),
 );
