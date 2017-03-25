array
(
     "Event" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Events&Action=Show&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Evento",
        "Title_UK" => "Manage Event",
        "Name"     => "Evento",
        "Name_UK"     => "Event",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        'AccessMethod'    => "Current_User_Event_May_Edit",
      ),
    "Submission" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Details&Event=#Event&ID=#Submission",
        "Title"    => "Detalhes da Atividade",
        "Title_UK" => "Submission Details",
        "Name"     => "Detalhes",
        "Name_UK"     => "Details",

        "Public"   => 1,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 1,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        'AccessMethod'    => "Current_User_Event_Submissions_May_Show",
      ),
);
