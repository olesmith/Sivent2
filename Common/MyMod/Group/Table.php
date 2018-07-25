<?php

trait MyMod_Group_Table
{
    var $ItemTableRowsMethod="MyMod_Group_Rows_Item";
    
    //*
    //* function MyMod_Data_Group_Table_Data_Get, Parameter list: $group
    //*
    //* Detects datas from $group.
    //*

    function MyMod_Data_Group_Table_Data_Get($group)
    {
        if (empty($group)) { $group=$this->MyMod_Data_Group_Actual_Get(); }

        return $this->MyMod_Data_Group_Datas_Get($group);
    }

    
    //*
    //* function MyMod_Data_Group_Table, Parameter list: $title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar="Update"
    //*
    //* Creates data group table, group $group. If $group=="", calls MyMod_Data_Group_Actual_Get to detect it.
    //* $title, $edit and $items are transferred calling ItemTable.
    //*

    function MyMod_Data_Group_Table($title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar="Update")
    {
        if (empty($items)) { $items=$this->ItemHashes; }
        $this->Singular=False;

        if (empty($this->Actions))
        {
            $this->InitActions();
        }

        $this->ItemData("ID");
        $this->MyMod_Data_Groups_Initialize();
        
        if (empty($group)) { $group=$this->MyMod_Data_Group_Actual_Get(); }
        
        if (!empty($this->ItemDataGroups[ $group ][ "PreMethod" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "PreMethod" ];
            $this->$method();
        }

        $datas=$this->MyMod_Data_Group_Table_Data_Get($group);
        if (!empty($this->ItemDataGroups[ $group ][ "GenTableMethod" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "GenTableMethod" ];
            if (method_exists($this,$method))
            {
                return $this->$method($edit);
            }
            else
            {
                print "MyMod_Data_Group_Table: No such method: $method(\$edit)";
                exit();
            }
        }

        if (!empty($this->ItemDataGroups[ $group ][ "GenTableRowMethod" ]))
        {
            $this->ItemTableRowsMethod=$this->ItemDataGroups[ $group ][ "GenTableRowMethod" ];  
        }
        
        $countdef=array();
        if (
              isset($this->ItemDataGroups[ $group ][ "SubTable" ])
              &&
              is_array($this->ItemDataGroups[ $group ][ "SubTable" ])
           )
        {
            $countdef=$this->ItemDataGroups[ $group ][ "SubTable" ];
        }


        if (!empty($this->ItemDataGroups[ $group ][ "PreProcessor" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "PreProcessor" ];
            if (count($items)==0) { $items=$this->ItemHashes; }

            foreach ($items as $id => $item)
            {
                $this->$method($items[ $id ]);
            }
        }
        
        if (!empty($this->ItemDataGroups[ $group ][ "SumVars" ]))
        {
            $this->SumVars=array("");
        }

        return
            $this->MyMod_Group_Datas_Table
            (
                $title,
                $edit,
                $datas,
                $items,
                $countdef,
                $this->MyMod_Data_Group_Titles($group,$datas,$titles),
                TRUE,
                $cgiupdatevar
            );
    }

    
    //*
    //* function MyMod_Group_Datas_Table, Parameter list: $title,$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update"
    //*
    //* Joins table as a matrix for items in $items, or if empty, in $this->ItemHashes.
    //* Includes $title as a H2 title.
    //* If $edit==1 (Edit), produces input fields (Edit), otherwise just 'shows' data. Default 0 (Show).
    //* $titles should be deprecated!!! Title row is inserted in Table class.
    //* 

    function MyMod_Group_Datas_Table($title="",$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update",$nstart=1)
    {
        if (count($items)==0)     { $items=$this->ItemHashes; }
        if (count($datas)==0)     { $datas=$this->GetDefaultDataGroup(); }

        $searchvars=$this->MyMod_Search_Vars_Hash($datas);
        if ($this->MyMod_Search_Vars_Add_2_List)
        {
            $datas=$this->MyMod_Search_Vars_Add_2_List($datas);
        }

        $datas=$this->MyMod_Group_Datas_Get($datas); 

        if
            (
                $edit==1
                &&
                !empty($cgiupdatevar)
                &&
                $this->CGI_POSTint($cgiupdatevar)==1
            )
        {
            $items=$this->MyMod_Items_Update($items,$datas);
        }

        $showall=$this->CGI_POST($this->ModuleName."_Page");
        if (empty($showall))
        {
            $showall=$this->ShowAll;
        }
        else
        {
            $showall=TRUE;
        }

        $actions=array();
        if (is_array($this->ItemActions)) { $actions=$this->ItemActions; }

        $subdatas=array();
        $subtitles=array();
        if (count($countdef)>0)
        {
            $subdatas=$this->CheckHashKeysArray
            (
               $countdef,
               array($this->Profile."_Data",$this->LoginType."_Data","Data")
            );

            $rdatas=array();
            foreach ($subdatas as $data)
            {
                array_push($rdatas,$data."1");
            }

            $subtitles=$this->MyMod_Data_Titles($rdatas);


            $title1="";
            if (isset($countdef[ "NoTitle" ])) { $title1=$countdef[ "NoTitle" ]; }

            array_unshift($subtitles,$title1);
        }

        $n=1;
        $nitems=count(array_keys($items));

        $tbl=array();
        $even=False;
        $last=False;
        foreach (array_keys($items) as $id)
        {
            if ($n==$nitems) { $last=True; }

            $tbl=
                array_merge
                (
                    $tbl,
                    $this->MyMod_Group_Rows_Item
                    (
                        $edit,
                        $items[ $id ],
                        $n+$this->FirstItemNo,
                        $datas,
                        $subdatas,
                        $even,
                        $last
                    )
                );
            $n++;

            $even=!$even;
        }
        
        if (count($titles)>0)
        {
            array_unshift
            (
               $tbl,
               array
               (
                  "Class" => 'head',
                  "Row" => $this->MyMod_Sort_Title_Cells($titles),
               )
            );
        }
        
        if (!empty($title))
        {
            array_unshift($tbl,array($title));
        }

        if (count($this->SumVars)>0)
        {
            $tbl=
                array_merge
                (
                    $tbl,
                    $this->MyMod_Group_SumVars_Rows
                    (
                        $datas,
                        $this->MyMod_Group_SumVars_Items_Sum
                        (
                            $items,
                            $this->SumVars
                        )
                    )
                );
        }

        return $tbl;
    }

     //*
    //* function MyMod_Group_Datas_Get, Parameter list: $title,$edit=0,$datas=array(),$items=array(),$countdef=array(),$titles=array(),$sumvars=TRUE,$cgiupdatevar="Update"
    //*
    //* Returns list of data in items table.
    //* 

    function MyMod_Group_Datas_Get($datas)
    {
        $rdatas=array();

        $unique=array();
        foreach ($datas as $data)
        {
            if (preg_match('/newline/',$data))
            {
                array_push($rdatas,$data);
            }
            elseif (empty($unique[ $data ]))
            {
                array_push($rdatas,$data);
                $unique[ $data ]=TRUE;
            }
        }

        return $rdatas;
    }    

    //*
    //* function MyMod_Group_Datas_Title_Row, Parameter list: ($datas)
    //*
    //* 
    //* 

    function MyMod_Group_Datas_Title_Row($datas)
    {
        return
            $this->Html_Table_Head_Row
            (
                $this->MyMod_Data_Titles($datas)
            );
    }
}

?>