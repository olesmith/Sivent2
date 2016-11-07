<?php



class Submissions_Export extends Submissions_Table
{
    var $Export_Defaults=
        array
        (
                "Data" => array
                (
                    1 => "No",
                    2 => "Title",
                    3 => "Area__Name",
                    4 => "Friend__Name",
                    5 => "Friend__Email",
                ),
                "Sort" => array
                (
                    1 => "0",
                    2 => "0",
                    3 => "0",
                    4 => "1",
                    5 => "0",
                ),
                
           );
}

?>