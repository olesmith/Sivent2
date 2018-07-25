<?php


trait MyApp_Interface_Doc_Tail
{
    //*
    //* sub MyApp_Interface_Post_Row, Parameter list:
    //*
    //* Returns nothing, in between Middle and Final rows (TR).
    //* Supposed to be overwritten, printing something more.
    //*
    //*

    function MyApp_Interface_Post_Row()
    {
        return "";
    }
    
    //*
    //* sub MyApp_Interface_Doc_Tail, Parameter list:
    //*
    //* Sends the HTML doc tail.
    //*
    //*

    function MyApp_Interface_Doc_Tail()
    {
        return "";
        /* if ($this->NoTail>0) { return; } */

        /* echo             */
        /*     "      </TD>". */
        /*     $this->Html_Tags */
        /*     ( */
        /*         "TD", */
        /*         $this->HtmlTags */
        /*         ( */
        /*             "ASIDE", */
        /*             $this->MyApp_Interface_ExecTime(). */
        /*             $this->MyApp_Interface_Messages(). */
        /*             $this->MyApp_Interface_Tail_Support_Info(). */
        /*             $this->MyApp_Interface_Tail_Sponsors() */
        /*         ), */
        /*         array("ALIGN" => 'top') */
        /*     ). */
        /*     "   </TR>". */
        /*     $this->MyApp_Interface_Post_Row(). */
        /*     "   <TR>"; */
    }
    
}

?>