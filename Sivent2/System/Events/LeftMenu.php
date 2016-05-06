array
(
   "01_ShowEvent" => array
   (
      "Name" => "Sobre o Evento",
      "Title" => "Informações do Evento",
      "Name_UK" => "About the Event",
      "Title_UK" => "Event Info",

      'Href' => '?Unit=#Unit&ModuleName=Events&Action=Show&Event=#Event',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 0,

      'Friend'     => 1,
      'Coordinator' => 0,
   ),
   "01_EditEvent" => array
   (

      "Name" => "Dados do Evento",
      "Title" => "Editar Dados do Evento",
      "Name_UK" => "Event Data",
      "Title_UK" => "Edit Event Data",

       'Href' => '?Unit=#Unit&ModuleName=Events&Action=Edit&Event=#Event',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "021_Inscription" => array
   (
      "Name" => "Inscrição",
      "Title" => "Minha Inscrição",
      "Name_UK" => "Inscription",
      "Title_UK" => "My Inscription",

      'Href' => '?Unit=#Unit&ModuleName=Inscriptions&Action=Inscription&Event=#Event',

      'AccessMethod'    => "FriendIsInscribed",
      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 0,

      'Friend'     => 1,
      'Coordinator' => 0,
   ),
   "022_Inscriptions" => array
   (
      "Name" => "Inscrições",
      "Title" => "Inscrições do Evento",
      "Name_UK" => "Inscriptions",
      "Title_UK" => "Event Inscriptions",

      'Href' => '?Unit=#Unit&ModuleName=Inscriptions&Action=Search&Event=#Event',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "021_Certificates" => array
   (
      "Name" => "Presenças e Certificados",
      "Name_UK" => "Presences and Certificates",

      'Href' => '?Unit=#Unit&ModuleName=Inscriptions&Action=EditList&Event=#Event&Inscriptions_GroupName=Certificates',
      'AccessMethod' => 'HasCertificates',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "030_Collaborations" => array
   (
      "Name" => "Colaborações",
      "Title" => "Colaborações",
      "Name_UK" => "Collaborations",
      "Title_UK" => "Collaborations",

      'Href' => '?Unit=#Unit&ModuleName=Collaborations&Action=Search&Event=#Event',
      'AccessMethod' => 'HasCollaborations',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "031_Collaborators" => array
   (
      "Name" => "Colaboradores",
      "Title" => "Colaboradores",
      "Name_UK" => "Collaborators",
      "Title_UK" => "Collaborators",

      'Href' => '?Unit=#Unit&ModuleName=Collaborators&Action=Search&Event=#Event',
      'AccessMethod' => 'HasCollaborations',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "04_Caravaneers" => array
   (
      "Name" => "Caravaneiro(a)s",
      "Title" => "Gerenciar Caravaneiro(a)s",
      "Name_UK" => "Caravaneers",
      "Title_UK" => "Manage Caravaneers",

      'Href' => '?Unit=#Unit&ModuleName=Caravaneers&Action=Search&Event=#Event',
      'AccessMethod' => 'HasCaravans',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "05_Areas" => array
   (
      "Name" => "Trilhas",
      "Title" => "Gerenciar Trilhas",
      "Name_UK" => "Areas of Interest",
      "Title_UK" => "Manage Areas of Interest",

      'Href' => '?Unit=#Unit&ModuleName=Areas&Action=Search&Event=#Event',
      'AccessMethod' => 'HasSubmissions',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "061_Submissions" => array
   (
      "Name" => "Submissões",
      "Title" => "Gerenciar Submissões",
      "Name_UK" => "Submissions",
      "Title_UK" => "Manage Submissions",

      'Href' => '?Unit=#Unit&ModuleName=Submissions&Action=Search&Event=#Event',
      'AccessMethod' => 'HasSubmissions',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "062_Submissions_Pub" => array
   (
      "Name" => "Palestres",
      "Title" => "Palestres do Event",
      "Name_UK" => "Talks",
      "Title_UK" => "Talks at the Event",

      'Href' => '?Unit=#Unit&ModuleName=Submissions&Action=Search&Event=#Event',
      'AccessMethod' => 'SubmissionsPublic',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 0,

      'Friend'     => 1,
      'Coordinator' => 0,
   ),
);
