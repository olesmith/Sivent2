array
(
      'Search' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Copy' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
      ),
      'EditList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
      ),
      'Delete' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDeleteAccess",
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
        "Admin"    => 1,
        "Friend"   => 1,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "Handler"    => "HandleSchedule",
        "NonGetVars" => array("Date","Time","Place","Room"),
      ),
     "EditSchedule" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Schedules&Action=EditSchedule&Event=".$this->Event("ID"),
        "Title"    => "Gerenciar Grade do Evento",
        "Title_UK" => "Manage Event Schedule",
        "Name"     => "Gerenciar Grade",
        "Name_UK"     => "Manage Schedule",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        "Handler"    => "HandleSchedule",
        "NonGetVars" => array("Date","Time","Place","Room"),
      ),
     "PreInscriptions" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=PreInscriptions&Action=Search&Event=".$this->Event("ID")."&Submission=#Submission",
        "Title"    => "Preinscrições",
        "Title_UK" => "Preinscriptions",
        "Name"     => "Preinscrições",
        "Name_UK"     => "Preinscriptions",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,
        //"Handler"    => "HandleSchedule",
        "NonGetVars" => array("Date","Time","Place","Room"),
        "AccessMethod"    => "Submission_PreInscriptions_Has",
      ),
     "Presences" => array
     (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Presences&Action=Register&Event=".$this->Event("ID")."&Schedule=#ID",
        "Name"     => "Presenças",
        "Name_UK"     => "Presences",

        "Public"   => 0,
        "Person"   => 0,
        "Admin"    => 1,
        "Friend"   => 0,
        "Coordinator"   => 1,
        "Advisor"    => 0,

        "NonGetVars" => array("Date","Time","Place","Room"),
        //"AccessMethod"    => "Submission_PreInscriptions_Has",
      ),
);
