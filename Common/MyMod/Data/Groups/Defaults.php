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

    //*
    //* Names of data groups.
    //*

    function MyMod_Data_Group_Names_Get($singular=FALSE)
    {
        $this->MyMod_Data_Groups_Initialize();
        if (($this->Singular || $single) && count($this->ItemDataSGroups)>0)
        {
            return array_keys($this->ItemDataSGroups);
        }
        else
        {
            return array_keys($this->ItemDataGroups);
        }
        $accgroups=$this->MyMod_Data_Groups_AccName($singular);

        return array_keys($this->$accgroups);
    }
    
    //*
    //* Return object data group var, that is:
    //* ItemDataSGroups if Singular, elsewise ItemDataGroups
    //*

    function MyMod_Data_Group_Singular($single=FALSE)
    {
        if (($this->Singular || $single) && count($this->ItemDataSGroups)>0)
        {
            return True;
        }
        else
        {
            return False;
        }
    }
    
    //*
    //* Return object data group var, that is:
    //* ItemDataSGroups if Singular, elsewise ItemDataGroups
    //*

    function MyMod_Data_Group_Defs_Get($single=FALSE)
    {
        $this->MyMod_Data_Groups_Initialize();
        if ($this->MyMod_Data_Group_Singular($single))
        {
            return $this->ItemDataSGroups;
        }
        else
        {
            return $this->ItemDataGroups;
        }
    }
    
    //*
    //* Return data to display in Data Group
    //*

    function MyMod_Data_Group_Def_Get($group,$single=FALSE,$echo=True)
    {
        if ($this->MyMod_Data_Group_Singular($single))
        {
            if (!empty($this->ItemDataSGroups[ $group ]))
            {
                return $this->ItemDataSGroups[ $group ];
            }
        }
        else
        {
            if (!empty($this->ItemDataGroups[ $group ]))
            {
                return $this->ItemDataGroups[ $group ];
            }
        }

        if ($echo)
        {
            echo $this->ModuleName." Warning: Group $group undefined";
            $this->AddMsg("Warning: Group $group undefined");
            exit();
        }

        return array();
    }

    

    //*
    //* Return current Data Group
    //*

    function MyMod_Data_Group_Actual_Get()
    {
        $this->PostInitItems();

        if (!empty($this->CurrentDataGroup))
        {
            $group=$this->CurrentDataGroup;
        }
        else
        {
            $group=$this->GetCGIVarValue($this->GroupDataCGIVar());
        }

        $groups=$this->MyMod_Data_Group_Defs_Get();
        if (!preg_grep('/^'.$group.'$/',array_keys($groups)))
        {
            $group="";
        }

        if  (
               empty($group)
               ||
               !$this->MyMod_Item_Group_Allowed($groups[ $group ])
            )
        {
            //No group found (or group found was not allowed)
            //Localize first allowed data group
            foreach ($groups as $rgroup => $groupdef)
            {
                if ($this->MyMod_Item_Group_Allowed($groups[ $rgroup ]))
                {
                    $group=$rgroup;
                    break;
                }
            }
        }

        return $group;
    }

    
    //*
    //* Return data to display in Data Group
    //*

    function MyMod_Data_Group_Datas_Get($group,$single=FALSE)
    {
        if (empty($group)) { return array(); }

        $groupdefs=$this->MyMod_Data_Group_Defs_Get($single);

        $groupdef=$this->MyMod_Data_Group_Def_Get($group,$single);
        if (!$single)
        {
            $commongroupdef=$this->MyMod_Data_Group_Def_Get("_Common_",$single,False);
        }

        $datas=array();
        foreach (array("Actions","ShowData","Data") as $type)
        {
            $rdatas=$this->GetRealNameKey($groupdef,$type);
            if (is_array($rdatas))
            {
                $datas=array_merge($datas,$rdatas);
            }
        }

        if (!$single && !empty($commongroupdef))
        {
            $rdatas=$this->GetRealNameKey($commongroupdef,"Data");
            if (is_array($rdatas))
            {
                $datas=array_merge($rdatas,$datas);
            }
        }

        if (empty($datas) || !is_array($datas))
        {
            $this->AddMsg("Warning: Group $group has no data defined");
            return array();
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (!is_array($data)) { $data=array($data); }

            foreach ($data as $rdata)
            {
                if (isset($this->ItemData[ $rdata ]))
                {
                    if (!$single && preg_grep('/^'.$rdata.'$/',$this->MyMod_Language_Data))
                    {
                        $rdata.=$this->MyLanguage_GetLanguageKey();
                    }
                    
                    if ($this->MyMod_Access_HashAccess($this->ItemData[ $rdata ],array(1,2)))
                    {
                        array_push($rdatas,$rdata);
                    }
                }
                elseif (isset($this->Actions[ $rdata ]))
                {
                    $action=$data;
                    if ($this->MyAction_Allowed($rdata))
                    {
                        array_push($rdatas,$rdata);
                    }
                    else
                    {
                        if (!empty($this->Actions[ $rdata ][ "AltAction" ]))
                        {
                            $altaction=$this->Actions[ $rdata ][ "AltAction" ];
                            if ($this->MyAction_Allowed($altaction))
                            {
                                array_push($rdatas,$altaction);
                            }
                        }
                    }
                }
                elseif (method_exists($this,$rdata))
                {
                    array_push($rdatas,$rdata);
                }
                elseif (
                          $rdata=="No"
                          ||
                          preg_match('/^newline/',$rdata)
                          ||
                          preg_match('/^text\_/',$rdata)
                       )
                {
                    array_push($rdatas,$rdata);
                }
            }
        }
        
        return $this->MyHash_List_Unique($rdatas);
    }
}

?>