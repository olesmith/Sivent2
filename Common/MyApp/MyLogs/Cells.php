<?php


trait MyLogs_Cells
{
    //*
    //* function Logs_Date_MDay, Parameter list: $date
    //*
    //* Removes first 6 digits from $data.
    //*

    function Logs_Date_MDay($date)
    {
        return preg_replace('/^\d\d\d\d\d\d/',"",$date);
    }

    //*
    //* function Logs_Date_Current_Is, Parameter list: $date
    //*
    //* Returns true if $date is the current (CGI) date.
    //*

    function Logs_Date_Current_Is($date)
    {
        $res=FALSE;
        if ($this->Logs_Date_MDay($date)==$this->Logs_CGI_Date())
        {
            $res=TRUE;
        }

        return $res;
    }

    
    //*
    //* function Logs_Date_Link, Parameter list: 
    //*
    //* Creeates link (or not), for $date.
    //*

    function Logs_Date_Link($date)
    {
        return $this->MyTime_Sort2Date($date);

        
        $args=$this->CGI_URI2Hash();
        $args[ "Date" ]=$this->Logs_Date_MDay($date);
        
        if ($this->Logs_Date_Current_Is($date))
        {
            return $date;
        }

        return
            $this->Href
            (
                "?".$this->CGI_Hash2URI($args),
                $date
            );
    }
    
     //*
    //* function Logs_Time_Cell, Parameter list: $edit=0,$item=array()
    //*
    //* Creeates Time cell (time only).
    //*

    function Logs_Time_Cell($edit=0,$item=array())
    {
        if (empty($item)) { return "Date"; }
        
        return $this->MyTime_Time($item[ "CTime" ]);
    }
    
    
    
    
    //*
    //* function Logs_Cells_Profile_Select, Parameter list: 
    //*
    //* Creates select for current Profile.
    //*

    function Logs_Cells_Profile_Select($where,$date)
    {
        return $this->Logs_CGI_Var_Select($where,"Profile",$date);
    }

    
    
    //*
    //* function Logs_Cells_ModuleName_Select, Parameter list: 
    //*
    //* Creates select for current Module.
    //*

    function Logs_Cells_ModuleName_Select($where,$date)
    {
        return $this->Logs_CGI_Var_Select($where,"ModuleName",$date);
    }
    
    //*
    //* function Logs_Cells_Action_Select, Parameter list: 
    //*
    //* Creates select for current Profiles.
    //*

    function Logs_Cells_Action_Select($where,$date)
    {
        return $this->Logs_CGI_Var_Select($where,"Action",$date);
    }
}

?>