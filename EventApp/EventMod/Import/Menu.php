<?php



trait EventMod_Import_Menu
{
    //*
    //* function EventMod_Import_Menu_Horisontal, Parameter list: 
    //*
    //* Creates horisontal menu with links to Module Import from Event.
    //*

    function EventMod_Import_Menu_Horisontal()
    {
        $args=$this->CGI_URI2Hash();
        $args[ "Action" ]="Import";

        $hrefs=array();
        foreach ($this->ApplicationObj()->Event_Import_Modules as $module)
        {
            $args[ "ModuleName" ]=$module;
            $obj=$module."Obj";

            array_push
            (
                $hrefs,
                $this->Href
                (
                    "?".$this->CGI_Hash2URI($args),
                    $this->ApplicationObj()->$obj()->ItemsName
                )
            );
        }
        
        return
            $this->Center
            (
                $this->B
                (
                    $this->MyLanguage_GetMessage("Event_Data_Import_Menu_Title").
                    ": "
                ).
                "[ ".
                join(" | ",$hrefs).
                " ]"
            );
    }
    
    
}

?>