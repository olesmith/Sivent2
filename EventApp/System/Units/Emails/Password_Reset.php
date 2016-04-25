array
(
   "Name" => "Email de Alteração de Senha",
   "Name_UK" => "Change Password Mail",
   "Title" => "Email de Confirmação",
   "Title_UK" => "Confirmation Email",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Recuperação de Senha, #Unit_Title, #Institution",
      "Default_UK"   => "#ApplicationName: Recover Password, #Unit_Title, #Institution",

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
        "Conforme solicitado no nosso site, enviamos link para a recuperar sua senha:\n\n".
        "#Href"
      ,
      "Default_UK"   =>
        "As solicited on our site, we are hereby sending link for recovering your password:\n\n".
        "#Href"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
