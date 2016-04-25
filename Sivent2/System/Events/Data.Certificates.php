array
(     
   "Certificates" => array
   (
      "Name" => "Certificados",
      "Name_UK" => "Certificates",

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
   "Certificates_Published" => array
   (
      "Name" => "Certificados Liberados",
      "Name_UK" => "Certificates Published",

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
      "Assessor"  => 0,
   ),
   "Certificates_CH" => array
   (
      "Name" => "Certificados, CH Padrão",
      "Name_UK" => "Certificates, Default TimeLoad",

      "Sql" => "VARCHAR(8)",
      "Default" => "10",
      "Size" => 2,
      "Regexp" => '^\d+$',

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),

   

   "Certificates_Watermark" => array
   (
      "Name" => "Marca de Agua",
      "Name_UK" => "Watermark",

      "Sql" => "FILE",
      "Extensions" => array("png","jpg"),
      "Default" => "10",
      "Iconify" => TRUE,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),

   
   "Certificates_Signature_1" => array
   (
      "Name" => "Assinatura #1",
      "Name_UK" => "Signature #1",

      "Sql" => "FILE",
      "Extensions" => array("png","jpg"),
      "Default" => "10",
      "Iconify" => TRUE,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_1_Text1" => array
   (
      "Name" => "Assinatura #1, Responsável",
      "Name_UK" => "Signature #1, Responsible",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_1_Text2" => array
   (
      "Name" => "Assinatura #1, Função",
      "Name_UK" => "Signature #1, Function",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   
   "Certificates_Signature_2" => array
   (
      "Name" => "Assinatura #2",
      "Name_UK" => "Signature #2",

      "Sql" => "FILE",
      "Extensions" => array("png","jpg"),
      "Default" => "10",
      "Iconify" => TRUE,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_2_Text1" => array
   (
      "Name" => "Assinatura #2, Responsável",
      "Name_UK" => "Signature #2, Responsible",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_2_Text2" => array
   (
      "Name" => "Assinatura #2, Função",
      "Name_UK" => "Signature #2, Function",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),

   
   "Certificates_Signature_3" => array
   (
      "Name" => "Assinatura #3",
      "Name_UK" => "Signature #3",

      "Sql" => "FILE",
      "Extensions" => array("png","jpg"),
      "Default" => "10",
      "Iconify" => TRUE,

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_3_Text1" => array
   (
      "Name" => "Assinatura #3, Responsável",
      "Name_UK" => "Signature #3, Responsible",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Signature_3_Text2" => array
   (
      "Name" => "Assinatura #3, Função",
      "Name_UK" => "Signature #3, Function",

      "Sql" => "VARCHAR(256)",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
   "Certificates_Latex" => array
   (
      "Name" => "Latex",

      "Sql" => "TEXT",
      "Size" => "100x20",

      "Search" => FALSE,

      "Public"   => 1,
      "Person"   => 0,
      "Admin"    => 2,
      "Friend"     => 1,
      "Coordinator" => 2,
      "Assessor"  => 0,
   ),
);
