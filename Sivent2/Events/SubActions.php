<?php

class Events_SubActions extends EventsCertificate
{
    //*
    //* function MyMod_SubActions_Groups_Init, Parameter list: 
    //*
    //* Detects sub actions groups to activate.
    //*

    function MyMod_SubActions_Groups_Init()
    {
        $subaction=$this->CGI_GET("SubAction");

        $agroups=array();
        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (!empty($this->ItemDataSGroups[ $group ][ "SubAction" ]))
            {
                if ($this->ItemDataSGroups[ $group ][ "SubAction" ]==$subaction)
                {
                    $agroups[ $group ]=$this->ItemDataSGroups[ $group ];
                }
                
                unset($this->ItemDataSGroups[ $group ]);
            }
        }

        foreach (array_keys($agroups) as $group)
        {
            $this->ItemDataSGroups[ $group ]=$agroups[ $group ];
        }
    }
    //*
    //* function MyMod_Handle_Event_Menu, Parameter list: 
    //*
    //* Creates horisontal menu with access to different SGroups.
    //*

    function MyMod_SubActions_Menu()
    {
        $args=$this->CGI_URI2Hash();

        $subactions=$this->ReadPHPArray("System/Events/SubActions.php");
        
        $currsubaction=$this->CGI_GET("SubAction");

        $hrefs=array();
        foreach ($subactions as $subaction => $def)
        {
            $res=$this->MyAction_Allowed($def);

            if (!$res) { continue; }
            
            $args[ "SubAction" ]=$subaction;

            $href=$this->GetRealNameKey($def);
            if ($subaction!=$currsubaction)
            {
                $href=$this->Href
                (
                   "?".$this->CGI_Hash2URI($args),
                   $href,
                   "",
                   "",
                   "",
                   FALSE,
                   array(),
                   "HorMenu"
                );
            }
            
            array_push($hrefs,$href);
        }
        
        if (empty($hrefs)) { return ""; }
        
        return
            $this->Center
            (
                $this->B($this->Language_Message("Event_Setup_Menu_Title").":").
               " [ ".
               join(" | ",$hrefs).
               " ]"
            );
    }
    
    
}

?>