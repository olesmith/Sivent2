<?php


trait MyLogs_Hosts
{
    #Store to prevent multiple lookups.
    var $__Hosts__=array();
    
    //*
    //* function , Parameter list: $ip
    //*
    //* Reads login name from $friend.
    //*

    function Logs_Info_Host_Read($ip)
    {
        if (!empty($ip) && empty($this->__Hosts__[ $ip ]))
        {
            $this->__Hosts__[ $ip  ]=
                array
                (
                    "IP" => $ip,
                    "Host" => gethostbyaddr($ip),
                );        

            return $this->__Hosts__[$ip  ];
        }

        return array("IP" => "-","Host" => "-");
    }

    
    //*
    //* function Logs_Info_Host_Name, Parameter list: $ip
    //*
    //* Returns hostname for $ip.
    //*

    function Logs_Info_Host_Name($ip)
    {
        $host=$this->Logs_Info_Host_Read($ip);
        
        return $host[ "Host" ];
    }

    
    //*
    //* function Logs_Cells_IP_Select, Parameter list: 
    //*
    //* Creates select for current IPs.
    //*

    function Logs_Cells_IP_Select($where,$date)
    {
        return  $this->Logs_CGI_Var_Select($where,"IP",$date,"","Logs_Info_Host_Name");
    }

}

?>