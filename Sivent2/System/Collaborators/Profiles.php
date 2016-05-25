<?php
array
(
   'Access' => array
   (
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Assessor"  => 1,
   ),
   'Actions' => array
   (
   ),
   'Menues' => array
   (
      'Singular' => array
      (
         'Public' => array
         (
            "Show" => 1,
         ),
         'Person' => array
         (
         ),
         "Friend" => array
         (
            "Show" => 1,
            "SeeFriend" => 1,
            "GenCert" => 1,
         ),
         'Assessor' => array
         (
         ),
         'Coordinator' => array
         (
            'Show' => 1,
            'Edit' => 1,
            'Delete' => 1,
            "SeeFriend" => 1,
            "GenCert" => 1,
         ),
         'Admin' => array
         (
            'Show' => 1,
            'Edit' => 1,
            'Delete' => 1,
            "SeeFriend" => 1,
            "GenCert" => 1,
         ),
      ),
      'Plural' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         'Coordinator' => array
         (
            "Add" => 1,
            "Search" => 1,
            "EditList" => 1,
            "Emails" => 1,
            "GenCerts" => 1,
         ),
         'Admin' => array
         (
            "Add" => 1,
            "Search" => 1,
            "EditList" => 1,
            "Emails" => 1,
            "GenCerts" => 1,
         ),
      ),
      'SingularPlural' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         "Friend" => array
         (
         ),
         'Assessor' => array
         (
         ),
         'Coordinator' => array
         (
         ),
         'Admin' => array
         (
         ),
      ),
      'ActionsPlural' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         "Friend" => array
         (
         ),
         'Assessor' => array
         (
         ),
         'Coordinator' => array
         (
            "Event" => 1,
            "Collaborations" => 1,
         ),
         'Admin' => array
         (
            "Event" => 1,
            "Collaborations" => 1,
         ),
      ),
      'ActionsSingular' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         "Friend" => array
         (
         ),
         'Assessor' => array
         (
         ),
        'Coordinator' => array
         (
            "Add" => 1,
            "Search" => 1,
            "EditList" => 1,
         ),
         'Admin' => array
         (
            "Add" => 1,
            "Search" => 1,
            "EditList" => 1,
         ),
      ),
   ),
);
?>