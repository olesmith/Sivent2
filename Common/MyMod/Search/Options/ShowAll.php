<?php


trait MyMod_Search_Options_ShowAll
{
    //*
    //* function MyMod_Search_Options_Show_All_Cells, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Show_All_Cells($omitvars)
    {
        $row=array();
        if (!preg_grep('/^ShowAll$/',$omitvars))
        {
            $row=
                array
                (
                    $this->B
                    (
                        $this->GetMessage($this->MyMod_Search_Messages,"ShowAll").":"
                    ),
                    $this->MyMod_Search_CGI_Include_All_Radio_Field().
                    ""
                );
        }

        return $row;
    }
}

?>