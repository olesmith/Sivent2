<?php

include_once("SU/CGI.php");
include_once("SU/Read.php");
include_once("SU/Profiles.php");
include_once("SU/Select.php");
include_once("SU/Table.php");
include_once("SU/Html.php");
include_once("SU/Do.php");
include_once("SU/Message.php");
include_once("SU/Where.php");
include_once("SU/Form.php");






trait MyApp_Handle_SU
{
    use
        MyApp_Handle_SU_CGI,
        MyApp_Handle_SU_Read,
        MyApp_Handle_SU_Profiles,
        MyApp_Handle_SU_Select,
        MyApp_Handle_SU_Table,
        MyApp_Handle_SU_Html,
        MyApp_Handle_SU_Do,
        MyApp_Handle_SU_Message,
        MyApp_Handle_SU_Where,
        MyApp_Handle_SU_Form;
    //*
    //* function MyApp_Handle_SU, Parameter list:
    //*
    //* The admin Handler. Should display some basic info.
    //*

    function MyApp_Handle_SU()
    {
        $this->MyApp_Interface_Head();

        echo
            $this->Htmls_Text
            (
                $this->Htmls_Comment_Section
                (
                    "MyApp_Handle_SU",
                    $this->MyApp_Handle_SU_Form()
                )
            );
    }

}

?>