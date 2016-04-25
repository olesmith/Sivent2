<?php
array
(
   'Access' => array
   (
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Assessor"  => 1,
   ),
   'Actions' => array
   (
      'Search' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 10,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
      ),
      'Copy' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 1,
         "AccessMethod" => "CheckShowAccess",
      ),
      'ShowList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "Assessor"  => 0,
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
         "Admin" => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
         "AccessMethod"  => "CheckDeleteAccess",
      ),
      'Latex' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 1,
      ),
      'LatexList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Print' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 1,
      ),
      'PrintList' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Download' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Export' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Zip' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'MyUnit' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Profiles' => array
      (
          'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
     ),
      'ComposedAdd' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Import' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'Process' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
      'SysInfo' => array
      (
         'Public' => 0,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
      ),
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
         ),
         'Admin' => array
         (
            'Edit' => 1,
            'Copy' => 1,
            'Delete' => 1,
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
         ),
         'Admin' => array
         (
            "Add" => 1,
            "Search" => 1,
            "EditList" => 1,
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
         ),
         'Admin' => array
         (
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
         ),
         'Admin' => array
         (
         ),
      ),
   ),
);
?>