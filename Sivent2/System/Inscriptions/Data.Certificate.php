array
(
   "Certificate" => array
   (
      "Name" => "Certificado Liberado",
      "Name_UK" => "Certificate Published",

      "Sql" => "ENUM",

      "Search" => FALSE,
      "Values" => array("Não","Sim"),
      "Values_UK" => array("No","Yes"),
      "Default"  => 1,
      "SelectCheckBoxes"  => 2,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificate_CH" => array
   (
      "Name" => "Certificado CH",
      "Name_UK" => "Certificate TimeLoad",

      "Sql" => "VARCHAR(8)",
      "Size" => 2,

      "Search" => FALSE,
      "Regexp" => '^\d+$',

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
);
