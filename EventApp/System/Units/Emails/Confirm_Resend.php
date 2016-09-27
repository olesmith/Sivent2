array
(
   "Name" => "Email de Confirmação, Reenvio",
   "Name_UK" => "Confirmation Mail, Resend",
   "Name_ES" => "Email de Confirmación, Reenvio",
   "Title" => "Email de Confirmação, Reenvio",
   "Title_UK" => "Confirmation Mail, Resend",
   "Title_ES" => "Email de Confirmación, Reenvio",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "BLOB",
      
      "Default"      => "#ApplicationName: Reenvio de Código de Confirmação, #Unit_Name, #Unit_Title",
      "Default_ES"      => "#ApplicationName: Reenvio de Código de Confirmación, #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Resending Confirmation Code, #Unit_Name, #Unit_Title",

      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
   "Body" => array
   (
      "Size" => "50x10",
      "Sql"          => "BLOB",
      
      "Default"      =>
        "Recebemos uma solicitação de reenvio de do código de confirmação. Para completar o cadastro, por favor acesse o link:\n\n".
        "#ConfirmLink\n\n".
        "Você também pode confirmar seu cadastro, através do link:\n\n".
        "#ConfirmLinkForm,\n\n".
        "informando seu email como login no sistema junto com o código de confirmação abaixo:\n\n".
        "Usuário: #Email\n".
        "Code de Confirmação: #ConfirmCode\n\n".
        "Para reenviar sua senha, por favor acesse:\n\n".
        "#ResendCodeLink\n\n"
      ,
      "Default_UK"   =>
       "We have received a solicitation to resend your confirmation code.  In order to complete your registration, please access the link:\n\n".
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
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
