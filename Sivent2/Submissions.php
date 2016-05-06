<?php

include_once("Submissions/Access.php");
include_once("Submissions/Table.php");
include_once("Submissions/Certificate.php");



class Submissions extends SubmissionsCertificate
{
    var $Certificate_Type=4;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Submissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Title","Status","TimeLoad","Friend","Friend2","Friend3");
        $this->Sort=array("Title");
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Submissions",$table);
    }


    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function GetUploadPath()
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
                  "Submissions"
               )
            );
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }
    
    /* //\* */
    /* //\* function PreActions, Parameter list: */
    /* //\* */
    /* //\*  */
    /* //\* */

    /* function PreActions_disabled() */
    /* { */
    /* } */


    /* //\* */
    /* //\* function PostActions, Parameter list: */
    /* //\* */
    /* //\*  */
    /* //\* */

    /* function PostActions_disabled() */
    /* { */
    /* } */

    
    /* //\* */
    /* //\* function PreProcessItemDataGroups, Parameter list: */
    /* //\* */
    /* //\*  */
    /* //\* */

    /* function PreProcessItemDataGroups_disabled() */
    /* { */
    /* } */

    /* //\* */
    /* //\* function PostProcessItemDataGroups, Parameter list: */
    /* //\* */
    /* //\*  */
    /* //\* */

    /* function PostProcessItemDataGroups_disabled() */
    /* { */
    /* } */

    /* //\* */
    /* //\* function PreProcessItemData, Parameter list: */
    /* //\* */
    /* //\* Pre process item data; this function is called BEFORE */
    /* //\* any updating DB cols, so place any additonal data here. */
    /* //\* */

    /* function PreProcessItemData_disabled() */
    /* { */
    /* } */
    
   
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
    }

    
    
    /* //\* */
    /* //\* function PostInit, Parameter list: */
    /* //\* */
    /* //\* Runs right after module has finished initializing. */
    /* //\* */

    /* function PostInit_disabled() */
    /* { */
    /* } */

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/(Submissions|Friends|Inscriptions)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        $this->Sql_Select_Hash_Datas_Read($item,array("Author1"));


        //Take default author names, if empty
        $hash=array
        (
           "Friend"  => "Author1",
           "Friend2" => "Author2",
           "Friend3" => "Author3",
        );

        foreach ($hash as $fkey => $akey)
        {
            if (empty($item[ $akey ]) && !empty($item[ $fkey ]))
            {
                $item[ $akey ]=$this->FriendsObj()->Sql_Select_Hash_Value($item[ $fkey ],"Name");
                array_push($updatedatas,$akey);
            }
        }

        $this->PostProcess_Certificate_TimeLoad($item,$updatedatas);
        $this->PostProcess_Code($item,$updatedatas);

        
        $this->PostProcess_Certificate($item);
        
        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
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
    //* function PostProcess_Certificate_TimeLoad, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess_Certificate_TimeLoad(&$item,&$updatedatas)
    {
        $event=$this->Event();
        if (
              $this->EventsObj()->EventCertificates($event)
              &&
              $this->EventsObj()->Event_Submissions_Has($event)
            )
        {
            $this->MakeSureWeHaveRead("",$item,array("Certificate","Certificate_TimeLoad"));
            if (!empty($item[ "Certificate" ]) && $item[ "Certificate" ]==2)
            {
                if (empty($item[ "Certificate_TimeLoad" ]))
                {
                    $item[ "Certificate_TimeLoad" ]=$event[ "Certificates_Submissions_TimeLoad" ];
                    array_push($updatedatas,"Certificate_TimeLoad");
                }
            }
        }
    }

    
    //*
    //* function PostProcess_Certificate, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription certificate.
    //*

    function PostProcess_Certificate(&$item)
    {
        if (!empty($item[ "Certificate" ]))
        {
            foreach (array("Friend","Friend2","Friend3") as $fdata)
            {
                if (empty($item[ $fdata ])) { continue; }
                
                $where=$this->Submission_Certificate_Where($item,$item[ $fdata ]);
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
                               "Submission" => $item[ "ID" ],
                               "Unit"        => $this->Unit("ID"),
                               "Event"        => $item[ "Event" ],
                               "Friend"       => $item[ $fdata ],
                               "Type"         => $this->Certificate_Type,
                               "Name"         => $item[ "Title" ],
                               "Code"         => $item[ "Code" ],
                            );

                        $this->CertificatesObj()->Sql_Insert_Item($cert);
                    }
                }
            }
        }
    }
    
    //*
    //* Overrides InitAddDefaults.
    //* Updates Friend to AddDefaults and AddFixedValues,
    //* then calls parent.
    //*

    function InitAddDefaults()
    {
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->LoginData("ID");
            $this->AddFixedValues[ "Friend" ]=$this->CGI_GETint("Friend");
            if (!empty($this->AddDefaults[ "Friend" ]))
            {
                $this->AddDefaults[ "Author1" ]=$this->LoginData("Name");
            }
        }
        elseif (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->CGI_GETint("Friend");
        }
        
        return parent::InitAddDefaults();
    }
}

?>