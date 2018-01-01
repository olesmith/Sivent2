<?php


trait MyLogs_CGI
{
    var $__CGI__=array();
        
    //*
    //* function Logs_CGI_Table, Parameter list: 
    //*
    //* Detects SQL table from CGI.
    //*

    function Logs_CGI_Table()
    {
        if (empty($this->__CGI__[ "Table" ]))
        {
            $year=$this->Logs_CGI_Year();
            $month=$this->Logs_CGI_Month();

            if (!empty($year) && !empty($month))
            {
                return join("__",array($year,sprintf("%02d",$month),"Logs"));
            }
        }

        return "";
    }
    
    //*
    //* function Logs_CGI_IP, Parameter list: 
    //*
    //* Detects selected IP.
    //*

    function Logs_CGI_IP()
    {
        if (empty($this->__CGI__[ "IP" ]))
        {
            $this->__CGI__[ "IP" ]=$this->CGI_POSTint("Logs_IP");
        }

        return $this->__CGI__[ "IP" ];
    }
    
    //*
    //* function Logs_CGI_Profile, Parameter list: 
    //*
    //* Detects selected Profile.
    //*

    function Logs_CGI_Profile()
    {
        if (empty($this->__CGI__[ "Profile" ]))
        {
            $this->__CGI__[ "Profile" ]=$this->CGI_POST("Logs_Profile");
        }

        return $this->__CGI__[ "Profile" ];
    }
    
    //*
    //* function Logs_CGI_Login, Parameter list: 
    //*
    //* Detects selected Login.
    //*

    function Logs_CGI_Login()
    {
        if (empty($this->__CGI__[ "Login" ]))
        {
            $this->__CGI__[ "Login" ]=$this->CGI_POSTint("Logs_Login");
        }

        return $this->__CGI__[ "Login" ];
    }
    
    //*
    //* function Logs_CGI_ModuleName, Parameter list: 
    //*
    //* Detects selected ModuleName.
    //*

    function Logs_CGI_ModuleName()
    {
        if (empty($this->__CGI__[ "Module" ]))
        {
            $this->__CGI__[ "Module" ]=$this->CGI_POST("Logs_ModuleName");
        }

        return $this->__CGI__[ "Module" ];
    }
    
    //*
    //* function Logs_CGI_Action, Parameter list: 
    //*
    //* Detects selected Action.
    //*

    function Logs_CGI_Action()
    {
        if (empty($this->__CGI__[ "Action" ]))
        {
            $this->__CGI__[ "Action" ]=$this->CGI_POST("Logs_Action");
        }

        return $this->__CGI__[ "Action" ];
    }
    
    
    //*
    //* function Logs_Period_School, Parameter list: 
    //*
    //* Detects selected Period.
    //*

    function Logs_CGI_Period()
    {
        if (empty($this->__CGI__[ "Period" ]))
        {
            $this->__CGI__[ "Period" ]=$this->CGI_POSTint("Logs_Period");
        }

        return $this->__CGI__[ "Period" ];
    }
    
    //*
    //* function Logs_CGI_Var2Where, Parameter list: 
    //*
    //* Returns $where clause for $date.
    //*

    function Logs_CGI_Var_Where($date,$where)
    {
        $month=preg_replace('/\d\d$/',"",$date);
        return $this->Logs_Month_Sql_Where($month,$where);
    }
    
    //*
    //* function Logs_CGI_Var_Select, Parameter list: 
    //*
    //* Returns $where cladue for $var.
    //*

    function Logs_CGI_Var_Select($where,$cgivar,$date,$namemethod="",$titlemethod="",$readmethod="")
    {
        $cgivalue=$this->CGI_POST("Logs_".$cgivar);

        $accessor="Logs_CGI_".$cgivar;
        $value=$this->$accessor();

        $where=$this->Logs_CGI_Var_Where($date,$where);

        $values=$this->Sql_Select_Unique_Col_Values($cgivar,$where,"ID");

        if (!empty($readmethod))
        {
            $values=array_keys($this->$readmethod($date,$values));
        }

        $values=preg_grep('/\S/',$values);
        #sort($values);
        array_unshift($values,"");

        $valuenames=array();
        if (!empty($namemethod))
        {
            foreach ($values as $value)
            {
                if (!empty($value))
                {
                    $value=$this->$namemethod($value);
                }

                array_push($valuenames,$value);

                
            }
        }
        else { $valuenames=$values; }

        
        $valuetitles=array();
        if (!empty($titlemethod))
        {
            foreach ($values as $value)
            {
                $tvalue=$this->$titlemethod($value);
                array_push($valuetitles,$tvalue);
            }
        }
        
        return $this->MakeSelectField("Logs_".$cgivar,$values,$valuenames,$cgivalue,array(),$valuetitles);
    }

}

?>