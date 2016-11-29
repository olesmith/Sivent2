<?php



class Assessors_Submission extends Assessors_Inscription
{
    //*
    //* function Assessor_Submission_Complete, Parameter list: $submission,&$assessor
    //*
    //* Returns TRUE if all $assessor $criterias has been assessed.
    //*

    function Assessor_Submission_Complete($submission,&$assessor)
    {
        $res=TRUE;
        if (count($this->Criterias())==0) { $res=FALSE; }

        $assessments=
            $this->AssessmentsObj()->Assessments_Submission_Assessor_Criterias_Read
            (
                $submission,
                $assessor
            );
        
        $ndefined=0;
        $sum=0.0;
        foreach ($assessments  as $assessment)
        {
            if (!empty($assessment[ "Value" ]))
            {
                $ndefined++;
                $sum+=
                    $this->Criterias($assessment[ "Criteria" ],"Weight")
                    *
                    $assessment[ "Value" ];
            }
        }

        $res=FALSE;
        if ($ndefined==$this->Criterias_N()) { $res=TRUE; }
        else                                { $sum=0; }

        $complete=1;
        if ($res) $complete=2;

        $updatedatas=array();
        
        if ($assessor[ "HasAssessed" ]!=$complete)
        {
             $assessor[ "HasAssessed" ]=$complete;
             array_push($updatedatas,"HasAssessed");
        }
        
        if ($assessor[ "Result" ]!=$sum)
        {
             $assessor[ "Result" ]=$sum;
             array_push($updatedatas,"Result");
        }

        if (empty($assessor[ "HasAccessed" ]) || $assessor[ "HasAccessed" ]!=2)
        {
            if ($this->LoginData("ID")==$assessor[ "Friend" ] )
            {
                $assessor[ "HasAccessed" ]=2;
                array_push($updatedatas,"HasAccessed");
            }
        }
       
        if (!empty($updatedatas))
        {
             var_dump($updatedatas);
       
             $this->AssessorsObj()->Sql_Update_Item_Values_Set
             (
                 $updatedatas,
                 $assessor
             );
        }

        return $res;
    }
    
    //*
    //* function Assessors_Submission_HasAssesed, Parameter list: $assessors
    //*
    //* Returns list of $assessors that has assessed (completed).
    //*

    function Assessors_Submission_HasAssesed($assessors)
    {
        $assessorids=array();
        foreach ($assessors as $assessor)
        {
            if ($assessor[ "HasAssessed" ]==2)
            {
                array_push($assessorids,$assessor[ "Friend" ]);
            }
        }

        return $assessorids;
    }
        
    //*
    //* function Assessor_Assessments_Criterias_Sum_Calc, Parameter list: $assessor,$submission,$weighted=TRUE
    //*
    //* Sums $criterias weights.
    //*

    function Assessor_Submission_Criterias_Sum_Calc_000($assessor,$submission,$weighted=TRUE)
    {
        $sum=0.0;
        if ($assessor[ "HasAssessed" ]==2)
        {
            $assessments=
                $this->Assessments_Submission_Assessor_Criterias_Read($submission,$assessor);
       
            foreach ($assessments  as $assessment)
            {
                $value=$assessment[ "Value" ];
                if ($weighted)
                {
                    $value*=$this->Criterias_Weight($assessment[ "Criteria" ]);
                }
                    
                $sum+=$value;
            }
        }
        
        if ($weighted && $assessor[ "Result" ]!=$sum)
        {
            $assessor[ "Result" ]=$sum;
            $this->Sql_Update_Item_Value_Set($assessor[ "ID" ],"Result",$sum);
        }

        return $sum;
    }
    
    //*
    //* function Assessors_Assessments_Criteria_Sum_Calc, Parameter list: $assessors,$submission,$criteria,$weighted=TRUE
    //*
    //* Sums $criterias weights.
    //*

