<?php


trait MyMod_Handle_Import_Show
{
    //*
    //* function MyMod_Handle_Import_Items_Show, Parameter list: 
    //*
    //* Shows the detected info.
    //*

    function MyMod_Handle_Import_Items_Show()
    {
        $file="";
        if (!empty($_FILES[ "File" ]))
        {
            $file=$_FILES[ "File" ][ "name" ];
        }
        elseif (!empty($_POST[ "FileName" ]))
        {
            $file=$this->CGI_POST("FileName");
        }
        
        return
            $this->H(2,"Entries in File: ".$file."").
            $this->StartForm($action="Import").
            $this->Html_Table
            (
                $this->MyMod_Handle_Import_Items_Table_Titles(),
                $this->MyMod_Handle_Import_Items_Table()
            ).
            $this->MakeHidden("FileName",$file).
            $this->EndForm().
            "";
    }
    
}
?>