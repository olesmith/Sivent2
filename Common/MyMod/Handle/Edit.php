<?php

trait MyMod_Handle_Edit
{
    //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        if ($this->GetGETOrPOST("LatexDoc")>0)
        {
            $this->MyMod_Handle_Print();
        }

        if (empty($title)) { $title=$this->GetRealNameKey($this->Actions[ "Edit" ]); }

        if (count($this->ItemHash)>0)
        {
            return $this->MyMod_Handle_Edit_Form
            (
               $title,
               $this->ItemHash,
               1,
               $noupdate,
               array(),
               $echo,
               array(),
               $formurl
            );
        }
        else { $this->Warn( $this->ItemName." not found!",$this->ItemHash); }
    }

    
    //*
    //* Creates form for editing an item. If $_POST[ "Update" ]==1,
    //* calls Update.
    //*

    function MyMod_Handle_Edit_Form($title,$item=array(),$edit=0,$noupdate=FALSE,$datas=array(),$echo=TRUE,$extrarows=array(),$formurl=NULL,$buttons="",$cgiupdatevar="Update")
    {
        if (empty($buttons)) { $buttons=$this->Buttons(); }
        
        if (count($item)==0) { $item=$this->ItemHash; }

        if ($this->CGI_POSTint($cgiupdatevar)==1 && $edit==1 && !$noupdate)
        {
            $item=$this->TestItem($item);
            $item=$this->MyMod_Item_Update_CGI($item);
        }

        $hiddens=array();

        $this->AllDatas=array();
        foreach ($this->AllDatas as $data)
        {
            if ($this->MyMod_Data_Access($data,$item)>0)
            {
                $this->AllDatas[ $data ]=TRUE;
            }
        }

        $html=$this->Htmls_Text
        (
            $this->Htmls_DIV
            (
                $this->Htmls_Form
                (
                    $edit,
                    "EditItem",
                    $this->MyActions_Detect(),
                    $this->MyMod_Handle_Edit_Htmls($title,$edit,$item,$datas,$extrarows),
                    $args=array
                    (
                        "Suppress" => $this->MyMod_Handle_Edit_Form_Suppress(),
                        "Hiddens" => $this->MyMod_Handle_Edit_Form_Hiddens($item,$cgiupdatevar),
                    ),
                    $options=array()
                ),
                #DIV options
                array("ALIGN" => 'center')
            )
        );
        
        $html=$this->Htmls_Text($html);
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
    //* Returns list of cgi vars to suppress.
    //*

    function MyMod_Handle_Edit_Form_Suppress()
    {
        $suppresscgis=array_merge($this->NonPostVars,$this->NonGetVars);
            
        $action=$this->MyActions_Detect();
        if (!empty($action))
        {
            foreach (array("NonGetVars","NonPostVars") as $type)
            {
                $vars=$this->Actions($action,"NonGetVars");
                if (!empty($vars))
                {
                    $suppresscgis=array_merge($suppresscgis,$vars);
                }
            }
        }

        return $suppresscgis;
    }
    
    //*
    //* Cretaes table of sgroups table as listed html.
    //*

    function MyMod_Handle_Edit_Htmls($title,$edit,$item,$datas,$extrarows)
    {
        return
            array
            (
                $this->H(1,$title),
                $this->MyMod_Handle_Edit_Info_Table($item),
                $this->MyMod_Handle_Edit_Table($edit,$item,$datas,$extrarows)
            );
    }
    
    //*
    //* Cretaes table of sgroups table.
    //*

    function MyMod_Handle_Edit_Table($edit,$item,$datas,$extrarows)
    {
        $tbl=array();
        if ($this->SinglePrintables)
        {
            array_push($tbl,$this->GenerateLatexHorMenu());
        }
 
        if (count($datas)>0)
        {
            $tbl=$this->ItemTable($edit,$item,FALSE,$datas);
        }
        elseif (count($this->ItemDataSGroups)>0)
        {
            $tbl=$this->MyMod_Handle_Edit_SGroups_Tables($edit,$item);
        }
        else
        {
            $tbl=$this->ItemTable($edit,$item);
        }

        $tbl=array_merge($tbl,$extrarows);
        
        return 
            $this->Htmls_Table
            (
               "",
               $tbl,
               array
               (
                   #"ALIGN" => 'center',
                   #"BORDER" => 1,
                   "WIDTH" => "100%",
                   "CLASS" => 'sgroupstable borderless-table'
               ),
               array(),
               array
               (
                   "WIDTH" => '50%',
                   "CLASS" => 'sgroupstabledata'
               )
            );

    }

    //*
    //* Returns the edit form hidden fields.
    //*

    function MyMod_Handle_Edit_Form_Hiddens($item,$cgiupdatevar)
    {
        $hiddens=array();
        
        $hiddens[ $cgiupdatevar ]=1;        
        if ($this->IDAsHidden)
        {
            $hiddens[ "ID" ]=$item[ "ID" ];
        }

        return $hiddens;
    }
    
    //*
    //* Cretaes table of sgroups info table.
    //*

    function MyMod_Handle_Edit_Info_Matrix($item)
    {
        $infotable=array();
        if ($this->ShowTimes && isset($item[ "CTime" ]))
        {
            array_push
            (
               $infotable,
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

        return $infotable;
    }
    
    //*
    //* Cretaes table of sgroups info table as html.
    //*

    function MyMod_Handle_Edit_Info_Table($item)
    {
        return
            array
            (
                $this->Htmls_Table
                (
                    "",
                    $this->MyMod_Handle_Edit_Info_Matrix($item),
                    array(
                        "ALIGN" => 'center', 
                        "FRAME" => 'box'
                    )
                ),
                $this->BR()
            );
    }
    

    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Get($item,$ngroupsperline=2)
    {
        $sgroups=array();
        $row=array();
        foreach ($this->ItemDataSGroups as $group => $groupdef)
        {
            if (isset($groupdef[ "Visible" ]) && empty($groupdef[ "Visible" ])) { continue; }
            
            $access=$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ],$item);
            if (!$access) { continue; }
            
            if (!empty($groupdef[ "Single" ]))
            {
                array_push($sgroups,array($group));
                continue;
            }

            array_push($row,$group);

            if (count($row)==$ngroupsperline)
            {
                array_push($sgroups,$row);
                $row=array();
            }
        }
        
        if (count($row)>0)
        {
            array_push($sgroups,$row);
        }

        return $sgroups;
    }

    
    //*
    //* Returns 1 if sgroup is editable.
    //*

    function MyMod_Handle_Edit_SGroup_Edit($edit,$group,$item)
    {
        $redit=0;
        if ($edit==1 && $this->MyMod_Item_SGroup_Editable($group,$item))
        {
            $redit=1;
        }

        return $redit;
    }
    
    //*
    //* Creates table of sgroups tables.
    //*

    function MyMod_Handle_Edit_SGroups_Tables($edit,$item)
    {
        $table=array();
        foreach ($this->MyMod_Handle_Edit_SGroups_Get($item) as $grouprow)
        {
            $row=array();
            foreach ($grouprow as $group)
            {
                array_push
                (
                    $row,
                    $this->MyMod_Item_SGroup_Html_Row
                    (
                        $this->MyMod_Handle_Edit_SGroup_Edit($edit,$group,$item),
                        $item,
                        $group
                    )
                );
            }

            array_push($table,$row);
            if ($edit==1)
            {
                array_push($table,$this->Buttons());
            }
        }
        
        return $table;
    }

    
}

?>