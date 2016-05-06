array
(
   "Name" => "Email de Alteração de Endereço Eletrònico, Confirmação",
   "Name_UK" => "Change Email Address Mail, Confirmation",
   "Title" => "Email de Alteração de Endereço Eletrònico, Confirmação",
   "Title_UK" => "Change Email Address Mail, Confirmation",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Alteração de Endereço Eletrônico, #Unit_Name, #Unit_Title",
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
          "Conforme solicitado, o pedido de alteração de email (login) foi efetuado:\n\n".
          "Email Antigo: #OldEmail\n".
          "Novo Email: #Email\n\n".
          "Atenciosamente,"
      ,
      "Default_UK"   =>
          "As solicitaded, the Email (login) change request has been carried out.\n\n".
          "Old Email: #OldEmail\n".
          "Email: #Email\n\n".
          "Regards,"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
