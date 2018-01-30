<?php


trait MyMod_Items_Group
{
    //*
    //* Creates list of data in $group. Default Basic.
    //*

    function MyMod_Items_Group_Data($group="")
    {
        if (empty($group)) { $group="Basic"; }

        return $this->MyMod_Data_Group_Datas_Get($group,FALSE);
    }
    
    //*
    //* Creates group table with $items
    //*

    function MyMod_Items_Group_Titles($group="")
    {
        $datas=$this->MyMod_Items_Group_Data($group);
        
        return $this->MyMod_Item_Titles($datas);
    }

    //*
    //* Creates group table with $items
    //*

    function MyMod_Items_Group_Table($edit,$items,$group="",$options=array())
    {
        $datas=$this->MyMod_Items_Group_Data($group);
        
        return $this->MyMod_Items_Table($edit,$items,$datas,$options);
    }

    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Group_Table_Html($edit,$items,$title="",$group="",$options=array())
    {
        if (empty($group)) { $group="Basic"; }
        
        if (empty($options[ "TABLE_Options" ])) { $options[ "TABLE_Options" ]=array(); }
        
        if (empty($title)) { $title=$this->ItemDataGroups($group,"Title"); }

        if (empty($group)) { $group="Basic"; }

        return
            $this->H(3,$title).
            $this->Html_Table
            (
               $this->MyMod_Items_Group_Titles($group),
               $this->MyMod_Items_Group_Table($edit,$items,$group,$options),
               $options[ "TABLE_Options"  ]
            ).
            "";
    }
}

?>