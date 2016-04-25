array
(
   "System" => array
   (
       "Name" => "Sistema",
       "Name_UK" => "System",
       "Data" => array
       (
          "Name",
          "Email",
          "Password",
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 0,
       "Coordinator" => 1,
    ),
   
   "Basic" => array
   (
       "Name" => "Básicos",
       "Name_UK" => "Basic",
       "Data" => array
       (
          "Cell","Phone","Matricula","Titulation","Institution",
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 0,
   ),
   "Personal" => array
   (
       "Name" => "Dados Profissionais",
       "Name_UK" => "Professional Data",
       "Data" => array
       (
          "Address",
          "Institution","Position","Lattes",
	      "CNPq","Other","Which","Member"
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 0,
       "Coordinator" => 1,
    ),
   "Confirm" => array
   (
       "Name" => "Confirmação & Recuperação",
       "Name_UK" => "Confirmation & Recovery",
       "Data" => array
       (
          "CondEmail","ConfirmCode","RecoverCode","RecoverMTime"
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 0,
       "Coordinator" => 1,
    ),
);
