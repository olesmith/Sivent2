array
(
   'MailHead' => array
   (
      'Head' => 'Prezado(a) #Name',
      'Head_UK' => 'Dear #Name',
   ),
   'MailTail' => array
   (
      'Tail' => 
        "Atenciosamente,\n".
        "#Department\n".
        "#Institution",

      'Tail_UK' =>
        "Regards\n".
        "#Department\n".
        "#Institution",
   ),
   'ConfirmedMail' => array
   (
      'Subject' => 'Cadastro confirmado, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Registration confirmed, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Enviamos este email confirmando seu cadastro do #ApplicationName, #Unit_Title, #Institution.".
        "Para acessar seu cadastro, por favor utilize o link:\n\n".
        "#Href\n\n".
        "Utilizando o Login (Usuário):\n\n".
        "Usuário: #Email\n\n".
        "Se você não está conseguindo efetuar login, por favor, tente recuparar sua senha, acessando:\n\n".
        "#Href2.",

      'Body_UK' => 
        "We are sending you this mail in order to confirm you registration at #ApplicationName, #Unit_Title, #Institution.".
        "Please, access your registration, using the following link:\n\n".
        "#Href\n\n".
        "Using as Login:\n\n".
        "Usuário: #Email\n\n".
        "If you are unable to Login, please to recover your password, acessing:\n\n".
        "#Href2.",
   ),
   'ConfirmMail' => array
   (
      'Subject' => 'Envio de Código de Confirmação, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Registration confirm code, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Conforme solicitado em nosso site, enviamos o código de confirmação do cadastro no ".
        "#ApplicationName, #Unit_Title, #Institution.\n\n".
        "Para confirmar seu cadastro, por favor acesse o link:\n\n".
        "#Href1\n\n".
        "Se preferir, utilize o formulário de confirmação:\n\n".
        "#Href2,\n\n".
        "preenchendo os dados:\n\n".
        "Email: #CondEmail\n".
        "Código de Confirmação: #ConfirmCode",

      'Body_UK' => 
        "As solicited on our site, we are sending you the code needed to confirm you registry at #ApplicationName, #Unit_Title, #Institution.\n\n".
        "In order to complete your registration, please visit the link:\n\n".
        "#Href1\n\n".
        "Or if you prefer, use the confirmation form at:\n\n".
        "#Href2,\n\n".
        "using the following data:\n\n".
        "Email: #CondEmail\n".
        "Confirm Code: #ConfirmCode",
   ),
   'ResendConfirmMail' => array
   (
      'Subject' => 'Envio de Código de Confirmação, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Informing confirm code, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Conforme solicitado no nosso site, enviamos o código de confirmação do cadastro do #ApplicationName, #Unit_Title, #Institution\n".
        "\n".
        "Para confirmar seu cadastro, por favor acesse o link:\n\n".
        "#Href1\n\n".
        "Se prefere, utilize o formulário de confirmação:\n\n".
        "#Href2,\n\n".
        "preenchendo os dados:\n\n".
        "Email: #CondEmail\n".
        "Código de Confirmação: #ConfirmCode",

      'Body_UK' =>
        "As solicited on our site, we are hereby sending you the code needed to confirm you registry at\n\n".
        "#Institution\n\n".
        "In order to complete your registration, please visit the link:\n\n".
        "#Href1\n\n".
        "Or if you prefer, use the confirmation form at:\n\n".
        "#Href2,\n\n".
        "using the following credentials:\n\n".
        "Email: #CondEmail\n".
        "Confirm Code: #ConfirmCode",
   ),
   'ChangePassword' => array
   (
      'Subject' => 'Alteração de senha, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Password changes, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Confirmamos que sua senha foi alterada. Para acessar seu cadastro do #Institution, clique no link:\n\n".
        "#Href,\n\n".
        "utilizando as credenciais:\n\n".
        "Usuário: #Email\n\n".
        "Senha:   #Password",

      'Body_UK' => 
        "We hereby confirm, that your password has been altered. In order to access your registration use the following link:\n\n".
        "#Href,\n\n".
        "and the credentials:\n\n".
        "User: #Email\n".
        "Password: #Password",
   ),
   'ResendPassword' => array
   (
      'Subject' => 'Reenvio de senha, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Resending your password, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Conforme solicitado no nosso site, reenviamos credenciais para acessar seu cadastro do #ApplicationName, #Unit_Title, #Institution\n\n".
        "Usuário: #Email\n".
        "Senha: #Password\n\n".
        "Por favor, acesse seu cadastro, utilizando o seguinte link:\n\n".
        "#Href",

      'Body_UK' => 
        "As solicited on our site, we are hereby sending the credentials necessary to acess your registry at #ApplicationName, #Unit_Title, #Institution\n\n".
        "User: #Email\n".
        "Password: #Password\n\n".
        "Please use the following link to access your registration:\n\n".
        "#Href",
   ),
   'Inscribed' => array
   (
      'Subject' => 'Inscrição Efetuada, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Inscription Confirmation, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Conforme solicitado no nosso site, efetuamos sua inscrição para o Processo Seletivo no Programa de Pós-Graduação, ".
        "#Institution, Coordenação do Programa de Pós-Graduação, ".
        "#Unit_Name".
        ", conforme Edital ".
        "#Announcement_Name".
        "",

      'Body_UK' => 
        "Conforme solicitado no nosso site, efetuamos sua inscrição para o Processo Seletivo no Programa de Pós-Graduação, ".
        "#Institution, Coordenação do Programa de Pós-Graduação, ".
        "#Unit_Name".
        ", conforme Edital ".
        "#Announcement_Name".
        "",

   ),
   'SendPassword' => array
   (
      'Subject' => 'Cadastro de Usário Efetuada, #Institution',
      'Subject_UK' => 'User Registration Comitted, #Institution',
      'Body' => 
        "Conforme solicitado por #Login_Name, informamos seu Login e senha no SiMon/UFG:\n\n".
        "Acesso: #Href1\n\n".
        "Login: #Email\n".
        "Senha: #Password\n\n".
        "Recomendamos que que altere a senha no primeiro acesso. Informamos, que a senha pode ser recuperada usando o link:\n\n".
        "#Href2\n\n".
        "",

      'Body_UK' => 
        "Conforme solicitado no nosso site, efetuamos sua inscrição para o Processo Seletivo no Programa de Pós-Graduação, ".
        "#Institution, Coordenação do Programa de Pós-Graduação, ".
        "#Unit_Name".
        ", conforme Edital ".
        "#Announcement_Name".
        "",

   ),
   'Emails' => array
   (
      'Subject' => 'Mensagem, #ApplicationName, #Unit_Title, #Institution',
      'Subject_UK' => 'Message, #ApplicationName, #Unit_Title, #Institution',
      'Body' => 
        "Prezado(a)\n\n".
        "Mensagem do Administrador do #ApplicationName, #Unit_Title, #Institution",

      'Body_UK' =>
        "\n\n".
        "Message from Administrator off #ApplicationName, #Unit_Title, #Institution",
   ),
);
