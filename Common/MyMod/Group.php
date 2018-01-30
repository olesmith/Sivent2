<?php

include_once("Group/Cells.php");
include_once("Group/Titles.php");
include_once("Group/Row.php");
include_once("Group/Rows.php");
include_once("Group/Table.php");
include_once("Group/SumVars.php");
include_once("Group/Html.php");
include_once("Group/Form.php");


trait MyMod_Group
{
    use
        MyMod_Group_Cells,
        MyMod_Group_Titles,
        MyMod_Group_Row,
        MyMod_Group_Rows,
        MyMod_Group_Table,
        MyMod_Group_SumVars,
        MyMod_Group_HTML,
        MyMod_Group_Form;
    
    
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
        
        if ($group=="") { $group=$this->MyMod_Data_Group_Actual_Get(); }
        
        if (!empty($this->ItemDataGroups[ $group ][ "PreMethod" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "PreMethod" ];
            $this->$method();
        }

        $datas=$this->MyMod_Data_Group_Datas_Get($group);
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
}

?>