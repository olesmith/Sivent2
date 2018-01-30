<?php



class Submissions_Assessors extends Submissions_Authors
{
    //*
    //* function Submissions_Assessors_Update, Parameter list: &$submission
    //*
    //* Displays search list of submissions.
    //*

    function Submission_Assessors_Update(&$submission)
    {
        $key=$submission[ "ID" ]."_Status";
        $newvalue=$this->CGI_POSTint($key);

        if ($submission[ "Status" ]!=$newvalue)
        {
            $submission[ "Status" ]=$newvalue;
            $this->Sql_Update_Item_Values_Set(array("Status"),$submission);
        }

        $assessor=$this->CGI_POSTint("Assessor_".$submission[ "ID" ]);
        if ($assessor>0)
        {
            $where=$this->UnitEventWhere
            (
                array
                (
                    "Submission" => $submission[ "ID" ],
                    "Friend" => $assessor,
                )
            );
                
            $nitems=$this->AssessorsObj()->Sql_Select_NHashes($where);
            if ($nitems==0)
            {
                $assessor=$where;
                $this->AssessorsObj()->Sql_Insert_Item($assessor);
            }
        }
    }

    
    /* //\* */
    /* //\* function Submission_Assessors_Update, Parameter list: */
    /* //\* */
    /* //\* Displays search list of submissions. */
    /* //\* */

    /* function Submission_Assessors_Update($submission,$assessors) */
    /* { */
    /*     foreach (array_keys($this->ItemHashes) as $sid) */
    /*     { */
    /*         $this->Submission_Assessors_Update($this->ItemHashes[ $sid ]); */
    /*     } */
    /* } */

    
    //*
    //* function Submission_Assessors_Table, Parameter list: $edit
    //*
    //* Displays search list of submissions.
    //*

    function Submissions_Assessors_Table($edit)
    {
        $this->AssessorsObj()->Sql_Table_Structure_Update();
        $this->AssessorsObj()->ItemData();
        $this->AssessorsObj()->ItemDataGroups();
        $this->AssessorsObj()->Actions();
        
        $this->AssessorsObj()->ItemData[ "Friend" ][ "EditFieldMethod" ]="Assessor_Field";       
        $datas=$this->MyMod_Data_Group_Datas_Get("Assessments");

        $profile=$this->Profile();
        
        foreach ($datas as $data)
        {
            if (!preg_match('/^(Status)$/',$data))
            {
                if (!empty($this->ItemData[ $data ][ $profile ]))
                {
                    $this->ItemData[ $data ][ $profile ]=1;
                }
            }
        }


        $table=array();
        $n=1;
        foreach ($this->ItemHashes as $submission)
        {
            $submission[ "No" ]=$n;
            $table=array_merge
            (
               $table,
               $this->Submission_Assessors_Table($edit,$n++,$datas,$submission)
            );
        }
        
        return
            $this->Html_Table
            (
               $this->MyMod_Data_Titles($datas),
               $table
            ).
            "";
    }
    
    //*
    //* function Submission_Assessors_Table, Parameter list: $edit,$n,$datas,$submission
    //*
    //* Generatres $submission rows: $datas row and assessments rows.
    //*

    function Submission_Assessors_Table($edit,$n,$datas,$submission)
    {
        $rows=array($this->MyMod_Items_Table_Row($edit,$n,$submission,$datas,TRUE,$submission[ "ID" ]."_"));

        $assessorsgroup="Assessments";
        
        $assessors=$this->Submission_Handle_Assessors_Read($submission);

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $assessors=$this->Submission_Handle_Assessors_Update($submission,$assessors);
        }
        
        $table=array();
        if (count($assessors)>0)
        {
            $table=
                $this->AssessorsObj()->MyMod_Items_Group_Table_Html
                (
                    $edit,
                    $assessors,
                    "",
                    $assessorsgroup
                );
        }

        
        $table=
            $this->H
            (
                3,
                $this->AssessorsObj()->ItemDataGroups($assessorsgroup,"Name")
            ).
            $this->AssessorsObj()->MyMod_Items_Group_Table_Html
            (
                $edit,
                $assessors,
                "",
                $assessorsgroup
            ).
            "";

        if ($edit==1)
        {
            $table.=
                join("",$this->Submissions_Handle_Assessor_Add_Row("_".$submission[ "ID" ]));
        }
        
        $table=$this->FrameIt($table);

        array_push
        (
            $rows,
            array
            (
                $this->MultiCell("",3),
                $this->MultiCell($table,count($datas)-3),
                ""
            )
        );
               
        return $rows;
    }
}

?>