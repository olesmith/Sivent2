<?php


trait MyActions_Access
{
    //*
    //* function MyAction_Allowed, Parameter list: $action,$item=array()
    //*
    //*

    function MyAction_Allowed($action,$item=array())
    {
        if (!$this->Actions) { $this->MyActions_Init(); }

        //When checking for title access, shouldn't take $this->ItemHash as default
        //08/05/2016 if (empty($item) && isset($this->ItemHash)) { $item=$this->ItemHash; }

        $logintype=$this->LoginType;
        if ($logintype=="") { $logintype="Public"; }

        $res=FALSE;
        $actiondef=$this->Actions($action);
        if (!empty($actiondef))
        {
            if (!empty($actiondef[ "AccessMethod" ]))
            {
                $accessmethod=$actiondef[ "AccessMethod" ];
                if (method_exists($this,$accessmethod))
                {
                    if (!empty($actiondef[ "AccessDebug" ]))
                    {
                        var_dump($action.": ".$accessmethod);
                        var_dump($this->Profile().": ".$actiondef[ $this->Profile() ]);
                        var_dump($this->$accessmethod($item));
                    }
                    
                    if (!empty($actiondef[ $this->Profile() ]))
                    {
                        $res=$this->$accessmethod($item);
                    }
                }
                else
                {
                    $this->Debug=1;
                    $this->ApplicationObj()->AddHtmlStatusMessage
                    (
                       $this->ModuleName.": Warning: Invalid access method (action: $action): ".
                       $accessmethod.", ignored"
                    );
                }
            }
            else
            {
                if (!empty($actiondef[ "AccessDebug" ]))
                {
                    var_dump($action.": MyMod_Access_HashAccess");
                    var_dump($this->Profile.": ".$actiondef[ $this->Profile ]);
                    var_dump($this->MyMod_Access_HashAccess($actiondef,array(1,2)));
                }
                
                $res=$this->MyMod_Access_HashAccess($actiondef,array(1,2));
            }
        }

        //var_dump($action.": ".$res);
        return $res;
    }


    //*
    //* function MyAction_Access_Has, Parameter list: $action
    //*
    //* Checks if we have  module access - returns TRUE/FALSE.
    //* Uses $profiledef[ $module ][ "Access" ] to assess if allowed.
    //* If $module is empty or not given, uses $this->ModuleName as module.
    //*

    function MyAction_Access_Has($action)
    {
        return $this->MyAction_Allowed($action);
    }

    //*
    //* function MyAction_Action_RequireAccess, Parameter list: $action
    //*
    //* Requires module access - exits if not.
    //*

    function MyAction_Access_Require($action)
    {
        if ($this->MyAction_Access_Has($action))
        {
            return TRUE;
        }

        $this->MyAction_Error
        (
           "No ".$this->Profile()." access to Action $action",
           ""
        );
    }
}
?>