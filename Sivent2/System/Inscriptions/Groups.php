array
(
   "Basic" => array
   (
      "Name" => "Básicos",
      "Name_UK" => "Basic",
      "Data" => array
      (
         "No","Edit","Delete","GenCert","MailCert",
         "Event","Friend","Status",
         "Inscription",
         "Code",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 0,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
    ),
    "Selection" => array
    (
       "Name" => "Seleção",
       "Name_UK" => "Selection",
       "Data" => array
       (
          "No","Edit","Delete",
          "Event","Friend",
          "Status","Selected",
          "Code",
        ),
       
       "Edit_Coordinator" => 1, //edit default for this group
       "Edit_Admin" => 1, //edit default for this group

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "Assessor"  => 0,
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "No","Edit","Delete",
          "Event","Friend",
          "Status","Selected","Certificate","Certificate_CH",
          "Inscription_Certificate_Generated_Cell","GenCert",
          "Inscription_Certificate_Mailed_Cell","MailCert",
          "Code",
        ),

       "Edit_Coordinator" => 1, //edit default for this group
       "Edit_Admin" => 1, //edit default for this group
       
       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "Assessor"  => 0,
    ),
);
