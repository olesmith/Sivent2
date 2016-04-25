array
(
   "Name" => "Email de Alteração de Endereço Eletrònico",
   "Name_UK" => "Change Email Address Mail",
   "Title" => "Email de Alteração de Endereço Eletrònico",
   "Title_UK" => "Change Email Address Mail",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Alteração de Endereço Eletrônico, #Unit_Title, #Institution",
      "Default_UK"   => "#ApplicationName: Email Address Change, #Unit_Title, #Institution",

      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
   "Body" => array
   (
      "Size" => "50x10",
      "Sql"          => "TEXT",
      
      "Default"      =>
        "Conforme solicitado no nosso site, enviamos link para verificar a alteração do seu endereço eletrônico:\n\n".
        "#Href"
      ,
      "Default_UK"   =>
        "As solicited on our site, we are hereby sending link for changing your email:\n\n".
        "#Href"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
