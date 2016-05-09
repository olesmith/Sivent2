array
(
   "1_ShowUnit" => array
   (
      "Name" => "Unidade",
      "Title" => "Dados, Unidade Acadêmica",
      "Name_UK" => "Department",
      "Title_UK" => "Department",

      'Href' => '?Unit=#Unit&ModuleName=Units&Action=Show&ID=#Unit',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 1,
      'Coordinator' => 1,
      'Assessor'     => 1,
   ),
   "2_Friends" => array
   (
      "Name" => "Cadastros",
      "Title" => "Cadastros",
      "Name_UK" => "Registrations",
      "Title_UK" => "Registrations",

      'Href' => '?Unit=#Unit&ModuleName=Friends&Action=Search',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 0,
      'Coordinator' => 1,
      'Assessor'     => 0,
   ),
   "3_Events" => array
   (
      "Name" => "Eventos",
      "Title" => "Eventos",
      "Name_UK" => "Events",
      "Title_UK" => "Events",

      'Href' => '?Unit=#Unit&ModuleName=Events&Action=Search',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      "Friend"     => 1,
      'Coordinator' => 1,
      'Assessor'     => 1,
   ),
   "4_Permissions" => array
   (
      "Name" => "Permissões",
      "Title" => "Gerenciar Permissões",
      "Name_UK" => "Permissions",
      "Title_UK" => "Manage Permissions",

      'Href' => '?Unit=#Unit&ModuleName=Permissions&Action=Search',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   '5_Uploads' => array
   (
      'Name' => 'Uploads',
      'Title' => 'Gerenciar Uploads',
      'Href' => '?Unit=#Unit&Action=Uploads',

      'Public'   => 0,
      'Person'   => 0,
      'Admin'    => 1,
      "Monitor"     => 0,
      "Coordinator" => 1,
      "Advisor"  => 0,
   ),
);
