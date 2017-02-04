<?php

include_once("Collaborators/Access.php");
include_once("Collaborators/Emails.php");
include_once("Collaborators/Table.php");
include_once("Collaborators/Certificate.php");
include_once("Collaborators/Statistics.php");



class Collaborators extends Collaborators_Statistics
{
    var $Certificate_Type=3;
    var $Export_Defaults=
        array
        (
            "NFields" => 6,
            "Data" => array
            (
                1 => "No",
                2 => "Friend__Name",
                3 => "Friend__Email",
                4 => "Collaboration",
                5 => "Homologated",
                6 => "Certificate",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "1",
                3 => "0",
                4 => "0",
                5 => "0",
                6 => "0",
            ),
        );
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Collaborators($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","TimeLoad");
        $this->Sort=array("Name");
        $this->IncludeAllDefault=TRUE;

        $this->Coordinator_Type=3;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Collaborators",$table);
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->PostProcessUnitData();
        $this->PostProcessEventData();

        if (preg_match('/(Coordinator|Admin)/',$this->Profile()))
        {
            $this->AddDefaults[ "Homologated" ]=2;
        }
        else
        {
            $this->AddDefaults[ "Homologated" ]=1;
        }
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        $this->CertificatesObj()->Sql_Table_Structure_Update();
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/(Collaborators|Friends)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->Sql_Select_Hash_Datas_Read($item,array("Friend","Collaboration","TimeLoad","Homologated","Name"));

        $updatedatas=array();
        
        
        if (
              empty($item[ "TimeLoad" ])
              &&
              !empty($item[ "Collaboration" ])
           )
        {
            $item[ "TimeLoad" ]=
                $this->CollaborationsObj()->Sql_Select_Hash_Value
                (
                   $item[ "Collaboration" ],
                   "TimeLoad"
                );

            array_push($updatedatas,"TimeLoad");
        }
            
        if (empty($item[ "Homologated" ]))
        {
            $item[ "Homologated" ]=1;
            array_push($updatedatas,"Homologated");
        }

        $names=array();
        if (!empty($item[ "Collaboration" ]))
        {
            array_push($names,$this->CollaborationsObj()->Sql_Select_Hash_Value($item[ "Collaboration" ],"Name"));
        }
        
        if (!empty($item[ "Friend" ]))
        {
            array_push($names,$this->FriendsObj()->Sql_Select_Hash_Value($item[ "Friend" ],"Name"));
        }

        $name=join(", ",$names);
        if ($item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }
 
        $this->PostProcess_Code($item,$updatedatas);        
        $this->PostProcess_Certificate($item);
        
        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        $friend=array("ID" => $item[ "Friend" ]);
        $event=array("ID" => $item[ "Event" ]);
        
        $isinscribed=$this->EventsObj()->Friend_Inscribed_Is($event,$friend);
        if (!$isinscribed)
        {
            $this->InscriptionsObj()->DoInscribe($friend);
        }

        if ($item[ "Homologated" ]!=2)
        {
            $item[ "Certificate_ReadOnly" ]=TRUE;
        }
        
        return $item;
    }
    
    //*
    //* function Certificate_Code, Parameter list: $item
    //*
    //* Generates certificate code.
    //*

    function Certificate_Code($item)
    {
        return $this->CertificatesObj()->Certificate_Code($item,$this->Certificate_Type);
    }
    
    //*
    //* function PostProcess_Code, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription code.
    //*

    function PostProcess_Code(&$item,&$updatedatas)
    {
        if (
              !empty($item[ "ID" ])
              &&
              !empty($item[ "Friend" ])
              &&
              !empty($item[ "Event" ])
           )
        {
            $code=$this->Certificate_Code($item,$this->Certificate_Type);
            if (!empty($code) && empty($item[ "Code" ]) || $item[ "Code" ]!=$code)
            {
                $item[ "Code" ]=$code;
                array_push($updatedatas,"Code");
            }
        }
    }
    
    //*
    //* function PostProcess_Certificate, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses $item collaboration certificate.
    //*

    function PostProcess_Certificate(&$item)
    {
        if (!empty($item[ "Certificate" ]))
        {
            foreach (array("Friend") as $fdata)
            {
                if (empty($item[ $fdata ])) { continue; }
                
                $where=$this->Collaborator_Certificate_Where($item,$item[ $fdata ]);
                $certs=$this->CertificatesObj()->Sql_Select_Hashes($where);
                if ($item[ "Certificate" ]==1)
                {
                    if (count($certs)>0)
                    {
                        $this->CertificatesObj()->Sql_Delete_Items($where);
                    }
                }
                elseif ($item[ "Certificate" ]==2)
                {
                    if (empty($certs))
                    {
                        $cert=
                            array
                            (
                               "Collaborator" => $item[ "ID" ],
                               "Collaboration" => $item[ "Collaboration" ],
                               "Unit"        => $this->Unit("ID"),
                               "Event"        => $item[ "Event" ],
                               "Friend"       => $item[ $fdata ],
                               "Type"         => $this->Certificate_Type,
                               "Name"         => $item[ "Name" ],
                               "Code"         => $item[ "Code" ],
                            );

                        $this->CertificatesObj()->Sql_Insert_Item($cert);
                    }
                }
            }
        }
    }

    
    //*
    //* function AddForm_PostText, Parameter list:
    //*
    //* Pretext function. Shows add inscriptions form.
    //*

    function AddForm_PostText()
    {
        if (!preg_match("(Coordinator|Admin)",$this->Profile()))
        {
            return "";
        }
        
        return
            $this->BR().
            $this->FrameIt($this->InscriptionsObj()->DoAdd());
    }
}

?>