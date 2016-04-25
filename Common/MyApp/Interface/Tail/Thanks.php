<?php

trait MyApp_Interface_Tail_Thanks{
    //*
    //* function MyApp_Interface_ThanksTable, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Thanks_Table()
    {
        $table=$this-> MyApp_Setup_Files2Hash
        (
           array("../Application/System/","../MySql2/System/","System/"),
           array("Thanks.php")
        );

        array_unshift($table,array($this->U("Collaborators (in alfabetical order):")));

        return
            $this->Html_Table
            (
               "",
               $table,
               array("ALIGN" => 'center')
            ).
            $this->Html_HR('75%').
            "";
     }
}

?>