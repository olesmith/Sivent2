array
(
   "Name" => "Cadastro de Usuário Efetuado",
   "Name_ES" => "Registro del Usuário Efetuado",
   "Name_UK" => "Informing User Registration",
   "Title" => "Cadastro de Usuário Efetuado",
   "Title_ES" => "Registro del Usuário Efetuado",
   "Title_UK" => "Informing User Registration",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "BLOB",
      
      "Default"      => "#ApplicationName: Cadastro de Usário Efetuada, #Unit_Name, #Unit_Title",
      "Default_ES"      => "#ApplicationName: Registro del Usário Efetuada, #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Informing User Registration, #Unit_Name, #Unit_Title",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"    => 0,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
   "Body" => array
   (
      "Size" => "50x10",
      "Sql"          => "BLOB",
      
      "Default"      =>
      "Enviamos este email, para confirmar seu cadastro do #ApplicationName, #Unit_Name, #Unit_Title.\n\n".
      "Para acessar seu cadastro, por favor utilize o link:\n\n".

      "#LoginLink\n\n".

      "Utilizando os Credencias:\n\n".

      "Usuário: #Email\n".
      "Senha: #Password\n\n".
      "Se você não está conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n".
      "#RecoverLoginLink.\n\n".
      "Recomandamos a alteração da senha no primeiro acesso ao sistema"
      ,
      "Default_UK"   =>
      "We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Name, #Unit_Title.\n\n".
      "Please, access your registration, using the following link:\n\n".
      "#LoginLink\n\n".
      "Providing the following credentials:\n\n".
      "Usuário: #Email\n".
      "Senha: #Password\n\n".
      "If you are unable to Login, please to recover your password, acessing:\n\n".
      "#RecoverLoginLink.\n\n"
      ,
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"    => 0,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
