<?php

trait MyApp_Interface_Tail_Phrase
{
    //*
    //* function MyApp_Interface_Phrase, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Phrase()
    {
        return
            $this->DIV
            (
               $this->IMG
               (
                  "icons/kierkegaard.png",
                  "Life sure is a Mystery to be Lived<BR>\n".
                  "Not a Problem to be Solved<BR>\n",
                  100,400
               ),
               array("ALIGN" => 'center')
            ).
            $this->Html_HR('75%').
            "";
     }
}

?>