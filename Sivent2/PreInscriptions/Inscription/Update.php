<?php


class PreInscriptionsInscriptionUpdate extends PreInscriptionsInscriptionTable
{    
     //*
    //* function PreInscriptions_Submissions_Sql_Where, Parameter list: $inscription=array(),$submission=array()
    //*
    //* Returns preinscriptions unique SQL where.
    //*

    function PreInscriptions_Submissions_Sql_Where($inscription=array(),$submission=array())
    {
        $where=array();
        if (!empty($inscription))
        {
            $where[ "Friend" ]=$inscription[ "Friend" ];
        }
        
        if (!empty($submission))
        {
            $where[ "Submission" ]=$submission[ "ID" ];
        }
        
        return $this->UnitEventWhere($where);
    }

     //*
    //* function PreInscriptions_Submissions_Update, Parameter list: $inscription
    //*
    //* Shows $inscription preinscriptions table (matrix).
    //*

    function PreInscriptions_Submissions_Update($inscription)
    {
        if ($this->CGI_POSTint("Save")!=1) { return; }

        foreach ($this->Submissions as $sid => $submission)
        {
            $value=$this->PreInscriptions_Inscription_Submission_PreInscribe_Cell_Value($submission);

            $oldvalue=0;
            if (!empty($this->PreInscriptions[ $submission[ "ID" ] ]))
            {
                $oldvalue=1;
            }
            if ($value==1)
            {
                if ($oldvalue==0)
                {
                    $mayadd=TRUE;
                    foreach ($this->PreInscriptions_Inscription_Submission_Conflicts($submission) as $conflict)
                    {
                        if (!empty($this->PreInscriptions[ $conflict[ "ID" ] ]))
                        {
                            $mayadd=FALSE;
                            break;
                        }
                    }
                    
                    $nvacancies=$this->SubmissionsObj()->SubmissionVacancies($submission);
                    if ($nvacancies<=0)
                    {
                        $mayadd=FALSE;
                    }
                    
                    if ($mayadd)
                    {
                        $this->PreInscriptions_Submissions_Add($inscription,$submission);
                    }
                    //else { var_dump("ignored"); }
                }
            }
            else
            {
                if ($oldvalue==1)
                {
                    $this->PreInscriptions_Submissions_Delete($inscription,$submission);
                }
            }
        }

    }
    
    //*
    //* function PreInscriptions_Submissions_Add, Parameter list: $inscription,$submission
    //*
    //* Shows $inscription preinscriptions table (matrix).
    //*

    function PreInscriptions_Submissions_Add($inscription,$submission)
    {
        $where=$this->PreInscriptions_Submissions_Sql_Where($inscription,$submission);
        $hashes=$this->Sql_Select_Hashes($where,array("ID"));
        if (!empty($hashes))
        {
            $hash=array_shift($hashes);

            //Delete superflous, shouldn't happen...
            foreach ($hashes as $rhash)
            {
                $this->Sql_Delete_Item($rhash[ "ID" ]);
            }
        }
        else
        {
            $hash=$where;
            $inserted=$this->Sql_Insert_Unique($where,$hash);
            if ($inserted)
            {
                $this->PreInscriptions[ $hash[ "Submission" ] ]=$hash;
            }
        }
    }
    
    //*
    //* function PreInscriptions_Submissions_Delete, Parameter list: $inscription,$submission
    //*
    //* Shows $inscription preinscriptions table (matrix).
    //*

    function PreInscriptions_Submissions_Delete($inscription,$submission)
    {
        $where=$this->PreInscriptions_Submissions_Sql_Where($inscription,$submission);

        $hashes=$this->Sql_Select_Hashes($where,array("ID"));
        if (!empty($hashes))
        {
            //Delete superflous, should be only one.
            foreach ($hashes as $rhash)
            {
                $this->Sql_Delete_Item($rhash[ "ID" ]);
            }
        }
        
        unset($this->PreInscriptions[ $submission[ "ID" ] ]);
    }
}

?>