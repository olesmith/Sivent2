<?php

class DBDataAccess extends ModulesCommon
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
        if (preg_match('/^Candidate$/',$this->Profile()))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->ApplicationObj->LoginData[ "ID" ])
            {
                $res=TRUE;
            }
        }
        elseif (preg_match('/^Assessor$/',$this->Profile()))
        {
            if (!empty($item[ "ID" ]) && $item[ "ID" ]==$this->ApplicationObj->LoginData[ "ID" ])
            {
                $res=TRUE;
            }
        }
        elseif (preg_match('/^Coordinator$/',$this->Profile()))
        {
            $res=TRUE;
        }
        elseif (preg_match('/^Admin$/',$this->Profile()))
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
        if (preg_match('/^Coordinator$/',$this->Profile()))
        {
            $res=TRUE;
        }
        elseif (preg_match('/^Admin$/',$this->Profile()))
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
              preg_match('/^(Coordinator|Admin)$/',$this->Profile())
           )
        {
            $res=TRUE;
            if ($this->DBDataObj()->Sql_Table_Exists())
            {
                if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ "SqlKey" ]))
                {
                    if ($this->DBDataObj()->MySqlNEntries()>0)
                    {
                        $res=FALSE;
                    }
                }
            }
        }
 
        return $res;
    }
}

?>