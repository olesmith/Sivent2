<?php

include_once("Assessments/Access.php");


class Assessments extends AssessmentsAccess
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Assessments($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name","Name_UK","Weight");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Assessments",$table);
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
        if ($module!="Assessments")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        if (empty($item[ "Name_UK" ]))
        {
            $item[ "Name_UK" ]=$item[ "Name" ];
            array_push($updatedatas,"Name_UK");
        }
 
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
        $res=$this->ItemExistenceMessage();
        if ($res)
        {
            $res=$this->SubmissionsObj()->ItemExistenceMessage("Submissions");
        }

        return $res;
    }

    
    //*
    //* function Assessment_Criteria_Assessor_CGI_Key, Parameter list: $criteria,$assessor
    //*
    //* Returns name of assessment cgi key.
    //*

    function Assessment_Criteria_Assessor_CGI_Key($criteria,$assessor)
    {
        return $criteria[ "ID" ]."_".$assessor[ "ID" ]."_Value";
    }
    
    //*
    //* function Assessment_Cells, Parameter list: $edit,$criteria,$assessor,$assessment
    //*
    //* Prints warning messages.
    //*

    function Assessment_Cells($edit,$criteria,$assessor,$assessment)
    {
        $weighted="-";
        if (!empty($assessment[ "Value" ]))
        {
            $weighted=1.0*$criteria[ "Weight" ]*$assessment[ "Value" ];
        }

        
        
        return array
        (
            $this->MyMod_Data_Fields_Edit
            (
               "Value",
               $assessment,
               "",
               "",
               TRUE,
               $links=TRUE,
               $callmethod=TRUE,
               $this->Assessment_Criteria_Assessor_CGI_Key($criteria,$assessor)
            ),
            sprintf("%.1f",$weighted)
        );
    }

    
    //*
    //* function Assessments_Criteria_Assessor_Where, Parameter list: $criteria,$assessor
    //*
    //* Generates sql where hash for $submission $criteria and $assessor;
    //*

    function Assessments_Criteria_Assessor_Where($criteria,$assessor)
    {
        return
            $this->UnitEventWhere
            (
               array
               (
                  "Submission" => $assessor[ "Submission" ],
                  "Criteria"   => $criteria[ "ID" ],
                  "Friend"     => $assessor[ "Friend" ],
               )
            );
    }
    
    //*
    //* function Assessments_Criteria_Assessor_New, Parameter list: $criteria,$assessor,$value=0.0
    //*
    //* Returns new assessments item for $submission, $criteria and $assessor
    //*

    function Assessments_Criteria_Assessor_New($criteria,$assessor,$value=0.0)
    {
        $assessment=$this->Assessments_Criteria_Assessor_Where($criteria,$assessor);
        $assessment[ "Value" ]=$value;
        
        return $assessment;
    }

    
    //*
    //* function Assessments_Submission_Criteria_Assessor_Update, Parameter list: $criteria,$assessor,&$assessment
    //*
    //* Updates  $submission, $criteria and $assessor assessment field.
    //*

    function Assessments_Criteria_Assessor_Update($criteria,$assessor,&$assessment)
    {
        $key=$this->Assessment_Criteria_Assessor_CGI_Key($criteria,$assessor);
        $newvalue=$this->CGI_POSTint($key);

        $updated=FALSE;
        if (empty($assessment))
        {
            //We should add
            $nassessments=
                $this->Sql_Select_NHashes
                (
                   $this->Assessments_Criteria_Assessor_Where($criteria,$assessor)
                );
            
            if ($nassessments==0)
            {
                $assessment=$this->Assessments_Criteria_Assessment_New($criteria,$assessor,$newvalue);
                $this->Sql_Insert_Item($assessment);
                //var_dump("ins");
               
                $updated=TRUE;
            }                    
        }
        else
        {
            if ($newvalue!=$assessment[ "Value" ])
            {
                $assessment[ "Value" ]=$newvalue;
                $this->Sql_Update_Item_Value_Set
                (
                   $assessment[ "ID" ],
                   "Value",
                   $newvalue
                );
                //var_dump("upd");
                $updated=TRUE;
            }
            //else var_dump("unchsnged");
        }
        
        return $updated;
    }

    //*
    //* function Assessments_Submission_Criterias_Assessor_Update, Parameter list: $submission,$criterias,$assessor,&$assessments
    //*
    //* Updates  $submission, $criterias and $assessor assessment fields.
    //*

    function Assessments_Criterias_Assessor_Update($criterias,&$assessor,&$assessments)
    {
        $updated=FALSE;

        $wsum=0.0;
        foreach ($criterias as $criteria)
        {
            $assessment=array();
            if (empty($assessments[ $criteria[ "ID" ] ]))
            {
                $assessments[ $criteria[ "ID" ] ]=array();
            }

            $updated=
                $updated
                ||
                $this->Assessments_Criteria_Assessor_Update($criteria,$assessor,$assessments[ $criteria[ "ID" ] ]);
            
            $wsum+=1.0*$criteria[ "Weight" ]*$assessments[ $criteria[ "ID" ] ][ "Value" ];
        }

        $this->Sql_Select_Hash_Datas_Read($assessor,array("Result","HasAssessed","HasAccessed"));
        
        $updatedatas=array();
        if ($assessor[ "Result" ]!=$wsum)
        {
            $assessor[ "Result" ]=$wsum;
            array_push($updatedatas,"Result");
        }

        $complete=$this->AssessorsObj()->Assessor_Assessments_Criterias_Complete($assessor,$criterias,$assessments);

        if ($complete) $complete=2;
        else           $complete=1;
        

        if ($assessor[ "HasAssessed" ]!=$complete)
        {
             $assessor[ "HasAssessed" ]=$complete;
             array_push($updatedatas,"HasAssessed");
        }
       
        if (empty($assessor[ "HasAccessed" ]) || $assessor[ "HasAccessed" ]!=2)
        {
            if ($this->LoginData("ID")==$assessor[ "Friend" ] )
            {
                $assessor[ "HasAccessed" ]=2;
                array_push($updatedatas,"HasAccessed");
            }
        }
       
        
        if (count($updatedatas)>0)
        {
            $this->AssessorsObj()->Sql_Update_Item_Values_Set
            (
               $updatedatas,
               $assessor
            );
        }
        
        return $updated;
    }
}

?>