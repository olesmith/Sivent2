<?php


trait MyMod_Actions
{
    //*
    //* function MyMod_Action_IsSingular, Parameter list: $action=""
    //*
    //* Detects whether oMod $action is sinngular or not.
    //*

    function MyMod_HorMenu_IsSingular($action="")
    {
        if (empty($action)) { $action=$this->MyActions_Detect(); }

        if (is_string($action) && !empty($this->Actions[ $action ]))
        {
            $action=$this->Actions[ $action ];
        }

        $res=FALSE;
        if (!empty($action[ "Singular" ]))
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function  MyMod_Item_Action_Icon, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array()
    //*
    //* Generates only action icon.
    //*

    function MyMod_Item_Action_Icon($data,$item)
    {   
        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Download";
        $args[ "ID" ]= $item[ "ID" ];
        $args[ "Data" ]=$data;
                        
        return
            $this->IMG
            (
                "icons/".$this->Actions[ $data ][ "Icon" ],
                $data,
                20,20
            );
    }
    
}

?>