<?php

class InscriptionsTablesAssessments extends InscriptionsTablesSubmissions
{
    /* //\* */
    /* //\* function Inscription_Assessments_Link, Parameter list:  */
    /* //\* */
    /* //\* Creates inscription caravan info row (no details). */
    /* //\* */

    /* function Inscription_Assessments_Link($item) */
    /* { */
    /*     $message="Assessments_Edit_Link"; */
    /*     $where=$this->UnitEventWhere */
    /*     ( */
    /*        array */
    /*        ( */
    /*            $item[ "Friend" ], */
    /*        ) */
    /*     ); */
        
    /*     $nassesments=$this->AssessmentsObj()->Sql_Select_NHashes($where); */

    /*     if ($nassesments>0) */
    /*     { */
    /*         $message="Assessments_Edit_Link"; */
    /*     } */
        
    /*     return $this->Inscription_Type_Link("Assessments",$message); */
    /* } */
    
    /* //\* */
    /* //\* function Inscription_Assessments_Row, Parameter list:  */
    /* //\* */
    /* //\* Creates inscription assessments info row (no details). */
    /* //\* */

    /* function Inscription_Assessments_Row($item) */
    /* { */
    /*     return */
    /*         $this->Inscription_Type_Rows */
    /*         ( */
    /*            $item, */
    /*            "Assessments", */
    /*            $this->Inscription_Assessments_Link($item), */
    /*            array("Assessments","Assessments_StartDate","Assessments_EndDate") */
    /*         ); */
    /* } */
    
    /* //\* */
    /* //\* function Inscription_Assessments_Table, Parameter list:  */
    /* //\* */
    /* //\* Creates inscrition assessments html table. */
    /* //\* */

    /* function Inscription_Assessments_Table($edit,$item,$group="") */
    /* { */
    /*     if ( */
    /*           !$this->Inscriptions_Assessments_Has() */
    /*           || */
    /*           !$this->Inscription_Assessments_Has($item) */
    /*        ) */
    /*     { return array(); } */
        
    /*     if (!$this->Inscriptions_Assessments_Open()) { $edit=0; } */

    /*     var_dump("here"); */
    /*     $type=$this->InscriptionTablesType($item); */
    /*     if ($type!="Assessments") */
    /*     { */
    /*         return $this->Inscription_Assessments_Row($item); */
    /*     } */
        
    /*     $this->AssessmentsObj()->Sql_Table_Structure_Update(); */
        
    /*     $this->AssessmentsObj()->Actions("Edit"); */
    /*     $this->AssessmentsObj()->ItemData("ID"); */
    /*     $this->AssessmentsObj()->ItemDataGroups("Basic"); */
        
    /*     if (empty($group)) { $group="Assessments"; } */
        
    /*     if (empty($this->ItemDataSGroups[ $group ])) */
    /*     { */
    /*         $this->ItemDataSGroups= */
    /*             $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php",$this->ItemDataSGroups); */
    /*     } */
        
    /*     if ($edit==1 && $this->CGI_POSTint("Update")==1) */
    /*     { */
    /*         $this->Inscription_Group_Update($group,$item); */
    /*     } */
        
    /*     return array(array($this->FrameIt($this->Inscription_Assessments_Table_Show($edit,$item)))); */
    /* } */
}

?>