array
(
   "Title"     => array
   (
      "Sql" => "VARCHAR(256)",
      "Name"  => "Titulação",
      "Name_UK"  => "Titulation",
      "Title"  => "Titulação nas Citações",
      "Title_UK"  => "Titulation in Citations",
      "Size"  => 30,

      "Compulsory" => FALSE,

      "Admin" => 2,
      "Person" => 0,
      "Public" => 0,
      "Friend"     => 2,
      "Coordinator" => 2,
    ),
   "NickName"     => array
   (
      "Sql" => "VARCHAR(256)",
      "Name"  => "Apelido",
      "Name_UK"  => "Nick Name",
      "Title"  => "Nome na Comunidade",
      "Title_UK"  => "Community Name",
      "Size"  => 30,

      "Compulsory" => FALSE,

      "Admin" => 2,
      "Person" => 0,
      "Public" => 0,
      "Friend"     => 2,
      "Coordinator" => 2,
    ),
   "Curriculum"     => array
   (
      "Sql" => "VARCHAR(256)",
      "Name"  => "Curriculo (Link)",
      "Name_UK"  => "Curriculum (Link)",
      "Size"  => 50,

      "Compulsory" => FALSE,

      "Admin" => 2,
      "Person" => 0,
      "Public" => 0,
      "Friend"     => 2,
      "Coordinator" => 2,
      "HRefIt" => 1,
    ),
   "MiniCurriculum"     => array
   (
      "Sql" => "TEXT",
      "Name"  => "Mini Curriculo",
      "Name_UK"  => "Mini Curriculum",
      "Size"  => "50x10",

      "Compulsory" => FALSE,

      "Admin" => 2,
      "Person" => 0,
      "Public" => 0,
      "Friend"     => 2,
      "Coordinator" => 2,
    ),
   "Photo"     => array
   (
      "Sql" => "FILE",
      "Name"  => "Foto",
      "Name_UK"  => "Photo",
      "Size"  => "10",

      "Compulsory" => FALSE,

      "Admin" => 2,
      "Person" => 0,
      "Public" => 1,
      "Friend"     => 2,
      "Coordinator" => 2,
      "Iconify" => TRUE,
      "Extensions" => array("png","jpg"),
    ),
);