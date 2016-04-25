array
(
   "Name" => "Email de Confirmação, Reenvio",
   "Name_UK" => "Confirmation Mail, Resend",
   "Title" => "Email de Confirmação, Reenvio",
   "Title_UK" => "Confirmation Mail, Resend",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Reenvio de Código de Confirmação, #Unit_Title, #Institution",
      "Default_UK"   => "#ApplicationName: Resending Confirmation Code, #Unit_Title, #Institution",

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
        "Conforme solicitado no nosso site, enviamos o código de confirmação do cadastro do #Institution\n".
        "\n".
        "Para confirmar seu cadastro, por favor acesse o link:\n\n".
        "#Href1\n\n".
        "Se prefere, utilize o formulário de confirmação:\n\n".
        "#Href2,\n\n".
        "preenchendo os dados:\n\n".
        "Email: #CondEmail\n".
        "Código de Confirmação: #ConfirmCode."
      ,
      "Default_UK"   =>
        "As solicited on our site, we are hereby sending you the code needed to confirm you registry at\n\n".
        "#Institution\n\n".
        "In order to complete your registration, please visit the link:\n\n".
        "#Href1\n\n".
        "Or if you prefer, use the confirmation form at:\n\n".
        "#Href2,\n\n".
        "using the following credentials:\n\n".
        "Email: #CondEmail\n".
        "Confirm Code: #ConfirmCode."
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
