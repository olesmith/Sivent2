<?php

class PreInscriptionsInscriptionTable extends PreInscriptionsInscriptionRows
{
     //*
    //* function PreInscriptions_Submissions_Table_Html, Parameter list: $inscription,$datas=array()
    //*
    //* Shows $inscription preinscriptions html table.
    //*

    function PreInscriptions_Submissions_Table_Html($edit,$inscription,$datas=array())
    {
        return
            $this->H(2,$this->MyMod_ItemName("ItemsName")).
            $this->Html_Table
            (
               "",
               $this->PreInscriptions_Submissions_Table($edit,$inscription,$datas)
            ).
            "";
    }
    
     //*
    //* function PreInscriptions_Submissions_Table, Parameter list: $inscription,$sdatas
    //*
    //* Shows $inscription preinscriptions table (matrix).
    //*

    function PreInscriptions_Submissions_Table($edit,$inscription)
    {
        $buttons="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
        }
        
        $titles=$this->PreInscriptions_Inscription_Submission_Titles();

        $table=array();
        $n=1;
        foreach (array_keys($this->Submissions) as $sid)
        {
            $this->Submissions[ $sid ][ "No" ]=$n++;

            array_push
            (
               $table,
               $titles,
               $this->PreInscriptions_Inscription_Submission_Row
               (
                  $edit,
                  $inscription,
                  $this->Submissions[ $sid ]
               ),
               array
               (
                  $this->SubmissionsObj()->Submission_Schedules($this->Submissions[ $sid ]),
               ),
               array
               (
                  $this->PreInscriptions_Inscription_Submission_Conflicts_List($this->Submissions[ $sid ]),
               )
            );
            
            if ($edit==1)
            {
                array_push
                (
                    $table,
                    $buttons,
                    $this->B
                    (
                        "-------------------------------------------------------------------".
                        "-------------------------------------------------------------------"
                    )
                );
            }
        
        }

        return $table;
    }

    
    //*
    //* function PreInscriptions_Times_Table, Parameter list: $inscription
    //*
    //* Compiles a list of $inscription's timed activities.
    //*

    function PreInscriptions_Times_Table($inscription)
    {
        $submissions=array();
        foreach ($this->PreInscriptions_Inscription_Read($inscription) as $preinscription)
        {
            $submission=$this->PreInscriptions_Submission($preinscription[ "Submission" ]);
            foreach ($submission[ "Times" ] as $timeid)
            {
                $submissions[ $timeid ]=$submission;
            }
        }

        if (empty($submissions))
        {
            return $this->H(3,$this->MyLanguage_GetMessage("PreInscriptions_Times_Table_Empty"));
        }

        $timeids=array_keys($submissions);

        $times=
            $this->TimesObj()->Sql_Select_Hashes
            (
                array
                (
                   "ID" => " IN ('".join("','",$timeids)."')",
                ),
                array("ID","Name"),
                "Sort"
            );

        $table=array();

        $scheddatasread=array("ID","Date","Time","Place","Room","Submission");
        $sceddatasshow=$scheddatasread;
        $sceddatasshow[0]="No";
        
        $n=1;
        foreach ($times as $time)
        {
            $where=
                $this->UnitEventWhere
                   (
                      array
                      (
                         "Submission" => $submissions[ $time[ "ID" ] ][ "ID" ],
                         "Time" => $time[ "ID" ],
                      )
                    );

            $schedule=
                $this->SchedulesObj()->Sql_Select_Hash
                (
                   $this->UnitEventWhere
                   (
                      array
                      (
                         "Submission" => $submissions[ $time[ "ID" ] ][ "ID" ],
                         "Time" => $time[ "ID" ],
                      )
                   ),
                   $scheddatasread
                );

            $schedule[ "No" ]=$n++;
            array_push
            (
               $table,
               $this->SchedulesObj()->MyMod_Item_Row(0,$schedule,$sceddatasshow)
            );
        }
        

        return
            $this->H(3,$this->MyLanguage_GetMessage("PreInscriptions_Times_Table_Title")).
            $this->Html_Table
            (
               $this->SchedulesObj()->MyMod_Data_Titles($sceddatasshow),
               $table
            ).
            "";
    }
}

?>