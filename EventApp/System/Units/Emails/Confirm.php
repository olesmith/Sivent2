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
      
      "Default"      => "#ApplicationName: Cadastro confirmado, #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Registration confirmed, #Unit_Name, #Unit_Title",

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
      "Enviamos este email para confirmar seu cadastro no #ApplicationName, #Unit_Name, #Unit_Title.\n\n".
      "Para acessar seu cadastro, por favor utilize o link\n\n".
      "#LoginLink\n\n".
      "Utilizando o Credencial:\n\n".
      "Usuário: #Email\n\n".
      "e a senha cadastrado no início deste cadastro.\n\n".
      "Se você não está conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n".
      "#RecoverPasswordLink\n"
      ,
      "Default_UK"      =>
      "We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Name, #Unit_Title.\n\n".
      "Please, access your registration, using the following link:\n\n".
      "#LoginLink\n\n".
      "Using as Login:\n\n".
      "User: #Email,\n\n".
      "along with the password used initiating this registration.\n\n".
      "If you are unable to Login, please try to recover your password, acessing:\n\n".
      "#RecoverPasswordLink\n\n"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
