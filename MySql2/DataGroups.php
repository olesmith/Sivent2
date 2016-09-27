<?php


class DataGroups extends HashesData
{

    //*
    //* Variables of Items class:
    //*

    //var $Singular=TRUE;
    var $ExtraData=array();
    var $ItemDataGroupsCommon=array();
    var $ItemDataGroupNames=array();

    var $ItemDataSGroupsCommon=array();
    var $ItemDataSGroupNames=array();

    //*
    //* Returns permitted data groups, based on $this->LoginTyoe or $this->Profile.
    //* Calls MyMod_Item_Group_Allowed forach item in ItemDataGroups.
    //*

    function GetPermittedDataGroups($plural=TRUE)
    {
        $groups=array();
        if ($plural) { $groups=$this->ItemDataGroups; }
        else         { $groups=$this->ItemDataSGroups; }

        $rgroups=array();
        foreach (array_keys($groups) as $group)
        {
            if ($this->MyMod_Item_Group_Allowed($groups[ $group ]))
            {
                $rgroups[ $group ]=$groups[ $group ];
            }
        }

        return $rgroups;
    }

    //*
    //* Returns permitted data groups, based on $this->LoginTyoe or $this->Profile.
    //* Calls MyMod_Item_Group_Allowed forach item in ItemDataGroups.
    //*

    function DataGroupsMenu($title="",$args=array())
    {
        if (empty($args)) { $args=$this->CGI_URI2Hash(); }

        $currentgroup=$this->GetGET("Group");

        $hrefs=array();
        foreach ($this->GetPermittedDataGroups() as $group => $def)
        {
            $args[ "Group" ]=$group;

            $href=$def[ "Name" ];
            if ($currentgroup!=$group)
            {
               $href=$this->Href
               (
                  "?".$this->CGI_Hash2URI($args),
                  $def[ "Name" ]
                );
            }
            array_push($hrefs,$href);
        }

        if (count($hrefs)==0) { return ""; }

        return $this->Center
        ( 
            $title.
            "[ ".
            join(" | ",$hrefs).
            " ]"
        );
    }

    //*
    //* Skips not permitted data groups, based on $this->LoginTyoe or $this->Profile.
    //* Calls MyMod_Item_Group_Allowed forach item in 
    //*

