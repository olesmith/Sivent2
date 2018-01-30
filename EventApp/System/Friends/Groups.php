array
(
   "Default" => array
   (
       "Name" => "Default",
       "Data" => array
       (
          "No","Show","Edit",
          "Volatile","City","Name","Email","Phone","Cell",
          "CTime","MTime"
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 1,
    ),
   "Curriculums" => array
   (
       "Name" => "Currículos",
       "Name_UK" => "Curriculumns",
       "Data" => array
       (
           "Edit","Name","NickName","Titulation","Email","Lattes","Curriculum"
       ), 

       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 1,
   ),
   "UnConfirmed" => array
   (
       "Name" => "Cadastros não Confirmadas",
       "Name_UK" => "Unconfirmed",
       "Data" => array
       (
        "Edit","Name","Email","CondEmail","ConfirmCode","ATime","MTime",
       ),
       "SqlWhere" => "CondEmail NOT LIKE ''",
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 1,
   ),
   "Confirmed" => array
   (
       "Name" => "Cadastros Confirmadas",
       "Name_UK" => "Confirmed",
       "Data" => array
       (
           "Edit","Name","Email","Type",
       ),
       "SqlWhere" => "Email NOT LIKE ''",
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 1,
   ),
   "Common" => array
   (
       "Name" => "Comum",
       "Data" => array
       (
          "No","Show","Edit","Delete","Groups",
          "Volatile","Name","Email","Phone","Cell",
          "CTime","MTime"
       ), 
       "Admin" => 1,
       "Person" => 0,
       "Public" => 0,

       "Friend" => 1,
       "Coordinator" => 1,
    ),
);
