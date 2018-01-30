<?php


trait MyMod_Search_CGI_Text
{
    //*
    //* function MyMod_Search_CGI_Text_Name, Parameter list: $data
    //*
    //* Returns the name of the text CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Text_Name($data)
    {
        return
            $this->MyMod_Search_CGI_Name($data)."_Search_Text";
    }

    //*
    //* function MyMod_Search_CGI_Name, Parameter list: $data
    //*
    //* Returns the name of the CGI search var associated with $data.
    //*

    function MyMod_Search_CGI_Text_Value($data)
    {
        $value=$this->CGI_VarValue($this->MyMod_Search_CGI_Name($data));
        $rvalue=$this->CGI_VarValue($this->MyMod_Search_CGI_Text_Name($data));

        if ($value!="" && $value!=0)
        {
            $rvalue="";
        }

        return $rvalue;
    }
}

?>