    function Assessors_Submission_Criteria_Sum_Calc($assessors,$submission,$criteria,$weighted=TRUE)
    {
        $assessments=
            $this->AssessmentsObj()->Sql_Select_Hashes
            (
                array
                (
                    "Submission" => $submission[ "ID" ],
                    "Criteria"   => $criteria[ "ID" ],
                    "Friend"     => $this->Sql_Where_IN
                    (
                        $this->Assessors_Submission_HasAssesed($assessors)
                    ),
                ),
                array("Value")
            );
        
        $sum=0.0;
        foreach ($assessments  as $assessment)
        {
            $sum+=$assessment[ "Value" ];
        }
        
        if ($weighted) { $sum*=$criteria[ "Weight" ]; }

        return $sum;
    }

    //*
    //* function Assessors_Assessments_Criteria_Media_Calc, Parameter list: $assessors,$submission,$criteria,$weighted=TRUE
    //*
    //* Sums $criterias weights.
    //*

    function Assessors_Submission_Criteria_Media_Calc($assessors,$submission,$criteria,$weighted=TRUE)
    {
        $hasassessed=count($this->Assessors_Submission_HasAssesed($assessors));
        if (empty($hasassessed)) { return "-"; }
        
        $media=
            $this->Assessors_Submission_Criteria_Sum_Calc($assessors,$submission,$criteria,$weighted)
            /
            (1.0*$hasassessed);

        return sprintf("%.1f",$media);
    }
    
    //*
    //* function Assessors_Submission_Media, Parameter list: $submission,$assessors,$weighted=TRUE
    //*
    //* Generate summed row media, summing over $criterias and $assessors.
    //*

    function Assessors_Submission_Media($submission,$assessors,$weighted=TRUE)
    {
        $ncriterias=1.0*$this->Criterias_N();
        if (empty($ncriterias)) { return "-"; }
        
        /* $sum=0.0; */
        /* foreach ($this->Criterias() as $cid => $criteria) */
        /* { */
        /*     $sum+=$this->Assessors_Submission_Criteria_Media_Calc($assessors,$submission,$criteria,$weighted); */
        /* } */

        $sum=0.0;
        $n=0;
        foreach ($assessors as $assessor)
        {
            if ($assessor[ "HasAssessed" ]==2)
            {
                $sum+=$assessor[ "Result" ];
                $n++;
            }
        }

        $media=$sum/$n;

        return sprintf("%.1f",$media);
     }

    
    //*
    //* function Assessors_Submission_Media_Row, Parameter list: $submission,$assessors,$criterias
    //*
    //* Generate summed row, sums over criterias, per assessor.
    //*

    function Assessors_Submission_Media_Row($submission,$assessors)
    {
        $row=
            array
            (
               "",
               $this->MultiCell($this->ApplicationObj()->Sigma.":",1,"right"),
               $this->B
               (
                   sprintf
                   (
                       "%.1f",
                       $this->Criterias_Weight()
                   )
               ),
            );

        $resultsum=0.0;
        foreach ($assessors as $assessor)
        {
            $icon="icons/notok.png";
            $title='Incomplete';
            if ($assessor[ "HasAssessed" ]==2)
            {
                $icon="icons/ok.png";
                $title='Complete';
            }
 
            $result="-";
            if (!empty($assessor[ "Result" ]))
            {
                $resultsum+=$assessor[ "Result" ];
                $result=$this->B(sprintf("%.1f",$assessor[ "Result" ]));
                var_dump($assessor[ "Result" ]);
                var_dump($resultsum);
            }
            
            array_push
            (
                $row,
                $this->MultiCell
                (
                    $this->IMG($icon,$title,20,20,array("TITLE" => $title)),
                    1
                ),
                $this->Div
                (
                    $this->B($result),
                    array("ALIGN" => 'right')
                )
                
            );
        }
        
        array_push
        (
            $row,
            "-",
            /* $this->Div */
            /* ( */
            /*     $this->B($this->Assessors_Submission_Media($submission,$assessors,FALSE)), */
            /*     array("ALIGN" => 'right') */
            /* ), */
            $this->Div
            (
                $this->B($this->Assessors_Submission_Media($submission,$assessors)),
                array("ALIGN" => 'right')
            )
        );

        return $row;
    }
}

?>