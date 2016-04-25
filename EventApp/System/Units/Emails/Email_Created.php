array
(
   "Name" => "Cadastro de Usuário Efetuado",
   "Name_UK" => "Informing User Registration",
   "Title" => "Cadastro de Usuário Efetuado",
   "Title_UK" => "Informing User Registration",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Cadastro de Usário Efetuada, #Unit_Title, #Institution",
      "Default_UK"   => "#ApplicationName: Informing User Registration, #Unit_Title, #Institution",

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
        "Informamos seu Login e senha no #ApplicationName foram cadastrados.\n\n".
        "Acesso: #Href1\n\n".
        "Login: #Email\n".
        "Senha: #Password\n\n".
        "É recomendável alterar a senha no primeiro acesso. Para esse fim use o link:\n\n".
        "#Href2"
      ,
      "Default_UK"   =>
        "We hereby inform you, that you have been registered in #ApplicationName.\n\n".
        "Access: #Href1\n\n".
        "Login: #Email\n".
        "Password: #Password\n\n".
        "We recomend that you change your password upon first logon. Please access:\n\n".
        "#Href2"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
