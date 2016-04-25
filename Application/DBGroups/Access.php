<?php

class DBGroupsAccess extends ModulesCommon
{
    var $Access_Methods=array
    (
       "Show"   => "CheckShowAccess",
       "Edit"   => "CheckEditAccess",
       "Delete"   => "CheckDeleteAccess",
    );

    //*
    //* function CheckShowAccess, Parameter list: $item
    //*
    //* Checks if $item may be viewed. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ]
    //* Activated in System::Friends::Profiles.
    //*

    function CheckShowAccess($item)
    {
        $res=FALSE;
        if (preg_match('/^Candidate$/',$this->ApplicationObj->Profile))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->ApplicationObj->LoginData[ "ID" ])
            {
                $res=TRUE;
            }
        }
        elseif (preg_match('/^Assessor$/',$this->ApplicationObj->Profile))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->ApplicationObj->LoginData[ "ID" ])
            {
                $res=TRUE;
            }
        }
        elseif (preg_match('/^Coordinator$/',$this->ApplicationObj->Profile))
        {
            $res=TRUE;
            /* if (!empty($item[ "Unit" ]) && $item[ "Unit" ]==$this->ApplicationObj->LoginData[ "Unit" ]) */
            /* { */
            /*     $res=TRUE; */
            /* } */
        }
        elseif (preg_match('/^Admin$/',$this->ApplicationObj->Profile))
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function CheckEditAccess, Parameter list: $item
    //*
    //* Checks if $item may be edited. Admin may -
    //* and Person, if LoginData[ "ID" ]==$item[ "ID" ].
    //* Activated in  System::Friends::Profiles.
    //*

    function CheckEditAccess($item)
    {
        $res=FALSE;
        if (preg_match('/^Coordinator$/',$this->ApplicationObj->Profile))
        {
            $res=TRUE;
        }
        elseif (preg_match('/^Admin$/',$this->ApplicationObj->Profile))
        {
            $res=TRUE;
        }
 
        return $res;
    }

    //*
    //* function CheckDeleteAccess, Parameter list: $item
    //*
    //* Checks if $item may be deleted. That is:
    //* No questionary data defined - and no inscriptions.
    //*

    function CheckDeleteAccess($item)
    {
        $res=FALSE;

        if (
              $this->CheckEditAccess($item)
              &&
              preg_match('/^(Coordinator|Admin)$/',$this->ApplicationObj->Profile)
           )
        {
            $n=0;//$this->DatasObj()->MySqlNEntries("",array("Group" => $item[ "ID" ]));
            $res=TRUE;
        }
 
        return $res;
    }
}

?>