<?php


class InscriptionsHandle extends InscriptionsCertificates
{
    
    //*
    //* Overrides MytSql2::Delete.
    //* Deletes associated assesments first, then calls parent.
    //*

    function Delete_disabled($item=array(),$echo=TRUE)
    {
        $assessments=$this->AssessmentsObj()->Sql_Select_Hashes
        (
           array
           (
              "Inscription" => $item[ "ID" ],
           )
        );

        foreach ($assessments as $assessment)
        {
            $this->AssessmentsObj()->Sql_Delete_Item
            (
               $assessment[ "ID" ],
               "ID",
               $this->AssessmentsObj()->SqlTableName()
            );
        }
        
        parent::Delete($item,$echo);
    }
}

?>