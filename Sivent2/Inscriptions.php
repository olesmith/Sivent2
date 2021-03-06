<?php


include_once("../EventApp/MyInscriptions.php"); 


include_once("Inscriptions/Access.php");
include_once("Inscriptions/Payments.php");
include_once("Inscriptions/Overrides.php");
include_once("Inscriptions/Read.php");
include_once("Inscriptions/Cells.php");
include_once("Inscriptions/Tables.php");
include_once("Inscriptions/Inscribe.php");
include_once("Inscriptions/Update.php");
include_once("Inscriptions/Statistics.php");
include_once("Inscriptions/Form.php");
include_once("Inscriptions/Collaborations.php");
include_once("Inscriptions/Caravans.php");
include_once("Inscriptions/Submissions.php");
include_once("Inscriptions/Assessments.php");
include_once("Inscriptions/Certificate.php");
include_once("Inscriptions/Certificates.php");
include_once("Inscriptions/PreInscriptions.php");
include_once("Inscriptions/Handle.php");


include_once("../Common/Barcode.php");



class Inscriptions extends InscriptionsHandle
{
    use Barcode;
    
    var $Certificate_Type=1;

    var $Load_Other_Data=TRUE;
    var $Export_Defaults=
        array
        (
            "NFields" => 4,
            "Data" => array
            (
                1 => "No",
                2 => "Friend__ID",
                3 => "Friend__Name",
                4 => "Friend__Email",
            ),
            "Sort" => array
            (
                1 => "0",
                2 => "0",
                3 => "1",
                4 => "0",
            ),
                
           );
    
