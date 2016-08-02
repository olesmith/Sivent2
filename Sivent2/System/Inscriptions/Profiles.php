<?php
array
(
   'Access' => array
   (
      "Person" => 0,
      "Public" => 0,
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
         ),
         'Assessor' => array
         (
         ),
         'Coordinator' => array
         (
            'Edit' => 1,
            'Copy' => 1,
            'Delete' => 1,
            "GenCert" => 1,
            "MailCert" => 1,
            "Friend" => 1,
         ),
         'Admin' => array
         (
            'Edit' => 1,
            'Copy' => 1,
            'Delete' => 1,
            "GenCert" => 1,
            "MailCert" => 1,
            "Friend" => 1,
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
         ),
         'Admin' => array
         (
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
            "Emails" => 1,
            "GenCerts" => 1,
         ),
         'Admin' => array
         (
            "Emails" => 1,
            "GenCerts" => 1,
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
            "FriendCollaborations" => 1,
            "FriendSubmissions" => 1,
            "FriendCaravan" => 1,
         ),
         'Admin' => array
         (
            "FriendCollaborations" => 1,
            "FriendSubmissions" => 1,
            "FriendCaravan" => 1,
         ),
      ),
   ),
);
?>