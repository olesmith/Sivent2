<?php

class Assessors_Statistics extends Assessors_Submission
{
    //*
    //* function Assessors_Statistics_Rows, Parameter list: $event=array()
    //*
    //* Creates Statistics info table rows.
    //*

    function Assessors_Statistics_Rows($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        if (!$this->EventsObj()->Event_Assessments_Has($event)) { return array(); }

        $where=
            array
            (
                "Unit" => $this->Unit("ID"),
                "Event" => $event[ "ID" ],
            );

        $rwhere=$where;
        $rwhere[ "HasAssessed" ]=2;

        $nassessed=1.0*$this->Sql_Select_NHashes($rwhere);
        $sumresult=1.0*$this->Sql_Select_Calc($rwhere,"Result");

        $summedia="-";
        if ($nassessed>0)
        {
            $summedia=sprintf("%.1f",$sumresult/$nassessed);
        }
        
        return
            array
            (
                array
                (
                    $this->H(4,$this->MyMod_ItemsName())
                ),
                $this->B
                (
                    $this->MyLanguage_GetMessage("Assessors_Statistics_TitleRow")
                ),
                array_merge
                (
                    array
                    (
                        $this->Sql_Select_NHashes($where),
                        $nassessed,
                        $this->Sql_Select_Unique_Col_NValues("Friend",$rwhere),
                        $this->Sql_Select_Unique_Col_NValues("Submission",$rwhere),
                        sprintf("%.1f",10.0*$this->CriteriasObj()->Sql_Select_NHashes($where)),
                        $summedia,
                    ),
                    array("")
                ),
            );

    }
}

?>