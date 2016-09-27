<?php


trait MyApp_Interface_LeftMenu_Profile
{
    //*
    //* function MyApp_Interface_LeftMenu_Profile, Parameter list: 
    //*
    //* Prints menu of images, for user to select profile.
    //*

    function MyApp_Interface_LeftMenu_Profile()
    {
        if ($this->LoginType=="Public") { return; }

        $links=array();

        /* $cmodule=$this->CGI_GET("ModuleName"); */
        /* if (!empty($cmodule)) { $cmodule.="Obj"; } */
        /* else                  { $module="ApplicationObj"; } */
        
        /* $caction=$this->CGI_GET("Action"); */
        $action=$this->DefaultAction;

        $args=array("Action" => $action);
        /* if (!empty($cmodule) && $this->$cmodule()->MyAction_Allowed($caction)) */
        /* { */
        /*     $args=$this->CGI_URI2Hash(); */
        /* } */
        
        foreach ($this->MyApp_CGIVars_Compulsory_Vars() as $var => $value)
        {
            $args[ $var ]=$value;
        }
        
        foreach ($this->AllowedProfiles as $id => $profile)
        {
            $pname=$this->MyApp_Profile_Name($profile);
            if ($profile!=$this->Profile)
            {
                $args[ "Profile" ]=$profile;

                if ($profile=="Admin")
                {
                    //$args[ "Action" ]="Start";
                    $args[ "Admin" ]=1;
                }
                elseif ($this->LoginType=="Admin")
                {
                    $args[ "Admin" ]=0;
                }

                array_push
                (
                   $links,
                   $this->MyApp_Interface_LeftMenu_Bullet("+").
                   $this->Href
                   (
                      "?".$this->Hash2Query($args),
                      $pname,
                      "Virar ".$pname,
                      "",
                      "leftmenulinks"
                   )
                );
            }
            else
            {
                array_push($links,"&nbsp;- ".$pname);
            }
        }

        return $links;
    }
}

?>