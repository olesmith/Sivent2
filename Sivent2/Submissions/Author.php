<?php

include_once("Authors/Data.php");
include_once("Authors/Rows.php");
include_once("Authors/Table.php");
include_once("Authors/SGroups.php");
include_once("Authors/Groups.php");

class Submissions_Author extends Submissions_Authors_Groups
{
    //*
    //* function Submissions_Friends_PostProcess, Parameter list: $item,&$updatedatas
    //*
    //* Postprocesses $item authors.
    //*

    function Submissions_Friends_PostProcess(&$item,&$updatedatas)
    {
        for ($n=1;$n<=$this->EventsObj()->Event_Submissions_NAuthors();$n++)
        {
            $this->Submissions_Friend_PostProcess($n,$item,$updatedatas);
        }
    }

    
    //*
    //* function Submissions_Friend_PostProcess, Parameter list: $item,&$updatedatas
    //*
    //* Postprocesses $item author no $n.
    //*

    function Submissions_Friend_PostProcess($n,&$item,&$updatedatas)
    {
        $frienddata=array("ID","Name","Email");
        
        $friendkey=$this->Author_Data_Get($n,"Friend");
        $emailkey=$this->Author_Data_Get($n,"Author_Email");
        $namekey=$this->Author_Data_Get($n,"Author");
        
        $datas=$this->Author_Datas_Get($n);

        $friendid=intval($item[ $friendkey ]);
        if ($friendid==0)
        {
            if (!empty($item[ $emailkey ]))
            {
                $friend=
                    $this->FriendsObj()->Sql_Select_Hash
                    (
                        array("Email" => $item[ $emailkey ]),
                        array("ID")
                    );

                $item[ $friendkey ]=$friend[ "ID" ];
                array_push($updatedatas,$friendkey);
            }
        }

        if ($friendid>0)
        {
            $friend=
                $this->FriendsObj()->Sql_Select_Hash_Values
                (
                    $item[ $friendkey ],
                    $frienddata
                );

            if (empty($item[ $namekey ]) || $item[ $namekey ]!=$friend[ "Name" ])
            {
                $item[ $namekey ]=$friend[ "Name" ];
                array_push($updatedatas,$namekey);
            }
                
            if (empty($item[ $emailkey ]) || $item[ $emailkey ]!=$friend[ "Email" ])
            {
                $item[ $emailkey ]=$friend[ "Email" ];
                array_push($updatedatas,$emailkey);
            }

            #Inscribe uninscribed $friend
            if (!$this->EventsObj()->Friend_Inscribed_Is($this->Event(),$friend))
            {
                $this->InscriptionsObj()->DoInscribe($friend);
            }

        }
    }
    
}
?>