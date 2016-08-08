array
(
   "011_ShowEvent" => array
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
   "012_ShowEvent" => array
   (

      "Name" => "Dados do Evento",
      "Title" => "Dados do Evento",
      "Name_UK" => "Event Data",
      "Title_UK" => "Event Data",

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
   "03_Collaborations" => array
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
   "040_Caravans" => array
   (
      "Name" => "Caravanas",
      "Title" => "Gerenciar Caravanas",
      "Name_UK" => "Caravans",
      "Title_UK" => "Manage Caravans",

      'Href' => '?Unit=#Unit&ModuleName=Caravans&Action=Search&Event=#Event',
      'AccessMethod' => 'HasCaravans',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
   ),
   "041_Caravaneers" => array
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
   "061_Submissions" => array
   (
      "Name" => "Atividades",
      "Title" => "Gerenciar Atividades",
      "Name_UK" => "Activities",
      "Title_UK" => "Manage Activities",

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
   "071_Schedule" => array
   (
      "Name" => "Grade",
      "Title" => "Mostrar Grade do Evento",
      "Name_UK" => "Schedule",
      "Title_UK" => "Show Event Schedule",

      'Href' => '?Unit=#Unit&ModuleName=Schedules&Action=Schedule&Event=#Event',

      'Public'    => 1,
      'Person'    => 0,
      'Admin'     => 0,

      'Friend'     => 1,
      'Coordinator' => 0,
      'AccessMethod' => 'SchedulePublic',
   ),
   "072_Schedule" => array
   (
      "Name" => "Grade",
      "Title" => "Grade do Evento",
      "Name_UK" => "Schedule",
      "Title_UK" => "Event Schedule",

      'Href' => '?Unit=#Unit&ModuleName=Schedules&Action=Schedule&Event=#Event',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
      'AccessMethod' => 'HasSubmissions',
   ),
   "08_Speakers" => array
   (
      "Name" => "Palestrantes",
      "Name_UK" => "Speakers",

      'Href' => '?Unit=#Unit&ModuleName=Speakers&Action=Search&Event=#Event',

      'Public'    => 0,
      'Person'    => 0,
      'Admin'     => 1,

      'Friend'     => 0,
      'Coordinator' => 1,
      'AccessMethod' => 'HasSubmissions',
   ),
);
