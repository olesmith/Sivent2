<?php

trait MyMod_Handle_Add
{
    //*
    //* function MyMod_Handle_Add, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Add($echo=TRUE)
    {
        $title=$this->GetRealNameKey($this->Actions[ "Add" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Add" ],"PName");

        return $this->MyMod_Handle_Add_Form($title,$ptitle,$echo);
    }
    
    //*
    //* Creates form for adding an item. If $_POST[ "Update" ]==1,
    //* calls Add.
    //*

    function MyMod_Handle_Add_Form($title,$addedtitle,$echo=TRUE)
    {
        $this->Singular=TRUE;
        $rdatas=$this->FindAllowedData(0);
        $datas=array();
        foreach ($rdatas as $data)
        {
            if (
                 !preg_match('/^[ACM]Time$/',$data)
                 &&
                 !$this->ItemData[ $data ][ "NoAdd" ]
               )
            {
                array_push($datas,$data);
            }
            elseif ($this->ItemData[ $data ][ "Compulsory" ])
            {
                array_push($datas,$data);
            }
        }

        if (is_array($this->AddDatas) && count($this->AddDatas)>0) { $datas=$this->AddDatas; }

        $this->MyMod_Data_Add_Default_Init();

        $html="";
        $action="Add";
        $action=$this->MyActions_Detect();
        $msg="";
        if ($this->GetPOST("Add")==1)
        {
            $res=$this->Add($msg);
            if ($res)
            {
                $this->MyMod_Handle_Add_Redirect();
            }
        }

        $this->ApplicationObj->MyApp_Interface_Head();
        $html=
            $this->MyMod_Handle_Add_Form_Text_Pre().
            $this->H(2,$title).
            $msg.
            $this->StartForm("?Action=".$action).
            $this->MyMod_Handle_Add_Table($datas).
            $this->MakeHidden("Add",1).
            $this->EndForm().
            $this->MyMod_Handle_Add_Form_Text_Post().
            "";

        if ($echo)
        {
            $this->MyMod_HorMenu_Echo(TRUE);
            echo $html;
            return "";
        }
        else
        {
            return $html;
        }
    }
    
    //*
    //* Redirects to edit item after add.
    //*

    function MyMod_Handle_Add_Redirect()
    {
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Hidden2Hash($args);

        $action=$this->MyActions_Detect();

        $this->AddCommonArgs2Hash($args);
        $args[ "Action" ]=$this->MyActions_Detect();
        if ($args[ "Action" ]=="Add") { $args[ "Action" ]=$this->MyMod_Add_Reload_Action; }

        $args[ "ID" ]=$this->ItemHash[ "ID" ];
        if (!empty($this->IDGETVar))
        {
            $args[ $this->IDGETVar ]=$this->ItemHash[ "ID" ];
        }

        //Now added, reload as edit, preventing multiple adds on user pressing F5.
        $this->CGI_Redirect($args);
        exit();
    }

    
    //*
    //* Pretext function. Returns empty string, supposed to be overridden.
    //*

    function MyMod_Handle_Add_Form_Text_Pre()
    {
        return "";
    }

    //*
    //* Posttext function. Returns empty string, supposed to be overridden.
    //*

    function MyMod_Handle_Add_Form_Text_Post()
    {
        return "";
    }

    //*
    //* Creates table for adding data. May be overwritten.
    //*

    function MyMod_Handle_Add_Table($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            if (!preg_match('/^[ACM]Time$/',$data) && !$this->ItemData[ $data ][ "NoAdd" ])
            {
                array_push($rdatas,$data);
            }
            elseif ($this->ItemData[ $data ][ "Compulsory" ])
            {
                array_push($rdatas,$data);
            }
        }

        $table=array();
        if (count($this->ItemDataSGroups)>0)
        {
            //we will generate a list of tables
            foreach ($this->ItemDataSGroups as $group => $groupdef)
            {
                $table=
                    array_merge
                    (
                       $table,
                       $this->MyMod_Item_SGroup_Html_Row
                       (
                           1,
                           $this->AddDefaults,
                           $group,
                           array(),
                           TRUE
                       )
                    );

             }
        }
        else
        {
            $table=$this->ItemTable
            (
               1,
               $this->AddDefaults,
               1,
               $rdatas
            );
        }
        
        array_unshift($table,$this->Buttons());
        array_push($table,$this->Buttons());

        return $this->HTML_Table
        (
           "",
           $table,
           array
           (
              "ALIGN" => 'center',
              "BORDER" => 1
           ),
           array(),
           array(),
           TRUE,
           TRUE
        );
    }    
}

?>