    function SkipForbiddenDataGroups()
    {
        foreach (array_keys($this->ItemDataGroups) as $group)
        {
            if (!$this->MyMod_Item_Group_Allowed($this->ItemDataGroups[ $group ]))
            {
                unset($this->ItemDataGroups[ $group ]);
            }
        }

        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (!$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ]))
            {
                unset($this->ItemDataSGroups[ $group ]);
            }
        }
    }

    //*
    //* Add DataGroup
    //*

    function AddItemDataGroup($group,$groupdef,$plural=TRUE)
    {
        
        $this->MyMod_Data_Group_Defaults_Take($groupdef);
        if ($plural)
        {
            $this->ItemDataGroups[ $group  ]=$groupdef;
        }
        else
        {
            $this->ItemDataSGroups[$group  ]=$groupdef;
        }
    }


    //*
    //* Return object data group CGI Var var.
    //*

    function GroupDataCGIVar()
    {
        return $this->ModuleName."_GroupName";
    }

    //*
    //* Return object data group CGI Var var.
    //*

    function GroupDataEditListVar()
    {
        return $this->ModuleName."_Edit";
    }

    //*
    //* Return object data group CGI Var var.
    //*

    function GroupDataPageVar()
    {
        return $this->ModuleName."_Page";
    }

    //*
    //* Return object data group var, that is:
    //* ItemDataSGroups if Singular, elsewise ItemDataGroups
    //*

    function GetDataGroups($single=FALSE)
    {
        $this->MyMod_Data_Groups_Initialize();
        if (($this->Singular || $single) && count($this->ItemDataSGroups)>0)
        {
            return $this->ItemDataSGroups;
        }
        else
        {
            return $this->ItemDataGroups;
        }
    }

    //*
    //* Return object data group names var
    //*

    function GetDataGroupNames()
    {
        if ($this->Singular)
        {
            return $this->ItemDataSGroupNames;
        }
        else
        {
            return $this->ItemDataGroupNames;
        }
    }

    //*
    //* Return object data group common data var
    //*

    function GetDataGroupsCommon()
    {
        if ($this->Singular)
        {
            if (isset($this->ItemDataSGroupsCommon[ $this->LoginType ]))
            {
                return $this->ItemDataSGroupsCommon[ $this->LoginType ];
            }
            elseif (isset($this->ItemSDataSGroupsCommon[ $this->Profile ]))
            {
                return $this->ItemDataSGroupsCommon[ $this->Profile ];
            }
        }
        else
        {
            if (isset($this->ItemDataGroupsCommon[ $this->LoginType ]))
            {
                return $this->ItemDataGroupsCommon[ $this->LoginType ];
            }
            elseif (isset($this->ItemDataGroupsCommon[ $this->Profile ]))
            {
                return $this->ItemDataGroupsCommon[ $this->Profile ];
            }
        }

        return array();
    }

    //*
    //* Return current Data Group
    //*

    function GetActualDataGroup()
    {
        $this->PostInitItems();

        if ($this->CurrentDataGroup!="")
        {
            $group=$this->CurrentDataGroup;
        }
        else
        {
            $group=$this->GetCGIVarValue($this->GroupDataCGIVar());
        }

        $groups=$this->GetDataGroups();
        if (!preg_grep('/^'.$group.'$/',array_keys($groups)))
        {
            $group="";
        }

        if  (
               $group==""
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

    function GetGroupDatas($group,$single=FALSE)
    {
        if ($group=="") { return array(); }

        $groups=$this->GetDataGroups($single);
        
        $groupscommon=array();
        if (!$single) { $groupscommon=$this->GetDataGroupsCommon(); }

        $rdatas=array();
        if (count($groupscommon)>0)
        {
            foreach ($groupscommon as $id => $data)
            {
                array_push($rdatas,$data);
            }
        }

        if (!isset($groups[ $group ]) || !is_array($groups[ $group ]))
        {
            echo $this->ModuleName." Warning: Group $group undefined";
            $this->AddMsg("Warning: Group $group undefined");
            return array();
        }

        $datas=$this->GetRealNameKey($groups[ $group ],"Data");

        //if (!isset($groups[ $group ][ "Data" ]) || !is_array($groups[ $group ][ "Data" ]))
        if (empty($datas) || !is_array($datas))
        {
            //echo $this->ModuleName." Warning: Group ".$groups[ $group ][ "Name" ]." has no data defined";
            $this->AddMsg("Warning: Group $group has no data defined");
            return array();
        }

        $rgroups=array();
        foreach (array("Actions","ShowData","Data") as $type)
        {
            $datas=$this->GetRealNameKey($groups[ $group ],$type);
            
            if (!empty($datas) && is_array($datas))
            {
                $rgroups=array_merge($rgroups,$datas);
            }
        }

        foreach ($rgroups as $id => $data)
        {
            if (!is_array($data)) { $data=array($data); }

            foreach ($data as $rdata)
            {
                if (isset($this->ItemData[ $rdata ]))
                {
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
        
        return $rdatas;
    }

    function GetGroupReadData($group)
    {
        $datas=$this->GetGroupDatas($group);
        $groups=$this->GetDataGroups();

        //Datas that we need to have read (for some reason)
        foreach ($this->ExtraData as $n => $data)
        {
             array_push($datas,$data);
        }

        if (is_array($groups[$group][ "ExtraData" ]))
        {
            foreach ($groups[$group][ "ExtraData" ] as $n => $data)
            {
                if (!preg_grep('/^'.$data.'$/',$datas))
                {
                    array_push($datas,$data);
                }
            }
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (is_array($this->ItemData[ $data ]) && !$this->ItemData[ $data ][ "IsDerived" ])
            {
                if (!preg_grep('/^'.$data.'$/',$rdatas))
                {
                    array_push($rdatas,$data);
                }
            }
        }

        return $rdatas;
    }


    function GetActualDataGroupDatas()
    {
        $group=$this->GetActualDataGroup();
        return $this->GetGroupReadData($group);
    }


    function GetDefaultDataGroup()
    {
        $groupnames=$this->GetDataGroupNames();

        $logintype=$this->LoginType;

        $groupname="";
        foreach ($groupnames as $id => $group)
        {
            if (!$this->Singular)
            {
                if ($this->MyMod_Item_Group_Allowed($this->ItemDataGroups[$group ]))
                {
                    $groupname=$group;
                }
            }
            else
            {
                if ($this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[$group ]))
                {
                    $groupname=$group;
                }
            }
        }

        $datas=$this->GetGroupDatas($groupname);

        return $datas;
    }

    function ItemGroupURL($groupname)
    {
        $groups=$this->GetDataGroups();

        $hash=array("Action" => $this->MyActions_Detect());

        
        $hash[ $this->GroupDataCGIVar() ]=$groupname;
        if ($this->GetGETOrPOST("ID")>0)
        {
            $hash[ "ID" ]=$this->GetGETOrPOST("ID");
        }

        if ($this->GetGETOrPOST("EditList")>0)
        {
            //$hash[ "EditList" ]=1;
        }

        $link="?".$this->Hash2Query($hash);

        return $link;
    }


    function ItemGroupHidden($groupname="")
    {
        if (empty($groupname)) { $groupname=$this->GetActualDataGroup(); }

        return $this->MakeHidden($this->GroupDataCGIVar(),$groupname);
    }

    function ItemEditListHidden($edit)
    {
        return $this->MakeHidden($this->GroupDataEditListVar(),2);
    }

    function ItemPageHidden($edit)
    {
        //Page var included in FROM URL.
        return "";

        /* return $this->MakeHidden */
        /* ( */
        /*    $this->GroupDataPageVar(), */
        /*    $this->GetGETOrPOST($this->GroupDataPageVar()) */
        /* ); */
    }

    //*
    //* function DataGroupsSearchField, Parameter list: $data
    //*
    //* Creates select fields do choose data group
    //*

    function DataGroupsSearchField()
    {
        $values=array();
        $names=array();
        $titles=array();
        foreach ($this->GetDataGroups() as $groupid => $group)
        {
            //Check if group allowed
            if ($this->MyMod_Item_Group_Allowed($group) && $this->GetRealNameKey($group,"Name")!="")
            {
                array_push($values,$groupid);
                array_push($names,$this->GetRealNameKey($group));
                array_push($titles,$this->GetRealNameKey($group,"Title"));
            }
        }

        if (count($values)==0) { return ""; }

        return
            $this->MakeSelectField
            (
               $this->ModuleName."_GroupName",
               $values,
               $names,
               $this->GetActualDataGroup(),//$this->GetCGIVarValue($this->ModuleName."_GroupName"),
               array(),//disableds
               $titles,
               $this->MyLanguage_GetMessage("DataGroupsTitle","Title")
            );
    }  


    //*
    //* function HashList2ItemDataGroups, Parameter list: $hashdata,$datakey,$ndata,$commondatas=array(),$filterhash=array(),$newline=0
    //*
    //* Adds $ndata datagroups defined in $hashdata to 
    //* $this->ItemDataGroups.
    //* If $hashdata is a string, tries to read item hashes from this as a file.
    //*

    function HashList2ItemDataGroups($hashdata,$datakey,$ndata,$groupdef,$commondatas=array(),$filterhash=array())
    {
        if (!is_array($hashdata))
        {
            $hashdata=$this->ReadPHPArray($hashdata);
        }

        if (!preg_match('/_$/',$datakey)) { $datakey.="_"; }

        for ($n=1;$n<=$ndata;$n++)
        {
            $datas=array();
            $rgroupdef=$groupdef;

            $rfilterhash=$filterhash;
            foreach ($rfilterhash as $key => $value)
            {
                $rfilterhash[ $key ].=" ".$n;
            }
            $rfilterhash[ "N" ]=$n;

            foreach ($hashdata as $data => $datadef)
            {
                $key=$datakey.$n."_".$data;

                array_push($datas,$key);
            }

            foreach ($rgroupdef as $key => $value)
            {
                if (is_string($value))
                {
                    $rgroupdef[ $key ]=$this->FilterHash($value,$rfilterhash);
                }
            }

            $rgroupdef[ "Data" ]=$datas;
            $this->ItemDataSGroups[ $datakey.$n ]=$rgroupdef;
            $rgroupdef[ "Data" ]=array_merge($commondatas,$datas);
            $this->ItemDataGroups[ $datakey.$n ]=$rgroupdef;
        }
   }
}
?>