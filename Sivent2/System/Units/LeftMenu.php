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

      'Friend'     => 1,
      'Coordinator' => 1,
      'Assessor'     => 1,
   ),
   "11_ShowUnit" => array
   (
      "Name" => "Entidade",
      "Title" => "Dados, Entidade",
      "Name_UK" => "Entity",
      "Title_UK" => "Entity Data",

      'Href' => '?Unit=#Unit&ModuleName=Units&Action=Show&ID=#Unit',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 0,

      'Friend'     => 1,
      'Coordinator' => 0,
      'Assessor'     => 1,
   ),
   "12_EditUnit" => array
   (
      "Name" => "Dados da Entidade",
      "Title" => "Gerenciar Dados da Entidade",
      "Name_UK" => "Entity Data",
      "Title_UK" => "Edit Entity Data",

      'Href' => '?Unit=#Unit&ModuleName=Units&Action=Edit&ID=#Unit',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
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

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "3_Events" => array
   (
      "Name" => "Eventos",
      "Title" => "Gerenciar Eventos",
      "Name_UK" => "Events",
      "Title_UK" => "Manage Events",

      'Href' => '?Unit=#Unit&ModuleName=Events&Action=Search',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "41_Certificates" => array
   (
      "Name" => "Certificados",
      "Title" => "Certificates",
      "Name_UK" => "Certificados",
      "Title_UK" => "Certificates",

      'Href' => '?Unit=#Unit&ModuleName=Certificates&Action=Search',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "42_Certificates" => array
   (
      "Name" => "Validar Certificados",
      "Title" => "Validate Certificates",
      "Name_UK" => "Validar",
      "Title_UK" => "Validate",

      'Href' => '?Unit=#Unit&ModuleName=Certificates&Action=Validate',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "5_Permissions" => array
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
   "6_Sponsors" => array
   (
      "Name" => "Patrocinadores",
      "Title" => "Gerenciar Patrocinadores",
      "Name_UK" => "Sponsors",
      "Title_UK" => "Manage Sponsors",

      'Href' => '?Unit=#Unit&ModuleName=Sponsors&Action=Search',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
);
