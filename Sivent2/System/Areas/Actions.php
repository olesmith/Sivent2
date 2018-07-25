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
    'Search' => array
    (
        'Public' => 1,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 1,
        "Coordinator" => 1,
        "AccessMethod" => "CheckShowListAccess",
    ),
    'Add' => array
    (
        'Public' => 0,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "AccessMethod" => "CheckShowListAccess",
    ),
    'Copy' => array
    (
        'Public' => 0,
        'Person' => 0,
        "Admin" => 1,
        "Friend"     => 0,
        "Coordinator" => 1,
        "AccessMethod" => "CheckShowListAccess",
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
        "AccessMethod" => "CheckEditListAccess",
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
