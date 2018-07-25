<?php

trait MyMod_Item_SGroup
{
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroup_Allowed($groupdef,$item=array())
    {
        if (!is_array($groupdef))
        {
            $groupdef=$this->ItemDataSGroups($groupdef);
        }

        
    }
    
    //*
    //* Chekcs edit access to data sgroup.
    //*

    function MyMod_Item_SGroup_Editable($groupdef,$item=array())
    {
        if (!is_array($groupdef))
        {
            $groupdef=$this->ItemDataSGroups($groupdef);
        }
        
        $res=$this->MyMod_Item_Group_Allowed($groupdef,$item);
        if ($res && count($item)>0)
        {
            $key="EditAccessMethod";
            if (!empty($groupdef[ $key ]))
            {
                $accessmethods=$groupdef[ $key ];
                if (!is_array($groupdef[ $key ]))
                {
                    $groupdef[ $key ]=array($groupdef[ $key ]);
                }

                foreach ($groupdef[ $key ] as $method)
                {
                     $res=$res && $this->$method();
                     if (method_exists($this,$method))
                     {
                         $res=$res && $this->$method($item);
                     }
                     else
                     {
                         $this->Debug=1;
                         $this->AddMsg("MyMod_Item_SGroup_Editable: Invalid sgroup def access method: ".$method.", ignored");
                     }
                }
            }
        }
                
        return $res;
    }

    //*
    //* Creates item data single group table.
    //*

    function MyMod_Item_SGroup_Html_Row($edit,$item,$group,$datas=array(),$nofilefields=FALSE)
    {
        return
            array
            (
                $this->MyMod_Item_SGroup_Html($edit,$item,$group,$datas,array(),$nofilefields)
            );
    }
    
    //*
    //* Creates item data single group html table.
    //*

    function MyMod_Item_SGroup_Html($edit,$item,$group,$datas=array(),$rtbl=array(),$nofilefields=FALSE)
    {
        return
            $this->Htmls_Text
            (
                $this->MyMod_Item_SGroup_Htmls($edit,$item,$group,$datas,$rtbl,$nofilefields)
            );
    }

    
    //*
    //* Creates item data single group html table.
    //*

    function MyMod_Item_SGroup_Htmls($edit,$item,$group,$datas=array(),$rtbl=array(),$nofilefields=FALSE)
    {
        $res=$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ],$item);

        if (empty($res)) { return ""; }

        return
            $this->Htmls_Table
            (
               "",
               $this->MyMod_Item_SGroup_Table($edit,$item,$group,$datas,$rtbl,$nofilefields),
               array("WIDTH" => '100%'),array(),array(),
               False,False
            );
    }
    
    //*
    //* Detects list of data in SGroup.
    //*

    function MyMod_Item_SGroup_Datas_Get($group,$datas=array(),$nofilefields=FALSE)
    {
        $rdatas=array();
        if (count($datas)>0)
        {
            $rdatas=$datas;
        }
        elseif ($group!="All")
        {
            $rdatas=$this->MyMod_Data_Group_Datas_Get($group,TRUE); //use single data groups

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

        return $rdatas;
    }
    
    //*
    //* Creates item data single group table as matrix.
    //*

    function MyMod_Item_SGroup_Table($edit,$item,$group,$datas=array(),$rtbl=array(),$nofilefields=FALSE)
    {
        $res=$this->MyMod_Item_Group_Allowed($this->ItemDataSGroups[ $group ],$item);

        if ($edit==1)
        {
            $rres=$this->MyMod_Item_SGroup_Editable($this->ItemDataSGroups[ $group ],$item);
            if (!$rres) { $edit=0; }
        }
                   
        if (empty($res)) { return ""; }
       
        $rdatas=$this->MyMod_Item_SGroup_Datas_Get($group,$datas,$nofilefields);
        
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

            $rtbl=
                array_merge
                (
                    $rtbl,
                    $this->MyMod_Item_Table
                    (
                        $edit,
                        $item,
                        $rdatas,
                        $plural=FALSE,$includename=FALSE,$includecompulsorymsg=FALSE
                    )
                );
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
}

?>