array
(
      'Export' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 0,
         "Coordinator" => 1,
         "AccessMethod" => "CheckShowListAccess",
      ),
      'Download' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "AccessMethod"  => "CheckDownloadAccess",
      ),
      'Unlink' => array
      (
         'Public' => 1,
         'Person' => 0,
         "Admin" => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         //"AccessMethod"  => "CheckEditAccess",
      ),
   "Clean" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Clean",
      "Title"    => "Limpar",
      "Title_UK" => "Clean",
      "Name"     => "Limpar Cadastros",
      "Name_UK"   => "Clean Registrations",
      "Public"   => 0,
      "Person"   => 0,
      "Monitor"     => 0,
      "Coordinator" => 1,
      "Friend"  => 0,
      "Admin"    => 1,
      "Handler"   => "HandleClean",
   ),
   "Collaborations" => array
   (
      "Href"     => "",
      "HrefArgs" => "?ModuleName=Friends&Action=Collaborations",
      "Title"    => "Colaborações",
      "Title_UK" => "Collaborations",
      "ShortName"     => "Colaborações",
      "ShortName_UK"   => "Collaborations",
      "Name"     => "Colaborações",
      "Name_UK"   => "Collaborations",
      
      "Handler"   => "Friend_Collaborations_Handle",
      "AccessMethod"   => "Friend_Collaborators_Should",

      "Public"   => 0,
      "Person"   => 0,
      "Friend"     => 0,
      "Coordinator" => 1,
      "Admin"    => 1,
  ),
);
