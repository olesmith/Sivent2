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
      'Schedule' => array
      (
         "Href"     => "",
         "HrefArgs" => "?ModuleName=Speakers&Action=Schedule&Event=".$this->Event("ID")."&Speaker=#ID",
         "Title"    => "Horários do Palestrante",
         "Title_UK" => "Speaker's Schedule",
         "Name"     => "Horários",
         "Name_UK"     => "Schedule",

         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckShowAccess",

         "Icon"    => "time_light.png",
         "Singular"    => TRUE,
      ),
    "Emails" => array
    (
        "Href"     => "",
        "HrefArgs" => "?ModuleName=Speakers&Action=Emails",
        "Title"    => "Emails",
        "Title_UK" => "Emails",
        "ShortName"     => "Emails",
        "ShortName_UK"   => "Emails",
        "Name"     => "Emails",
        "Name_UK"   => "Emails",
        "Handler"   => "HandleEmails",

        'Public' => 0,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "AccessMethod" => "CheckEditListAccess",
    ),
);
