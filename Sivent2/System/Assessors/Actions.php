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
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckEditAccess",
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
     /* "Submissions" => array */
     /* ( */
     /*    "Href"     => "", */
     /*    "HrefArgs" => "?ModuleName=Submissions&Action=Search&Event=".$this->Event("ID"), */
     /*    "Title"    => "Gerenciar Submissões", */
     /*    "Title_UK" => "Manage Submissions", */
     /*    "Name"     => "Submissões", */
     /*    "Name_UK"     => "Submissions", */

     /*    "Public"   => 0, */
     /*    "Person"   => 0, */
     /*    "Admin"    => 1, */
     /*    "Friend"   => 0, */
     /*    "Coordinator"   => 1, */
     /*    "Advisor"    => 0, */
     /*    "AccessMethod"    => "Event_Submissions_Has", */
     /*  ), */
     /* "Event" => array */
     /* ( */
     /*    "Href"     => "", */
     /*    "HrefArgs" => "?ModuleName=Events&Action=Edit&Event=".$this->Event("ID"), */
     /*    "Title"    => "Gerenciar Evento", */
     /*    "Title_UK" => "Manage Event", */
     /*    "Name"     => "Evento", */
     /*    "Name_UK"     => "Event", */

     /*    "Public"   => 0, */
     /*    "Person"   => 0, */
     /*    "Admin"    => 1, */
     /*    "Friend"   => 0, */
     /*    "Coordinator"   => 1, */
     /*    "Advisor"    => 0, */
     /*  ), */
);
