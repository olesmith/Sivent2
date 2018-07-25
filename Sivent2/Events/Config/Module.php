<?php

trait Events_Config_Module
{
    function Event_Config_Module_Rows($group,$module,$odd=False)
    {
        $moduleobj=$module."Obj";
        
        return
            array
            (
                array_merge
                (
                    $this->Event_Config_Module_Actions_Row($group,$module,"Config_Group_Pre_Actions",$odd),
                    $this->Event_Config_Module_Row($group,$module),
                    $this->Event_Config_Module_Actions_Row($group,$module,"Config_Group_Post_Actions",$odd)
                )
                    
            );
    }
    
    function Module_2_Object($module)
    {
       $method=$module."Obj";
       return $this->$method();
    }
    
    function Event_Config_Module_Row($group,$module)
    {
        $moduleobj=$module."Obj";
        
        return
            array
            (
                $module,
                $this->Module_2_Object($module)->MyMod_ItemName("ItemsName"),
                $this->Module_2_Object($module)->SqlTableName(),
                $this->Module_2_Object($module)->Sql_Select_NHashes(),
            );
    }
    
    function Event_Config_Module_Actions_Row($group,$module,$key,$odd=False)
    {
        $row=array();
        foreach ($this->Event_Config($key) as $action)
        {
            array_push
            (
                $row,
                $this->Module_2_Object($module)->MyActions_Entry_OddEven($odd,$action)
            );
        }        
        
        return array($row);
    }
}

?>