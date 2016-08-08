<?php

include_once("Assessors/Access.php");
include_once("Assessors/Inscription.php");


class Assessors extends AssessorsInscription
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Assessors($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name","Friend","Submission","Result");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Assessors",$table);
    }

   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->PostProcessUnitData();
        $this->PostProcessEventData();
    }

    
    
    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Assessors")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->SubmissionsObj()->ItemExistenceMessage("Submissions");

        return $res;
    }

    
    //*
    //* function Assessor_Assessments_Criterias_Sum_Calc, Parameter list: $assessor,$criterias,$assessments,$weighted=TRUE
    //*
    //* Sums $criterias weights.
    //*

    function Assessor_Assessments_Criterias_Sum_Calc($assessor,$criterias,$assessments,$weighted=TRUE)
    {
        $sum=0.0;
        foreach ($criterias as $criteria)
        {
            if (!empty($assessments[ $assessor[ "Friend" ] ][ $criteria[ "ID" ] ]))
            {
                $value=$assessments[ $assessor[ "Friend" ] ][ $criteria[ "ID" ] ][ "Value" ];
                if ($weighted) { $value*=$criteria[ "Weight" ]; }
                    
                $sum+=1.0*$value;
            }
        }

        if ($weighted && $assessor[ "Result" ]!=$sum)
        {
            $assessor[ "Result" ]=$sum;
            $this->Sql_Update_Item_Value_Set($assessor[ "ID" ],"Result",$sum);
        }
    
        return 1.0*$sum;
    }
    
    //*
    //* function Assessors_Assessments_Criteria_Sum_Calc, Parameter list: $assessor,$criterias,$assessments,$weighted=TRUE
    //*
    //* Sums $criterias weights.
    //*

    function Assessors_Assessments_Criteria_Sum_Calc($assessors,$criteria,$assessments,$weighted=TRUE)
    {
        $sum=0.0;
        foreach ($assessors as $assessor)
        {
            $assessment=array();
            if (!empty($assessments[ $assessor[ "Friend" ] ][ $criteria[ "ID" ] ]))
            {
                $assessment=$assessments[ $assessor[ "Friend" ] ][ $criteria[ "ID" ] ];
                
                $value=$assessments[ $assessor[ "Friend" ] ][ $criteria[ "ID" ] ][ "Value" ];
                if ($weighted) { $value*=$criteria[ "Weight" ]; }
                
                $sum+=1.0*$value;
            }
        }
    
        return 1.0*$sum;
    }

    //*
    //* function Assessor_Assessments_Criterias_Complete, Parameter list: $assessor,$criterias,$assessments,$weighted=TRUE
    //*
    //* Returns TRUE if all $criterias has been assessed.
    //*

    function Assessor_Assessments_Criterias_Complete($assessor,$criterias,$assessments)
    {
        $res=TRUE;
        foreach ($criterias as $criteria)
        {
            if (!empty($assessments[ $criteria[ "ID" ] ]))
            {
                $value=$assessments[ $criteria[ "ID" ] ][ "Value" ];
                if (empty($value)) { $res=FALSE; break; }
            }
        }
   
        return $res;
    }
}

?>