<?php

include_once("Tail/Thanks.php");
include_once("Tail/Phrase.php");
include_once("Tail/Sponsors.php");
include_once("Tail/Support.php");


trait MyApp_Interface_Tail
{
    use
        MyApp_Interface_Tail_Thanks,
        MyApp_Interface_Tail_Phrase,
        MyApp_Interface_Tail_Support,
        MyApp_Interface_Tail_Sponsors;

    //*
    //* function MyApp_Interface_Tail, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail()
    {
        if ($this->NoTail>0) { return; }
        if ($this->GetCookieOrGET("NoHeads")==1) { return; }

        //For some reason we have chdir'ed?? 30/06/2012
        chdir(dirname($_SERVER[ "SCRIPT_FILENAME" ]));

        echo 
                $this->HtmlTags
                (
                   "TD",
                   $this->Div
                   (
                      $this->Img
                      (
                         $this->HtmlSetupHash[ "TailIcon_Left" ],
                         "Owl",
                         "100"
                      ),
                      array("ALIGN" => 'center')
                   )
                ).
                $this->HtmlTags
                (
                   "TD",
                   $this->MyApp_Interface_Tail_Center()
                ).
                $this->HtmlTags
                (
                   "TD",
                   $this->Div
                   (
                      $this->Img
                      (
                         $this->HtmlSetupHash[ "TailIcon_Right" ],
                         "Owl",
                         "100"
                      ),
                      array("ALIGN" => 'center')
                    )
                ).
                "</TR>\n".
                "<TR><TD COLSPAN='3'>\n".
                $this->MyApp_Interface_Tail_Queries_Show().
                $this->MyApp_Interface_Tail_PostMessages_Show().
                "</TRD</TR>\n".
                "</TABLE></DIV></BODY>\n".
                "</HTML>".
                "";
    }
    
    //*
    //* function MyApp_Interface_Tail_Queries_Show, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Queries_Show()
    {
        return "";
        if (is_array($this->DB_Queries) && !empty($this->DB_Queries) && $this->DBHash[ "Debug" ])
        {
            return
                $this->H(3,"DB Queries").
                $this->HtmlTable
                (
                   array("No","Module","Function","Query"),
                   $this->MyHash_List_Number($this->DB_Queries)
                );
        }

        return "";
    }
    
    //*
    //* function MyApp_Interface_Tail_PostMessages_Show, Parameter list: 
    //*
    //* Shows application Post Messages.
    //*

    function MyApp_Interface_Tail_PostMessages_Show()
    {
        if (count($this->PostMessages)>0)
        {
            return
                $this->H(3,"Post Messages").
                $this->HtmlList($this->PostMessages,"OL");
        }

        return "";
    }
    //*
    //* function MyApp_Interface_Tail_Center, Parameter list: 
    //*
    //* Generest center cell of tail.
    //*

    function MyApp_Interface_Tail_Center()
    {
        return
            $this->Html_HR('100%').
            $this->MyApp_Interface_Tail_Support().
            $this->MyApp_Interface_Tail_Thanks_Table().
            $this->MyApp_Interface_Tail_Phrase().
            $this->WriteHtmlMessages().
            "";
    }
}

?>