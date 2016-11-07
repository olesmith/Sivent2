<?php

class Schedules_Schedule_Fields extends SchedulesSubmissions
{
    //*
    //* function Schedule_Field, Parameter list: $edit,$date,$time,$room
    //*
    //* Generates $date, $time, $roow scedule field.
    //*

    function Schedule_Field($edit,$date,$time,$place,$room)
    {
        $schedule=$this->Schedule($date,$time,$place,$room);

        if ($edit==1)
        {
            return $this->Schedule_Field_Edit($date,$time,$room,$schedule);
        }
        else
        {
            return $this->Schedule_Field_Show($date,$time,$room,$schedule);
        }
    }
    
    //*
    //* function Schedule_Field_Show, Parameter list: $date,$time,$room,$schedule
    //*
    //* Generates $date, $time, $roow show scedule field.
    //*

    function Schedule_Field_Show($date,$time,$room,$schedule)
    {
        $cell="";
        if (!empty($schedule[ "Submission" ]))
        {
            $submission=$this->SubmissionsObj()->Sql_Select_Hash(array("ID" => $schedule[ "Submission" ]));

            $friendinfo="-";
            
            $options=array();
            $area=array();
            $class="";
            if (!empty($submission[ "Area" ]))
            {
                $area=$this->AreasObj()->Sql_Select_Hash($submission[ "Area" ],array("Color","Background"));
                $class='Area'.$submission[ "Area" ];
                $options[ "CLASS" ]=$class;                
            }
            
            if (!empty($submission[ "Friend" ]))
            {
                $friend=$this->Speakers($submission[ "Friend" ]);
                $friendinfo=$this->FriendsObj()->FriendInfo($friend,$class);
            }
            
            $cell=
                $this->B
                (
                   join("; ",$this->SubmissionsObj()->Submission_Authors($submission)).":\n"
                ).
                $this->BR().
                $this->BR().
                $this->I
                (
                   $this->SubmissionsObj()->SubmissionInfo($submission)
                ).
                "";
            
            if ($this->ApplicationObj()->LatexMode())
            {
                if (!empty($area[ "Color" ]))
                {
                    $cell_uuu=
                        "\\sethlcolor{red}\n".
                        "\\hl{\n".
                        "   \\textcolor{white}{".
                         $cell.
                        "   }\n".
                        "}";
                }
                
                $cell=
                    $this->Latex_Minipage
                    (
                       $this->Latex_Env
                       (
                          "center",
                          $this->Latex_Env("small",$cell)
                       ),
                       $width="5cm",
                       $align='c'
                    );
            }
            else
            {
                
                $cell.=
                      $this->BR().
                      $this->BR().
                      $this->Schedule_Menu($schedule).
                    "";
            }
            
            $cell=
                array
                (
                   "Text" => $this->Div($cell),
                   "Options" => $options
                );
        }

        return $cell;
    }
    
    //*
    //* function Schedule_Field_Edit, Parameter list: $edit,$date,$time,$room,$schedule
    //*
    //* Generates $date, $time, $roow scedule select field.
    //*

    function Schedule_Field_Edit($date,$time,$room,$schedule)
    {
        $submissionid=0;
        if (!empty($schedule[ "Submission" ])) $submissionid=$schedule[ "Submission" ];

        return 
            $this->Html_SelectField
            (
               $this->DisableScheduledSubmissions($time,$schedule),
               $this->ScheduleCGIName($date,$time,$room),
               "ID",
               "#Name: #Title",
               "#Authors: #Title",
               $submissionid,
               TRUE,
               "Disabled",
               array
               (
                  "TITLE" => "TTTTTTTTTTTTTT",
               )
            ).
            "";
    }
}

?>