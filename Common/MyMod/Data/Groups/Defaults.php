<?php


//include_once("Data/Groups.php");

trait MyMod_Data_Groups_Defaults
{
    //use MyMod_Data_Defaults,MyMod_Data_Groups;

    //*
    //* function MyMod_Data_Groups_Defaults_Defs, Parameter list: 
    //*
    //* Returns groups default definitions.
    //*

    function MyMod_Data_Groups_Defaults_Defs()
    {
        return array
        (
            "Name" => "",
            "Actions" => array(),
            "ShowData" => array(),

            "Data" => array(),
            "Admin" => TRUE,
            "Person" => FALSE,
            "Public" => FALSE,
            "Single" => FALSE,
            "NoTitleRow" => FALSE,
            "SqlWhere" => "",
            "Sort" => "",
            "SubTable"  => NULL,
            "TitleData"  => NULL,
            "GenTableMethod" => "",  //arguments:
                                     // singular: $edit,$item,$group
                                     // plural:   $edit
            "OtherClass"  => FALSE,
            "OtherGroup" => FALSE,
            "PreMethod" => FALSE,
            "NItemsPerPage" => FALSE,
            "Visible" => 1,
        );

    }


    //*
    //* function MyMod_Data_Groups_Defaults_Take, Parameter list: &$groups
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_Groups_Defaults_Take(&$groups)
    {
        $defaults=$this->MyMod_Data_Groups_Defaults_Defs();
        foreach (array_keys($groups) as $data)
        {
            $this->MyMod_Data_Group_Defaults_Take($groups[ $data ],$defaults);
        }
    }

    //*
    //* function MyMod_Data_Group_Default_Take, Parameter list: &$data,$defaults=array()
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_Group_Defaults_Take(&$group,$defaults=array())
    {
        if (empty($defaults))
        {
            $defaults=$this->MyMod_Data_Groups_Defaults_Defs();
        }

        $this->MyHash_AddDefaultKeys($group,$defaults);
        $this->MyMod_Profiles_AddDefaultKeys($group);
    }

}

?>