    //*
    //* function Inscriptions, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Inscriptions($args=array())
    {
        $this->Hash2Object($args);
        
        $this->AlwaysReadData=array("Friend","Name","SortName","Unit","Event","CH","Has_Paid");
        $this->Sort=array("Name");
        $this->InscriptionEventTableSGroups= array
        (
           array
           (
              "Basic" => 0,
              "Inscriptions" => 0,
           ),
        );

        $this->IncludeAllDefault=TRUE;

        $this->CellMethods[ "Inscription_Collaborators_Noof_Cell" ]=TRUE;
        $this->CellMethods[ "Inscription_Caravaneers_Noof_Cell" ]=TRUE;
        $this->CellMethods[ "Inscription_Submissions_Noof_Cell" ]=TRUE;
    }


    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("Inscriptions",$table);
    }

    //*
    //* Returns full (relative) upload path: UploadPath/#Unit/#Event/Submissions.
    //*

    function MyMod_Data_Upload_Path()
    {
        $path=
            join
            (
               "/",
               array
               (
                  "Uploads",
                  $this->Unit("ID"),
                  $this->Event("ID"),
                  "Inscriptions"
               )
            );
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }
    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        parent::PreProcessItemDataGroups();

        $event=$this->Event();
        if ($this->EventsObj()->Event_Certificates_Has($event))
        {
            array_push($this->ItemDataSGroupFiles,"SGroups.Certificates.php");
        }

        if ($this->Load_Other_Data)
        {
            if ($this->EventsObj()->Event_Payments_Has($event))
            {
                array_push($this->ItemDataSGroupFiles,"SGroups.Payments.php");
                array_push($this->ItemDataGroupFiles,"Groups.Payments.php");
            }
        
            if ($this->EventsObj()->Event_Collaborations_Has($event))
            {
                array_push($this->ItemDataSGroupFiles,"SGroups.Collaborations.php");
            }
        
            if ($this->EventsObj()->Event_Submissions_Has($event))
            {
                array_push($this->ItemDataSGroupFiles,"SGroups.Submissions.php");
            }
        
            if ($this->EventsObj()->Event_Caravans_Has($event))
            {
                array_push($this->ItemDataSGroupFiles,"SGroups.Caravans.php");
            }
            
        }
        
    }
    
    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
        parent::PostProcessItemDataGroups();
        $event=$this->Event();
        /* if ($this->EventsObj()->EventCertificates($event)) */
        /* { */
        /*     array_push($this->ItemDataGroups[ "Data" ],"Inscription__Noof_Cell"); */
        /* } */

        
        if ($this->Current_User_Event_Coordinator_Is())
        {
            if ($this->EventsObj()->Event_Collaborations_Has($event))
            {
                array_push($this->ItemDataGroups[ "Basic" ][ "Data" ],"Inscription_Collaborators_Noof_Cell");
            }
        
            if ($this->EventsObj()->Event_Caravans_Has($event))
            {
                array_push($this->ItemDataGroups[ "Basic" ][ "Data" ],"Inscription_Caravaneers_Noof_Cell");
            }
        
            if ($this->EventsObj()->Event_Submissions_Has($event))
            {
                array_push($this->ItemDataGroups[ "Basic" ][ "Data" ],"Inscription_Submissions_Noof_Cell");
            }
        }
    }
    

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        parent::PreProcessItemData();

        array_push
        (
           $this->ItemDataFiles,
           "Data.Certificate.php","Data.Collaborations.php",
           "Data.Submissions.php","Data.Caravans.php","Data.Payments.php"
        );
        
        $event=$this->Event();
        if ($this->EventsObj()->EventCertificates($event))
        {
            $this->CertificatesObj()->ItemData("ID");
        }
        
        if (!$this->Load_Other_Data) { return; }
    
        if ($this->EventsObj()->Event_Caravans_Has($event))
        {
            $this->CaravaneersObj()->ItemData("ID");
        }
        
        if ($this->EventsObj()->Event_Payments_Has($event))
        {
            //array_push($this->ItemDataFiles,"Data.Payments.php");
            //array_push($this->AlwaysReadData,"Has_Paid");
        }
    }
    
    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return "System/Inscriptions/Profiles.php";
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        parent::PostProcessItemData();

        $this->Coordinator_Type=2;
    }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        parent::PostInit();
        $this->SubmissionsObj()->Sql_Table_Structure_Update();
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/^(Inscriptions|Events)$/',$module))
        {
            return $item;
        }

        if (empty($item[ "ID" ])) { return $item; }

        $item=parent::PostProcess($item);

        $updatedatas=array();

        $this->PostProcess_Friend_Data($item,$updatedatas);
        $this->PostProcess_Certificate_CH($item,$updatedatas);
        $this->PostProcess_Code($item,$updatedatas);
        
        $this->PostProcess_Certificate($item);
        
        $this->PostProcess_Payment($item,$updatedatas);

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
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
    //* function PostProcessFriendData, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess_Friend_Data(&$item,&$updatedatas)
    {
        $this->MakeSureWeHaveRead("",$item,array("Friend","Name","SortName","Email"));
        if (empty($item[ "Name" ]) || empty($item[ "SortName" ]) || empty($item[ "Email" ]))
        {
            $friend=
                $this->FriendsObj()->Sql_Select_Hash
                (
                   array("ID" => $item[ "Friend" ]),
                   array("ID","Name","SortName","Email")
                );

            $item[ "Email" ]=$friend[ "Email" ];
            $item[ "Name" ]=$friend[ "Name" ];
            $item[ "SortName" ]=$this->Html2Sort($friend[ "Name" ]);

            array_push($updatedatas,"Name","SortName","Email");
        }
    }
    
    //*
    //* function PostProcessCertificate, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription certificate.
    //*

    function PostProcess_Certificate(&$item)
    {
        if (!empty($item[ "Certificate" ]))
        {
            $where=$this->Inscription_Certificate_Where($item,$this->Certificate_Type);

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
                           "Inscription" =>  $item[ "ID" ],
                           "Unit"        =>  $item[ "Unit" ],
                           "Event"        => $item[ "Event" ],
                           "Friend"       => $item[ "Friend" ],
                           "Type"         => $this->Certificate_Type,
                           "Name"         => $item[ "Name" ],
                           "Code"         => $item[ "Code" ],
                        );

                    $this->CertificatesObj()->Sql_Insert_Item($cert);
                }
            }
        }
    }

    
    //*
    //* function PostProcessCode, Parameter list: &$item,&$updatedatas
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
            $code=$this->Certificate_Code($item);
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
    //* Postprocesses and returns $item.
    //*

    function PostProcess_Certificate_CH(&$item,&$updatedatas)
    {
        $event=$this->Event();
        if ($this->EventsObj()->EventCertificates($event))
        {
            $this->MakeSureWeHaveRead("",$item,array("Certificate","Certificate_CH"));
            if (!empty($item[ "Certificate" ]) && $item[ "Certificate" ]==2)
            {
                if (empty($item[ "Certificate_CH" ]))
                {
                    $item[ "Certificate_CH" ]=$event[ "TimeLoad" ];
                    array_push($updatedatas,"Certificate_CH");
                }
            }
        }
    }

    
    //*
    //* function InitPrint, Parameter list: $item
    //*
    //* Does some casing before printing.
    //*

    function InitPrint($item)
    {
        $item[ "Name" ]=$this->TrimCase($item[ "Name" ]);

        return $item;
    }
    
    //*
    //* function MyMod_Access_Has, Parameter list: 
    //*
    //* Returns true if access to module allowed.
    //*

    function MyMod_Access_Has()
    {
        $res=parent::MyMod_Access_Has();
        
        //$res=$this->Coordinator_Inscriptions_Access_Has();
        
        //var_dump($this->ModuleName);
        //var_dump($res);
        
        return $res;
    }
    
    //*
    //* function EventCertificates, Parameter list: $inscription
    //*
    //* Returns TRUE if $event (or $this->Event()) has certificates.
    //*

    function Inscription_Paid_Has($inscription)
    {
        $havepaid=$inscription[ "Has_Paid" ];
        
        $res=FALSE;
        if ($havepaid>1)
        {
            $res=TRUE;
        }

        return $res;
    }
    

}

?>