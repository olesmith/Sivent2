array
(
     "Event" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Events&Action=Edit&Event=".$this->Event("ID"),
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
      ),
     "Areas" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Areas&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Trilhas",
        "Title_UK" => "Manage Areas of Interest",
        "Name"     => "Trilhas",
        "Name_UK"     => "Areas of Interest",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Submissions_Has",
      ),
     "Submission" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Submission&Event=#Event&ID=#ID",
        "Title"    => "Detalhes da Submissão",
        "Title_UK" => "Submission Details",
        "Name"     => "Detalhes",
        "Name_UK"     => "Details",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 1,
        "Coordinator"   => 1,
        "Advisor"    => 0,
      ),
     "Submissions" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Submissions&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Submissões",
        "Title_UK" => "Manage Submissions",
        "Name"     => "Submissões",
        "Name_UK"     => "Submissions",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "AccessMethod"    => "Event_Submissions_Has",
      ),
     "Dates" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Dates&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Datas do Evento",
        "Title_UK" => "Manage Event Dates",
        "Name"     => "Datas",
        "Name_UK"     => "Dates",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "NonGetVars" => array("Date","Time","Place","Room"),
      ),
     "Times" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Times&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Horários do Evento",
        "Title_UK" => "Manage Event Time Slots",
        "Name"     => "Horários",
        "Name_UK"  => "Time Slots",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "NonGetVars" => array("Time","Place","Room"),
      ),
     "Places" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Places&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Locais do Evento",
        "Title_UK" => "Manage Event Places",
        "Name"     => "Locais",
        "Name_UK"  => "Places",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "NonGetVars" => array("Date","Time","Place","Room"),
      ),
     "Rooms" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Rooms&Action=Search&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Salas do Evento",
        "Title_UK" => "Manage Event Rooms",
        "Name"     => "Salas",
        "Name_UK"  => "Rooms",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "NonGetVars" => array("Date","Time","Room"),
      ),
     "Schedule" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Schedules&Action=Schedule&Event=".$this->Event("ID"),
        "Title"    => "Mostrar Grade do Evento",
        "Title_UK" => "Show Event Schedule",
        "Name"     => "Mostrar Grade",
        "Name_UK"     => "Show Schedule",

        "Public"   => 1,
        "Person"   => 0,
        "Admin"    => 0,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
      ),
     "ScheduleEdit" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Schedules&Action=EditSchedule&Event=".$this->Event("ID"),
        "Title"    => "Editar Grade do Evento",
        "Title_UK" => "Edit Event Schedule",
        "Name"     => "Editar Grade",
        "Name_UK"     => "Edit Schedule",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
      ),
);
