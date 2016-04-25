<?php


trait MyApp_Interface_Doc_Tail
{
    //*
    //* sub MyApp_Interface_Doc_Tail, Parameter list:
    //*
    //* Sends the HTML doc tail.
    //*
    //*

    function MyApp_Interface_Doc_Tail()
    {
        if ($this->NoTail>0) { return; }

        print
            
            "      </TD>".
            $this->Html_Tags
            (
               "TD",
               $this->MyApp_Interface_ExecTime().
               $this->MyApp_Interface_Messages().
               //$this->MyApp_Interface_Messages_Email().
               //$this->MyApp_Interface_Status().
               $this->MyApp_Interface_Tail_Support_Info().
               $this->MyApp_Interface_Tail_Sponsors(),
                array("ALIGN" => 'top')
            ).
            "   </TR>".
            "   <TR>";
    }
    
}

?>