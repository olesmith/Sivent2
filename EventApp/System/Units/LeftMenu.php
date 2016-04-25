array
(
   "0_Start" => array
   (
      "Name" => "Início",
      "Title" => "Start",
      "Name_UK" => "Start",
      "Title_UK" => "Start",

      'Href' => '?Unit=#Unit&Action=Start',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 1,
      'Coordinator' => 1,
      'Assessor'     => 1,
   ),
   "11_ShowUnit" => array
   (
      "Name" => "Unidade",
      "Title" => "Dados, Unidade Acadêmica",
      "Name_UK" => "Department",
      "Title_UK" => "Department",

      'Href' => '?Unit=#Unit&ModuleName=Units&Action=Show&ID=#Unit',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 0,

      "Friend"     => 1,
      'Coordinator' => 0,
      'Assessor'     => 1,
   ),
   "12_EditUnit" => array
   (
      "Name" => "Unidade",
      "Title" => "Dados, Unidade Acadêmica",
      "Name_UK" => "Department",
      "Title_UK" => "Department Data",

      'Href' => '?Unit=#Unit&ModuleName=Units&Action=Edit&ID=#Unit',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 0,
      'Coordinator' => 1,
      'Assessor'     => 0,
   ),
   "2_Friends" => array
   (
      "Name" => "Cadastros",
      "Title" => "Cadastros",
      "Name_UK" => "Registrations",
      "Title_UK" => "Registrations",

      'Href' => '?Unit=#Unit&ModuleName=Friends&Action=Search',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 0,
      'Coordinator' => 1,
      'Assessor'     => 0,
   ),
   "3_Events" => array
   (
      "Name" => "Editais",
      "Title" => "Editais",
      "Name_UK" => "Announcements",
      "Title_UK" => "Announcements",

      'Href' => '?Unit=#Unit&ModuleName=Events&Action=Search',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 0,
      'Coordinator' => 1,
      'Assessor'     => 0,
   ),
);
