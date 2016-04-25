array
(
   "Name" => "Email de Confirmação do Cadastro",
   "Name_UK" => "Mail Confirming Registration",
   "Title" => "Email de Confirmação",
   "Title_UK" => "Mail Confirming Registration",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Cadastro confirmado, #Unit_Title, #Institution",
      "Default_UK"   => "#ApplicationName: Registration confirmed, #Unit_Title, #Institution",

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
        "Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Title, #Institution. ".
        "Para acessar seu cadastro, por favor utilize o link:\n\n".
        "#Href\n\n".
        "Utilizando o Login (Usuário):\n\n".
        "Usuário: #Email\n\n".
        "Se você não está conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n".
        "#Href2."
      ,
      "Default_UK"   =>
        "We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution. ".
        "Please, access your registration, using the following link:\n\n".
        "#Href\n\n".
        "Using as Login:\n\n".
        "Usuário: #Email\n\n".
        "If you are unable to Login, please to recover your password, acessing:\n\n".
        "#Href2."
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
