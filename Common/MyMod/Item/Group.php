<?php

include_once("Group/Data.php");
include_once("Group/CGI.php");
include_once("Group/Tables.php");
include_once("Group/Update.php");
include_once("Group/Form.php");

trait MyMod_Item_Group
{
    var $SGroups_NumberItems=FALSE;
    
    use
        MyMod_Item_Group_Data,
        MyMod_Item_Group_CGI,
        MyMod_Item_Group_Tables,
        MyMod_Item_Group_Update,
        MyMod_Item_Group_Form;

    
    //*
    //* Chekcs access to data group.
    //*

    function MyMod_Item_Group_Allowed($groupdef,$item=array())
    {
        $res=FALSE;
        if (!empty($groupdef[ $this->LoginType() ]))
        {
            $res=TRUE;
        }
        elseif (!empty($groupdef[ $this->Profile() ]))
        {
            $res=TRUE;
        }

        if ($res && count($item)>0)
        {
            if (!empty($groupdef[ "AccessMethod" ]))
            {
                $accessmethod=$groupdef[ "AccessMethod" ];
                if (method_exists($this,$accessmethod))
                {
                     return $this->$accessmethod($item);
                }
                else
                {
                    $this->Debug=1;
                    $this->AddMsg("Warning: Invalid group def access method: ".
                                  $accessmethod.", ignored");
                }
            }
        }

        return $res;
    }
    

    //*
    //* Detects if we should edit at least one in $groupdefs.
    //*

    function MyMod_Item_Group_Edit_Should($groupdefs)
    {
        foreach ($groupdefs as $groupdef)
        {
            foreach ($groupdef as $group => $edit)
            {
                if ($edit) { return TRUE; }
            }
        }

        return FALSE;
    }
    
    
    //*
    //* Detects editable groups from $groupdefs.
    //*

    function MyMod_Item_Group_Defs2Groups($groupdefs)
    {
        $groups=array();
        foreach ($groupdefs as $groupdef)
        {
            foreach ($groupdef as $group => $edit)
            {
                if ($edit)
                {
                    array_push($groups,$group);
                }
            }
        }

        return $groups;
    }
}

?>