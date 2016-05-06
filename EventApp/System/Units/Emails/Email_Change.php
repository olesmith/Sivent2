array
(
   "Name" => "Email de Alteração de Endereço Eletrònico, Solicitação",
   "Name_UK" => "Change Email Address Mail, Solicitation",
   "Title" => "Email de Alteração de Endereço Eletrònico, Solicitação",
   "Title_UK" => "Change Email Address Mail, Solicitation",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Alterar de Endereço Eletrônico, #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Email Address Change, #Unit_Name, #Unit_Title",

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
          "Prezado(a) #Name\n\n".
          "Recebemos um pedido de alteração de email (utilizado como login em #ApplicationName).\n\n".
          "Para proseguir com este alteração, efetue login no #ApplicationName, acesse o link ".
          "'Alterar Email' no menu esquerdo, e preenche os dados:\n\n".
          "Email: #Email\n".
          "Novo Email: #NewEmail\n".
          "Código de Confirmação: #RecoverCode\n\n".
          "Atenciosamente,"
      ,
      "Default_UK"   =>
          "We have received a solicitation of changing the email (used as login name in #ApplicationName).\n\n".
          "In order to proceed with the alteration, please login to #ApplicationName and access the link ".
          "'Change Email' in the left menu, and provide the information below:\n\n".
          "Email: #Email\n".
          "New Email: #NewEmail\n".
          "Confirmation Code: #RecoverCode\n\n".
          "Regards,"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
