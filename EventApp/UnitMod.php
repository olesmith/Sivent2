<?php


class UnitMod extends DBDataObj
{
    //*
    //* function Current_User_Coordinator_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Coordinator_Is($unit=array())
    {
        return $this->ApplicationObj()->Current_User_Coordinator_Is($unit);
    }
    
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
    }
    
    //*
    //* function InitActions, Parameter list:
    //*
    //* Overrides MySql2::InitActions.
    //*

    function InitActions()
    {
        parent::InitActions();

        foreach ($this->Access_Methods as $action => $method)
        {
            $this->Actions[ $action ][ "AccessMethod" ]=$method;
        }
    }

    //*
    //* function Current_User_Admin_Is, Parameter list: 
    //*
    //* Returns TRUE if current user is admin.Otherwise FALSE.
    //*

    function Current_User_Admin_Is()
    {
        return $this->ApplicationObj()->Current_User_Admin_Is();
    }

    //*
    //* function UnitWhere, Parameter list: $event=array(),$unit=array()
    //*
    //* Returns Unit => sql where clause.
    //*

    function UnitWhere($where=array(),$unit=array())
    {
        if (empty($unit))  $unit=$this->Unit();

        if (!empty($unit[ "ID" ]))
        {
            $where[ "Unit" ]=$unit[ "ID" ];
        }

        return $where;
    }


    //*
    //* sub Unit, Parameter list: $key=""
    //*
    //* Reads Unit - dies, if not admin and no unit.
    //*
    //*

    function Unit($key="")
    {
        $res=$this->ApplicationObj()->CGI_GET2Hash("Unit","UnitsObj",$key,"Unit",FALSE);

        $action=$this->CGI_GET("Action");
        if (empty($this->ApplicationObj()->Unit)) # && $action!="Start")
        {
            $units=
                $this->UnitsObj()->Sql_Select_Hashes
                (
                    array(),array()
                );

            if (empty($units))
            {
                echo
                    "No Units defined in table ".$this->UnitsObj()->SqlTableName();
                exit();
            }

            $unit=array_shift($units);
            $args="?Unit=".$unit[ "ID" ];
            $this->ApplicationObj()->Application_No_Tail=True;
            
            header( 'Location: ?Unit='.$unit[ "ID" ]);
            exit(1);
        }

        #Check if we should redirect to unit specific server
        if (!empty($this->ApplicationObj()->Unit[ "Sivent2URL" ]))
        {
            $this->ApplicationObj()->Application_No_Tail=True;
            
            header( 'Location: '.$this->ApplicationObj()->Unit[ "Sivent2URL" ]);
            exit(1);            
        }
        
        return $res;
    }

    //*
    //*
    //* function SqlUnitTableName, Parameter list: $module,$table=""
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlUnitTableName($module,$table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName($module,$table);
    }
}

?>