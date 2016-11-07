<?php

include_once("Assessments/Calc.php");
include_once("Assessments/Cells.php");
include_once("Assessments/Rows.php");
include_once("Assessments/Read.php");
include_once("Assessments/Table.php");
include_once("Assessments/Update.php");


class Submissions_Handle_Assessments extends Submissions_Handle_Assessments_Update
{
    //*
    //* function Submissions_Assessors_Datas, Parameter list: 
    //*
    //* List of data to show for assessors.
    //*

    function Submissions_Assessors_Datas()
    {
        return array("No","Edit","Delete","Friend","HasAccessed","HasAssessed","Result");
    }
    
    //*
    //* function Submissions_Handle_Assessments, Parameter list: $submission=array()
    //*
    //* Show $submission Assessors and Assessments info.
    //*

    function Submissions_Handle_Assessments($submission=array())
    {
        $edit=1;
        
        $this->AssessorsObj()->Sql_Table_Structure_Update();
        $this->AssessorsObj()->ItemData();
        $this->AssessorsObj()->Actions();
        
        $this->CriteriasObj()->Sql_Table_Structure_Update();
        $this->CriteriasObj()->ItemData();

        $this->AssessmentsObj()->Sql_Table_Structure_Update();
        $this->AssessmentsObj()->ItemData();

        if (empty($submission)) { $submission=$this->ItemHash; }

        $assessors=$this->Submissions_Handle_Assessors_Read($submission);
        
        if ($this->CGI_POSTint("Update")==1)
        {
            $assessors=$this->Submissions_Handle_Assessors_Update($submission,$assessors);
        }

        $assessordatas=$this->Submissions_Assessors_Datas();

        //Must generate first, as it updates $assessors.
        $assessmentstable=$this->Html_Table
            (
               $this->Submissions_Handle_Assessors_Assessments_Titles($assessors),
               $this->Submissions_Handle_Assessors_Assessments_Table($edit,$submission,$assessors)
             );


        echo
            $this->H(1,"Atividade").
            $this->Html_Table
            (
               "",
               $this->MyMod_Item_Group_Table(0,"Basic",$submission)
            ).
            $this->H(1,"Avaliadores").
            $this->StartForm().
            $this->Html_Table
            (
               $this->AssessorsObj()->GetDataTitles($assessordatas),
               $this->Submissions_Handle_Assessors_Table($edit,$submission,$assessordatas,$assessors)
            ).
            $this->H(1,"Avaliações").
            
            $assessmentstable.
            $this->MakeHidden("Update",1).
            $this->EndForm().
            "";
        
    }
    
    //*
    //* function Submissions_Handle_Assessors_Read, Parameter list: $submission,$assessordatas=array()
    //*
    //* Creates assesemnts table.
    //*

    function Submissions_Handle_Assessors_Read($submission,$assessordatas=array())
    {
        $where=$this->UnitEventWhere(array("Submission" => $submission[ "ID" ]));

        return $this->AssessorsObj()->Sql_Select_Hashes($where,$assessordatas);
    }

    //*
    //* function Submissions_Handle_Assessor_Add_Row, Parameter list: $submission,$assessordatas=array()
    //*
    //* Creates assesemnts table.
    //*

    function Submissions_Handle_Assessor_Add_Row($cgipost="")
    {
        return
           array
           (
               $this->B($this->Language_Message("Submissions_Accessor_Add_Title").":").
               $this->AssessorsObj()->MyMod_Data_Fields_Edit
               (
                   "Friend",
                   array(),
                   $value="",
                   $tabindex="",
                   $plural=FALSE,
                   $links=TRUE,
                   $callmethod=TRUE,
                   "Assessor".$cgipost
               ),
           );
    }

    
    //*
    //* function Submissions_Handle_Assessors_Calc, Parameter list: $assessors
    //*
    //* Creates assesemnts table.
    //*

    function Submissions_Handle_Assessors_Calc($assessors)
    {
        if (empty($assessors)) { return "-"; }
        
        $sum=0.0;
        foreach ($assessors as $assessor)
        {
            $sum+=1.0*$assessor[ "Result" ];
        }

        return $sum/(1.0*count($assessors));
    }

    
    //*
    //* function Submissions_Handle_Assessors_Table, Parameter list: $edit,$submission,$assessordatas
    //*
    //* Creates assesemnts table.
    //*

    function Submissions_Handle_Assessors_Table($edit,$submission,$assessordatas,$assessors)
    {
        $table=array();
        $n=1;
        foreach ($assessors as $assessor)
        {
            $row=
                $this->AssessorsObj()->MyMod_Items_Table_Row
                (
                   $edit,
                   $n++,
                   $assessor,
                   $assessordatas,
                   $plural=TRUE,
                   $assessor[ "ID" ]."_"
                );

            array_push($table,$row);
        }

        $result=$this->Submissions_Handle_Assessors_Calc($assessors);
        if ($submission[ "Result" ]!=$result)
        {
            $submission[ "Result" ]=$result;
            $this->Sql_Update_Item_Value_Set($submission[ "ID" ],"Result",$result);
        }

        $sumrow=array();
        foreach ($assessordatas as $assessordata) { array_push($sumrow,""); }
        array_pop($sumrow);
        array_pop($sumrow);
        
        array_push
        (
           $sumrow,
           $this->MultiCell($this->ApplicationObj()->Mu.":",1,"right"),
           sprintf("%.1f",$result)
         );

        array_push
        (
           $table,
           $sumrow,
           $this->Submissions_Handle_Assessor_Add_Row(),
           array($this->Buttons())
        );

        return $table;
    }

    
    //*
    //* function Submissions_Handle_Assessors_Update, Parameter list: $submission,$assessors
    //*
    //* Updates $submission Assessors and Assessments info.
    //*

    function Submissions_Handle_Assessors_Update($submission,$assessors)
    {
        foreach (array_keys($assessors) as $aid)
        {
            $key=$assessors[ $aid ][ "ID" ]."_Friend";
            $newvalue=$this->CGI_POSTint($key);
            if ($newvalue>0 && $newvalue!=$assessors[ $aid ][ "Friend" ])
            {
               $where=
                    array
                    (
                       "Unit" => $this->Unit("ID"),
                       "Event" => $this->Event("ID"),
                       "Submission" => $submission[ "ID" ],
                       "Friend" => $newvalue,
                    );

                $nitems=$this->AssessorsObj()->Sql_Select_NHashes($where);
                if ($nitems==0)
                {
                    $this->AssessorsObj()->Sql_Update_Item_Value_Set($assessors[ $aid ][ "ID" ],"Friend",$newvalue);
                    $assessors[ $aid ][ "Friend" ]=$newvalue;
                }
            }
        }
        
        $addassessor=$this->CGI_POSTint("Assessor");
        if ($addassessor>0)
        {
            $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $addassessor));
            if (!empty($friend))
            {
                $assessor=
                    array
                    (
                       "Unit" => $this->Unit("ID"),
                       "Event" => $this->Event("ID"),
                       "Submission" => $submission[ "ID" ],
                       "Friend" => $friend[ "ID" ],
                    );

                $nitems=$this->AssessorsObj()->Sql_Select_NHashes($assessor);
                if ($nitems==0)
                {
                    //var_dump("Add ".$friend[ "ID" ]);
                    $this->AssessorsObj()->Sql_Insert_Item($assessor);
                    
                    array_push($assessors,$assessor);
                }
            }
        }

        return $assessors;
    }
}

?>