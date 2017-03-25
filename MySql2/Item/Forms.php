<?php

class ItemForms extends Fields
{

    var $AddDatas=array();
    var $ShowTimes=FALSE;
    var $SinglePrintables=FALSE;
    var $AllDatas=array();
    var $AddReloadAction="Edit";
    var $IDAsHidden=TRUE;


    //*
    //* Creates item data single group table.
    //*

    function ItemDataSGroupTable($edit,$item,$group,$datas=array(),$rtbl=array(),$nofilefields=FALSE)
    {
        $res=$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ],$item);

        if ($edit==1)
        {
            $rres=$this->MyMod_Item_Group_Editable($this->ItemDataSGroups[ $group ],$item);
            if (!$rres) { $edit=0; }
        }
                   
        if (empty($res)) { return ""; }

        $rdatas=array();
        if (count($datas)>0)
        {
            $rdatas=$datas;
        }
        elseif ($group!="All")
        {
            $rdatas=$this->GetGroupDatas($group,TRUE); //use single data groups

            if (empty($rdatas)) { return array(); }
        }
        else
        {
            $rdatas=array_keys($this->AllDatas);
        }

        if (empty($rdatas)) { return array(); }

        foreach ($rdatas as $id => $data)
        {
            if (
                  $nofilefields
                  &&
                  $this->MyMod_Data_Field_Is_File($data)
               )
            {
                unset($rdatas[ $id ]);
                continue;
            }
            
            unset($this->AllDatas[ $data ]);
        }

        if (!empty($this->ItemDataSGroups[ $group ][ "GenTableMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "GenTableMethod" ];
            if (method_exists($this,$method))
            {
                $rtbl=$this->$method($edit,$item,$group);

                if (!is_array($rtbl)) { $rtbl=array(array($rtbl)); }
            }
            else
            {
                $this->AddMsg("SGroups '$group' GenTableMethod: ".
                              "'$method', is undefined: Ignored!");
            }
        }
        else
        {
            array_push
            (
               $rtbl,
               $this->H
               (
                  3,
                  $this->GetRealNameKey($this->ItemDataSGroups[ $group ],"Name")
               )
            );
            $rtbl=$this->ItemTable($edit,$item,0,$rdatas,$rtbl,FALSE,FALSE,FALSE);
        }

        //Make sure that $data only appears once as input field
        if ($edit==1)
        {
            foreach ($rdatas as $id => $data)
            {
                $this->ItemData[ $data ][ "ReadOnly" ]=1;
                $this->ItemData[ $data ][ "AdminReadOnly" ]=1;
            }
        }

        return $rtbl;
    }


     //*
    //* Creates item data single group html table.
    //*

    function ItemHtmlTableDataSGroup($edit,$item,$group,$datas=array(),$rtbl=array(),$nofilefields=FALSE)
    {
        $res=$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ],$item);

        if (empty($res)) { return ""; }

        return
            $this->HTML_Table
            (
               "",
               $this->ItemDataSGroupTable($edit,$item,$group,$datas,$rtbl,$nofilefields),
               array("WIDTH" => '100%'),array(),array(),
               TRUE,TRUE
            );
    }
    //*
    //* Creates item data single group table.
    //*

    function ItemTableDataSGroup($edit,$item,$group,$datas=array(),$nofilefields=FALSE)
    {
        return array($this->ItemHtmlTableDataSGroup($edit,$item,$group,$datas,array(),$nofilefields));
    }


    //*
    //* Creates form for editing an item. If $_POST[ "Update" ]==1,
    //* calls Update.
    //*

    function EditForm($title,$item=array(),$edit=0,$noupdate=FALSE,$datas=array(),$echo=TRUE,$extrarows=array(),$formurl=NULL,$buttons="",$cgiupdatevar="Update")
    {
        if (empty($buttons)) { $buttons=$this->Buttons(); }
        
        $html="";
        if (count($item)==0) { $item=$this->ItemHash; }

        if ($this->GetPOST($cgiupdatevar)==1 && $edit==1 && !$noupdate)
        {
            $item=$this->TestItem($item);
            $item=$this->UpdateItem($item);
        }

        //$this->ApplicationObj->LogMessage("EditForm",$item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item));

        $tbl=array();
        $hiddens=array();

        $this->AllDatas=array();
        foreach ($this->AllDatas as $data)
        {
            if ($this->MyMod_Data_Access($data,$item)>0)
            {
                $this->AllDatas[ $data ]=TRUE;
            }
        }

        if (count($datas)>0)
        {
            $tbl=$this->ItemTable($edit,$item,FALSE,$datas);
        }
        elseif (count($this->ItemDataSGroups)>0)
        {
           //we will generate a list of tables
            $tables=array();
            $row=array();
            foreach ($this->ItemDataSGroups as $group => $groupdef)
            {
                if (isset($groupdef[ "Visible" ]) && empty($groupdef[ "Visible" ])) { continue; }

                if (
                    !empty($groupdef[ $this->ApplicationObj->Profile ])
                    &&
                    $groupdef[ $this->ApplicationObj->Profile ]<1
                   )
                {
                    continue;
                }
                elseif (
                    !empty($groupdef[ $this->ApplicationObj->LoginType ])
                    &&
                    $groupdef[ $this->ApplicationObj->LoginType ]<1
                   )
                {
                    continue;
                }
 
                $table=$this->ItemTableDataSGroup($edit,$item,$group);

                if (!empty($table[0]))
                {
                    if (!empty($groupdef[ "Single" ]))
                    {
                        if (count($row)>0)
                        {
                            array_push($tables,$row,$table);
                            $row=array();
                        }
                        else
                        {
                            array_push($tables,$table);
                        }
                        
                        if ($edit==1 && !empty($buttons))
                        {
                            array_push($tables,$buttons);
                        }
                        continue;
                    }
                    
                    array_push($row,$table);
                    if (count($row)==2 || !empty($groupdef[ "Single" ]))
                    {
                        array_push($tables,$row);
                        if ($edit==1 && !empty($buttons))
                        {
                            array_push($tables,$buttons);
                        }
                    
                        $row=array();
                    }
                }
            }

            if (count($row)>0)
            {
                array_push($tables,$row);
                if ($edit==1 && !empty($buttons))
                {
                    array_push($tables,$buttons);
                }
            }

            $tbl=$tables;
        }
        else
        {
            $tbl=$this->ItemTable($edit,$item);
        }

        foreach ($extrarows as $row)
        {
            array_push($tbl,$row);
        }

        $printtable="";
        if ($this->SinglePrintables)
        {
            array_unshift($tbl,$this->GenerateLatexHorMenu());
        }

        if ($edit==1 && !empty($buttons))
        {
            array_unshift($tbl,$buttons);
        }
        
        $tbl=$this->FrameIt
        (
            $this->HTML_Table
            (
               "",
               $tbl,
               array("ALIGN" => 'center'),
               array(),
               array("WIDTH" => '50%')
            )
        );


        $name=$this->MyMod_Item_Name_Get($item);
        $html.=$this->H(1,$title);

        $infotables=array();

        if ($this->ShowTimes && isset($item[ "CTime" ]))
        {
            array_push
            (
               $infotables,
               array
               (
                  $this->SPAN
                  (
                     $this->GetMessage($this->ItemDataMessages,"Created").":",
                     array("CLASS" => 'searchtitle')
                  ),
                  $this->TimeStamp2Text($item[ "CTime" ])
               ),
               array
               (
                  $this->SPAN
                  (
                     $this->GetMessage($this->ItemDataMessages,"LastChange").":",
                     array("CLASS" => 'searchtitle')
                  ),
                  $this->TimeStamp2Text($item[ "MTime" ])
               )
            );
        }
       

        $html.=
            $this->Html_Table("",$infotables,array("ALIGN" => 'center',"FRAME" => 'box')).
            $this->BR();

        if ($edit==1)
        {
            $id="";
            if ($this->HashKeySetAndPositive($item,"ID"))
            {
                $id="&ID=".$item[ "ID" ];
            }

            if (!$formurl)
            {
                $formurl="?Action=".$this->MyActions_Detect().$id;
            }

            $html.=
                $printtable.
                $this->StartForm($formurl,"post",$this->HasFileFields).
                "";
        }

        $html.=$tbl;


        if ($edit==1)
        {
            $html.=
                $this->MakeHidden($cgiupdatevar,1).
                "";

            if ($this->IDAsHidden)
            {
                $html.=
                    $this->MakeHidden("ID",$item[ "ID" ]);
            }

            $html.=
                $this->EndForm().
                "";
        }

        if ($echo)
        {
            echo $html;
            return "";
        }
        else
        {
            return $html;
        }
    }

    //*
    //* function InitAddDefaults, Parameter list: $hash=array()
    //*
    //* Puts some default values into the AddDefaults array.
    //* Creator is set to LoginID.
    //*

    function InitAddDefaults($hash=array())
    {
        foreach ($hash as $data => $value)
        {
            $this->AddDefaults[ $data ]=$value;
        }
        foreach ($this->AddFixedValues as $data => $value)
        {
            $this->AddDefaults[ $data ]=$value;
        }


        if ($this->LoginType!="Admin" && isset($this->ItemData[ $this->CreatorField ]))
        {
            $this->AddDefaults[ $this->CreatorField ]=$this->LoginData[ "ID" ];
            $this->AddDefaults[ $this->CreatorField."_Value" ]=$this->LoginData[ "Name" ];
        }

        foreach (array_keys($this->ItemData) as $data)
        {
            if (
                isset($this->ItemData[ $data ][ "Default" ])
                &&
                !isset($this->AddDefaults[ $data ]))
            {
                $this->AddDefaults[ $data ]=$this->ItemData[ $data ][ "Default" ];
            }

            if (
                isset($this->ItemData[ $data ][ "NoAdd" ])
                &&
                $this->ItemData[ $data ][ "NoAdd" ]
                &&
                !$this->ItemData[ $data ][ "Compulsory" ]
               )
            {
                unset($this->AddDefaults[ $data ]);
                $this->ItemData[ $data ][ $this->Profile ]=0;
            }
        }

        //$this->AddDefaults=$this->TestItem($this->AddDefaults);
    }


    //*
    //* Creates table for adding data. May be overwritten.
    //*

    function MakeAddTable($datas)
    {
        $rdatas=array();
        foreach ($datas as $data)
        {
            if (!preg_match('/^[ACM]Time$/',$data) && !$this->ItemData[ $data ][ "NoAdd" ])
            {
                array_push($rdatas,$data);
            }
            elseif ($this->ItemData[ $data ][ "Compulsory" ])
            {
                array_push($rdatas,$data);
            }
        }

        $table=array();
        if (count($this->ItemDataSGroups)>0)
        {
            //we will generate a list of tables
            foreach ($this->ItemDataSGroups as $group => $groupdef)
            {
                $table=
                    array_merge
                    (
                       $table,
                       $this->ItemTableDataSGroup(1,$this->AddDefaults,$group,array(),TRUE)
                    );

             }
        }
        else
        {
            $table=$this->ItemTable
            (
               1,
               $this->AddDefaults,
               1,
               $rdatas
            );
        }
        
        array_unshift($table,$this->Buttons());
        array_push($table,$this->Buttons());

        return $this->HTML_Table
        (
           "",
           $table,
           array
           (
              "ALIGN" => 'center',
              "BORDER" => 1
           ),
           array(),
           array(),
           TRUE,
           TRUE
        );
    }


    //*
    //* Pretext function. Returns empty string, supposed to be overridden.
    //*

    function AddForm_PreText()
    {
        return "";
    }

    //*
    //* Posttext function. Returns empty string, supposed to be overridden.
    //*

    function AddForm_PostText()
    {
        return "";
    }

    
    //*
    //* Creates form for adding an item. If $_POST[ "Update" ]==1,
    //* calls Add.
    //*

    function AddForm($title,$addedtitle,$echo=TRUE)
    {
        $this->Singular=TRUE;
        $rdatas=$this->FindAllowedData(0);
        $datas=array();
        foreach ($rdatas as $data)
        {
            if (
                 !preg_match('/^[ACM]Time$/',$data)
                 &&
                 !$this->ItemData[ $data ][ "NoAdd" ]
               )
            {
                array_push($datas,$data);
            }
            elseif ($this->ItemData[ $data ][ "Compulsory" ])
            {
                array_push($datas,$data);
            }
        }

        if (is_array($this->AddDatas) && count($this->AddDatas)>0) { $datas=$this->AddDatas; }

        $this->InitAddDefaults();

        $html="";
        $action="Add";
        $action=$this->MyActions_Detect();
        $msg="";
        if ($this->GetPOST("Add")==1)
        {
            $res=$this->Add($msg);
            if ($res)
            {
                $args=$this->Query2Hash();
                $args=$this->Hidden2Hash($args);
                $query=$this->Hash2Query($args);

                $action=$this->MyActions_Detect();

                $this->AddCommonArgs2Hash($args);
                $args[ "Action" ]=$this->MyActions_Detect();
                if ($args[ "Action" ]=="Add") { $args[ "Action" ]=$this->AddReloadAction; }

                $args[ "ID" ]=$this->ItemHash[ "ID" ];

                //Now added, reload as edit, preventing multiple adds
                header("Location: ?".$this->Hash2Query($args));
                exit();
            }
        }

        $this->ApplicationObj->MyApp_Interface_Head();
        $html=
            $this->AddForm_PreText().
            $this->H(2,$title).
            $msg.
            $this->StartForm("?Action=".$action).
            $this->MakeAddTable($datas).
            $this->MakeHidden("Add",1).
            $this->EndForm().
            $this->AddForm_PostText().
            "";

        if ($echo)
        {
            $this->MyMod_HorMenu_Echo(TRUE);
            echo $html;
            return "";
        }
        else
        {
            return $html;
        }
   }


    //*
    //* Creates form for copying an item. If $_POST[ "Update" ]==1,
    //* calls Copy.
    //*

    function CopyForm($title,$copiedtitle)
    {
        $this->Singular=TRUE;
        $this->NoFieldComments=TRUE;

        /* $id=$this->CGI_GETint("ID"); */
        /* if (!empty($id)) */
        /* { */
        /*     $this->ItemHash=$this->Sql_Select_Hash(array("ID" => $id)); */
        /*     if (empty($this->ItemHash)) */
        /*     { */
        /*         $this->DoDie("No such item ".$id); */
        /*     } */
        /* } */

        $item=$this->ItemHash;
        $this->InitAddDefaults();

        $action="Copy";
        $msg="";
        if ($this->GetPOST("Copy")==1)
        {
            $res=$this->Copy();
            if ($res)
            {
                $args=$this->Query2Hash();
                $args=$this->Hidden2Hash($args);
                $query=$this->Hash2Query($args);

                $action=$this->MyActions_Detect();

                $this->AddCommonArgs2Hash($args);
                $args[ "Action" ]=$this->MyActions_Detect();
                if ($args[ "Action" ]=="Copy") { $args[ "Action" ]="Edit"; }

                $args[ "ID" ]=$this->ItemHash[ "ID" ];
                $var=$this->IDGETVar;
                if (
                      !empty($var)
                      &&
                      !empty($args[ $var ])
                   )
                {
                    unset($args[ $var ]);
                }

                $this->ApplicationObj->LogMessage("Copy","Item Added");
                
                //Now added, reload as edit, preventing multiple adds, the user reloading the page.
                header("Location: ?".$this->Hash2Query($args));
                exit();
            }
            else
            {
                $msg=$this->H(4,$this->ItemName." não Copiado");
            }
        }

        
        $this->ApplicationObj->MyApp_Interface_Head();

        foreach ($this->AddDefaults as $data => $value)
        {
            if (empty($item[ $data ]))
            {
                $item[ $data ]=$value;
                $item[ $data."_Value" ]=$value;
            }
        }

        $this->MyMod_HorMenu_Echo(TRUE,$this->CGI_GET("ID"));
        echo
            $this->H(2,$title).
            $msg.
            $this->H(3,$this->MyMod_Item_Name_Get($item)).
            $this->StartForm("?Action=".$action).
            $this->HTMLTable
            (
               "",
               $this->ItemTable
               (
                  1,
                  $item,
                  1,
                  $this->GetNonReadOnlyData()
               )
            ).
            $this->MakeHidden("Copy",1);

        echo
            $this->Buttons().
            $this->EndForm();
    }


    //*
    //* Creates form for deleting an item. If $_POST[ "Delete" ] is 1,
    //* calls Delete for actual deletion.
    //*

    function DeleteForm($title,$deletedtitle,$item=array(),$echo=TRUE,$formurl="?Action=Delete",$idvar="ID")
    {
        return MyMod_Handle_Delete_Form($title,$deletedtitle,$item,$echo,$formurl,$idvar);
    }

}
?>