<?php

trait MyApp_Interface_Tail_Sponsors
{
    //*
    //* function MyApp_Interface_Sponsors, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Sponsors()
    {
        $file=$this->SetupPath."/"."Sponsors.php";

        $table=array();
        if (file_exists($file))
        {
            $sponsors=$this->ReadPHPArray($file);
            foreach ($sponsors as $sponsor)
            {
                $link=
                    $this->Center
                    (
                       $this->Href
                       (
                          $sponsor[ "URL" ],
                          $this->IMG
                          (
                             "Uploads/Sponsors/".$sponsor[ "Icon" ],
                             "Logo ".$sponsor[ "Name" ],
                             $sponsor[ "Height" ],
                             $sponsor[ "Width" ]
                          ),
                          $sponsor[ "Name" ].": ".$sponsor[ "URL" ]
                       )
                    );

                array_push($table,array($link));
            }
        }

        if (count($table)>0)
        {
            array_unshift($table,array($this->B($this->U("Patrocínios:"))));
        }

        return  $this->Html_Table
        (
           "",
           $table,
           array("ALIGN" => 'center')
        );
    }
}

?>