<?php


trait MyActions_Add
{
    //*
    //* function MyActions_AddFiles, Parameter list: $files
    //*
    //* Adds action files.
    //*

    function MyActions_AddFiles($files)
    {
        $n=1;
        $actionkeys=array();
        foreach ($files as $file)
        {
            $actionkeys=array_merge
            (
               $actionkeys,
               $this->MyActions_AddFile($file,$n++)
            );
        }

        return $actionkeys;
    }

    //*
    //* function MyActions_AddFile, Parameter list: $file,$n=0
    //*
    //* Adds actions
    //*

    function MyActions_AddFile($file,$n=0)
    {
        $actions=$this->ReadPHPArray($file);
        $this->MyActions_AddActions($actions,$file,$n);

        return array_keys($actions);
    }


    //*
    //* function MyActions_AddActions, Parameter list: $actions,$file
    //*
    //* Adds actions
    //*

    function MyActions_AddActions($actions,$file,$n)
    {
        //$this->MyActions_AddDefaultKeys($actions);

        foreach (array_keys($actions) as $action)
        {
            if (empty($this->Actions[ $action ]))
            {
                $this->MyAction_AddDefaultKeys($actions[ $action ]);
            }
            
            $this->MyAction_Add($action,$actions[ $action ]);
            $this->Actions[ $action ][ "Action" ]=$action;
            $this->Actions[ $action ][ "File" ]=$file;
            $this->Actions[ $action ][ "N" ]=$n;
        }
        
        return array_keys($actions);
    }

    //*
    //* function MyAction_Add, Parameter list: $action
    //*
    //* Adds $action.
    //*

    function MyAction_Add($action,$hash)
    {
        if (!isset($this->Actions[ $action ]))
        {
            $this->Actions[ $action ]=$hash;
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                if (!empty($value))
                {
                    $this->Actions[ $action ][ $key ]=$value;
                }
                elseif (!empty($this->ApplicationObj()->Profiles[ $key ]))
                {
                    $this->Actions[ $action ][ $key ]=$value;
                }
            }
         }
    }
}

?>