array
(
   "SeeInscription" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Inscriptions&Action=Edit&ID=#ID#1",
      "Title"    => "Inscrição",
      "Title_UK" => "Inscription",
      "Name"     => "Inscrição",
      "Name_UK"   => "Inscrição",
      
      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "AccessMethod"    => "CheckEditAccess",
  ),
   "Caravaneers" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Caravans&Action=Caravaneers&ID=#ID#1",
      "Title"    => "Participantes da Caravana",
      "Title_UK" => "Caravan Participantes",
      "Name"     => "Caravaneiros",
      "Name_UK"   => "Caravaneers",
      
      "Handler"   => "Caravan_Caravaneers_Handle",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Admin"    => 1,
      "Singular"    => TRUE,
      //"AccessMethod"    => "CheckEditAccess",
  ),
);
