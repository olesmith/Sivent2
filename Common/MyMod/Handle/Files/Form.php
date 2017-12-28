<?php

trait MyMod_Handle_Files_Form
{
    //*
    //* function MyMod_Handle_Files_Form, Parameter list: 
    //*
    //* Shows disc files - for removal
    //*

    function MyMod_Handle_Files_Form()
    {
        $path=$this->GetPOST("Path");
        if (empty($path)) { $path="Uploads"; }

        $path=$this->MyMod_Data_Upload_Path();

        $buttons=$this->MakeButtons
        (
           array
           (
              array
              (
                 "Type" => "submit",
                 "Title" => "Pesquisar",
              ),
              array
              (
                 "Type" => "submit",
                 "Title" => "DELETAR",
              ),
           )
        );
        
        echo
            $this->StartForm().
            $this->H(1,"Files in Path: ".$path).
            $buttons.
            $this->Html_Table
            (
               "",
               $this->PadTable
               (
               $this->MyMod_Handle_Files_Table($path)
               ),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            $buttons.
            $this->MakeHidden("GO",1).
            $this->EndForm().
            "";
        
        return 1;
    }
    
}

?>