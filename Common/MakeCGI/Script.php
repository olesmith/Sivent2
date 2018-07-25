<?php


trait MakeCGI_Script
{
    function CGI_Script_Path()
    {
        $scriptname=$_SERVER[ "SCRIPT_NAME" ];
        $comps=preg_split('/\//',$scriptname);
        $name=array_pop($comps);

        return join("/",$comps);
    }

    function CGI_Script_Protocol()
    {
        $protocol="http";
        if (isset($_SERVER[ "HTTPS" ]))
            {
                $protocol.="s";
            }

        return $protocol;
    }

    function CGI_Script_Path_Info()
    {
        $scriptname=$_SERVER[ "REQUEST_URI" ];
        $comps=preg_split('/\?/',$scriptname);

        $info=array_shift($comps);
        if (preg_match('/\.php\/(\S+)$/',$info,$comps))
        {
            $info="/".$comps[1];
        }
        else
        {
            $info="";
        }

        return $info;
    }
    
    function CGI_Script_Extra_Path_Info()
    {
        $pathinfo="";
        if (isset($_SERVER['PATH_INFO']))
        {
            $pathinfo=$_SERVER['PATH_INFO'];
        }
        
        return $pathinfo;
    }
    
    function CGI_Script_Extra_Path_Correction()
    {
        $comps=preg_split('/\//',$this->CGI_Script_Extra_Path_Info());

        $pathinfos=array();
        foreach ($comps as $id => $val)
        {
            if ($val!="")
            {
                array_push($pathinfos,"..");
            }
        }

        $pc="";
        if (count($pathinfos)>0)
        {
            $pc=join("/",$pathinfos);
        }

        return $pc;
    }

    function CGI_Script_Extra_Path_Infos()
    {
        $pathinfo=$this->CGI_Script_Extra_Path_Info();
        $pathinfo=preg_replace('/^\//',"",$pathinfo);

        if ($pathinfo!="")
        {
            return preg_split('/\//',$pathinfo);
        }
        else
        {
            return array();
        }
    }

    function CGI_Script_Name($query="",$scriptname="")
    {
        $scriptname=$_SERVER[ "SCRIPT_NAME" ];
        $comps=preg_split('/\//',$scriptname);
        $name=array_pop($comps);

        return $name;;
    }
    
    function CGI_Script_Exec($query="",$scriptname="")
    {
        if ($scriptname=="") { $scriptname=$this->CGI_Script_Name(); }

        $exec=
            $this->CGI_Script_Protocol().
            "://".
            $this->CGI_Server_Name().
            $this->CGI_Script_Path().
            "/".
            $scriptname.
            $this->CGI_Script_Path_Info();

        if ($query!="") { $exec.="?".$query; }

        $exec=preg_replace('/\s+/',"",$exec);
        return $exec;
    }

    function CGI_Script_Query()
    {
        $scriptname=$_SERVER[ "REQUEST_URI" ];
        $comps=preg_split('/\?/',$scriptname);
        $name=array_pop($comps);

        return $name;
    }
    
    function CGI_Script_Query_Hash($hash=array())
    {
        $args=$this->CGI_Query2Hash($this->CGI_Script_Query());
        foreach ($hash as $key => $value) { $args[ $key ]=$value; }

        return $args;
    }
}
?>