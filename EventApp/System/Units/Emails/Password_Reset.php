array
(
   "Name" => "Email de Alteração de Senha",
   "Name_UK" => "Change Password Mail",
   "Title" => "Email de Confirmação",
   "Title_UK" => "Confirmation Email",
   
   "Data" => array("Subject","Body"),
   "Data_UK" => array("Subject_UK","Body_UK"),
   
   "Subject" => array
   (
      "Size" => "50",
      "Sql"          => "TEXT",
      
      "Default"      => "#ApplicationName: Recuperação de Senha, #Unit_Name, #Unit_Title",
      "Default_UK"   => "#ApplicationName: Recover Password, #Unit_Name, #Unit_Title",

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
       "Recebemos uma solicitação de recuperar a senha do login (email) #Email. ".
      "Em baixo inlcuimos um código gerado aleatóriamente, permitindo a alteração da senha, ".
      "por favor acesse este link:\n\n".
      "#RecoverLink\n\n".
      "Ao completar a alteração, você receberá um email informativo pelo sistema.\n\n"
      ,

      
      "Default_UK"   =>
      "We have received a solicitation to recover login to the account (email) #Email. ".
      "Below we include a randomnly generated code, permitting you to change the password accessing:\n\n".
      "#RecoverLink\n\n".
      "Completing the alteration, you will receive an informative email by the system.\n\n"
      ,
      
      "Public"   => 0,
      "Person"   => 1,
      "Friend"    => 1,
      "Admin"    => 2,
      "Coordinator" => 2,
   ),
);
