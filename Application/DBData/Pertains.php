<?php


class DBDataPertains extends DBDataAccess
{
    //*
    //* function SetPertains, Parameter list:
    //*
    //* Sets $this->Pertains.
    //*

    function SetPertains()
    {
        $action=$this->CGI_GET("Action");

        foreach ($this->ApplicationObj()->PertainsSetup as $pertains => $def)
        {
            $raction=$def[ "Data_Action" ];
            if (preg_match('/^'.$raction.'/',$action))
            {
                $this->ApplicationObj()->Pertains=$pertains;
                break;
            }
        }

        return $this->ApplicationObj()->Pertains;
    }
    
    //*
    //* function DBDataObj, Parameter list: 
    //*
    //* Returns quest object, Inscriptions or Assessments.

    //*

    function DBDataObj($force=FALSE)
    {
        $def=$this->ApplicationObj()->PertainsSetup[ $this->ApplicationObj()->Pertains ];
        $obj=$def[ "Object_Accessor" ];

        return $this->$obj($force);
    }

}

?>