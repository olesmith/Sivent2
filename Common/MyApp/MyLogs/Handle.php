<?php


trait MyLogs_Handle
{
    //*
    //* function Handle_Logs, Parameter list: 
    //*
    //* Search Logs handler.
    //*

    function Handle_Logs()
    {
        $this->ApplicationObj()->DB_Queries=array();
        
        $this->SchoolsObj()->SqlFilter="#ShortName";
        echo
            $this->H(1,"Search Logs").
            $this->Logs_Tables_Menu().
            $this->StartForm($action="",$method="post",$fileupload=FALSE,$options=array(),$suppresscgis=array("Year","Month")).
            $this->Logs_Info_CGI().
            $this->Html_Table
            (
                $this->Logs_Dates_Table_Titles(),
                $this->Logs_Dates_Table()
            ).
            $this->EndForm().
            "";
        $this->DB_Queries_Show();
    }

}

?>