<?php

trait MyMod_Group
{

    //*
    //* function , Parameter list: $title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar="Update"
    //*
    //* Creates data group table, group $group. If $group=="", calls GetActualDataGroup to detect it.
    //* $title, $edit and $items are transferred calling ItemTable.
    //*

    function MyMod_Data_Group_Table($title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar="Update")
    {
        if (empty($items)) { $items=$this->ItemHashes; }

        if (empty($this->Actions))
        {
            $this->InitActions();
        }

        if ($group=="") { $group=$this->GetActualDataGroup(); }
        if (!empty($this->ItemDataGroups[ $group ][ "PreMethod" ]))
        {
            $method=$this->ItemDataGroups[ $group ][ "PreMethod" ];
            $this->$method();
        }

        $datas=$this->GetGroupDatas($group);

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
            $this->ItemTableRowMethod=$this->ItemDataGroups[ $group ][ "GenTableRowMethod" ];
                
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


        if (count($titles)==0)
        {
            $titles=$datas;
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

        if (
            isset($this->ItemDataGroups[ $group ][ "NoTitleRow" ])
            &&
            $this->ItemDataGroups[ $group ][ "NoTitleRow" ]
           )
        {
            $titles=array();
        }
        
        if (!empty($this->ItemDataGroups[ $group ][ "SumVars" ]))
        {
            $this->SumVars=array("");
        }

        return
            $this->ItemsTable
            (
                $title,
                $edit,
                $datas,
                $items,
                $countdef,
                $titles,
                TRUE,
                $cgiupdatevar
            );
    }    
}

?>