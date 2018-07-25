<?php

trait MyMod_Handle_Copy
{
    //*
    //* function MyMod_Handle_Copy, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Copy()
    {
        $title=$this->GetRealNameKey($this->Actions[ "Copy" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Copy" ],"PName");

        $this->MyMod_Handle_Copy_Form($title,$ptitle);
    }
    
    //*
    //* Creates form for copying an item. If $_POST[ "Update" ]==1,
    //* calls Copy.
    //*

    function MyMod_Handle_Copy_Form($title,$copiedtitle)
    {
        $this->Singular=TRUE;
        $this->NoFieldComments=TRUE;

        $item=$this->ItemHash;
        $this->MyMod_Data_Add_Default_Init();

        $action="Copy";
        $msg="";
        if ($this->GetPOST("Copy")==1)
        {
            $res=$this->Copy();
            if ($res)
            {
                $this->MyMod_Handle_Copy_Redirect();
            }
            else
            {
                $msg=$this->H(4,$this->ItemName." não Copiado");
            }
        }

        #Send headers and leading html.
        $this->ApplicationObj->MyApp_Interface_Head();

        foreach ($this->AddDefaults as $data => $value)
        {
            if (empty($item[ $data ]))
            {
                $item[ $data ]=$value;
                $item[ $data."_Value" ]=$value;
            }
        }

        $this->MyMod_HorMenu_Echo(TRUE,$this->CGI_GET("ID"));
        echo
            
            $this->H(2,$title).
            $msg.
            $this->H(3,$this->MyMod_Item_Name_Get($item)).
            $this->StartForm("?Action=".$action).
            $this->HTMLTable
            (
               "",
               $this->ItemTable
               (
                  1,
                  $item,
                  1,
                  $this->GetNonReadOnlyData()
               )
            ).
            $this->MakeHidden("Copy",1).
            $this->Buttons().
            $this->EndForm();
    }

    
    //*
    //* Relocates after finished copying.
    //*

    function MyMod_Handle_Copy_Redirect()
    {
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);

        $action=$this->MyActions_Detect();

        $this->AddCommonArgs2Hash($args);
        $args[ "Action" ]=$this->MyActions_Detect();
        if ($args[ "Action" ]=="Copy") { $args[ "Action" ]=$this->MyMod_Add_Reload_Action; }

        $args[ "ID" ]=$this->ItemHash[ "ID" ];
        $var=$this->IDGETVar;
        if
            (
                !empty($var)
                &&
                !empty($args[ $var ])
            )
        {
            unset($args[ $var ]);
        }

        $this->ApplicationObj->LogMessage("Copy","Item Added");
                
        //Now added, reload as edit, preventing multiple copies, the user reloading the page.
        $this->CGI_Redirect($args);
        exit();
    }
}

?>