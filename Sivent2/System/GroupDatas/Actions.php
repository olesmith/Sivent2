array
(
    'Search' => array
    (
        'Public' => 1,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "Assessor"  => 0,
    ),
    'Show' => array
    (
        'Public' => 1,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "Assessor"  => 0,
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
    'Add' => array
    (
        'Public' => 0,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "Assessor"  => 0,
        "AccessMethod" => "CheckEditAccess",
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
    'Copy' => array
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
    "Import" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Importar #ItemsName de outro Evento",
        "Title_UK" => "Import #ItemsName_UK from other Event",
        "Title_ES"    => "Importar #ItemsName_ES de outro Evento",
        "Name"     => "Importar",
        "Name_UK"  => "Import",
        "Name_ES"     => "Importar",
        //"Icon"     => "rubik.png",
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Coordinator"   => 1,
        "Handler"   => "EventMod_Import_Events_Handle",
        "Singular"   => FALSE,
    ),
);
