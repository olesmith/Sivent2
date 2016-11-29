array
(
   "Name" => "Email Inicial de Cadastro",
   "Name_ES" => "Email Inicial del Registro",
   "Name_UK" => "Initial Registration Mail",
   "Title" => "Email Inicial de Cadastro",
   "Title_UK" => "Initial Registration Mail",
   "Title_ES" => "Email Inicial del Registro",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "BLOB",
      
      "Default"      => "#ApplicationName: Código de Confirmação,  #Unit_Name, #Unit_Title",
      "Default_ES"      => "#ApplicationName: Código de Confirmación,  #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Confirmation Code, #Unit_Name, #Unit_Title",

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
      "Recebemos uma solicitação de cadastro em #ApplicationName, #Unit_Name, #Unit_Title. ".
      "Para completar o cadastro, precisamos verificar que você controla este email. ".
      "Para neste fim, por favor acesse o link:\n\n".
      "#ConfirmLink\n\n".
      "Você também pode confirmar seu cadastro, através do link:\n\n".
      "#ConfirmLinkForm\n\n".
      "informando seu email como login no sistema junto com o código de confirmação abaixo:\n\n".
      "Usuário: #Email\n".
      "Code de Confirmação: #ConfirmCode\n\n".
      "Para reenviar sua senha, por favor acesse:\n\n".
      "#ResendCodeLink\n"
      ,
      "Default_UK"   =>
      "We have received a solicitation of registration in #ApplicationName, #Unit_Name, #Unit_Title. ".
      "In order to complete your registration, we need to confirm that you controle this email addres. ".
      "To do that, please access the link:\n\n".
      "#ConfirmLink\n\n".
      "You may also complete your registration, acessing:\n\n".
      "#ConfirmLinkForm\n\n".
      "providing the following information:\n\n".
      "User: #Email\n".
      "Confirmation Code: #ConfirmCode\n\n".
      "If needed, you may have the current confirmation code resent, please use:\n\n".
      "#ResendCodeLink\n\n"
      ,
      "Public"   => 0,
      "Person"   => 0,
      "Friend"    => 0,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
