<?php


trait MyMod_Item_Group_Table
{
    //*
    //* Returns datas for item data group.
    //*

    function MyMod_Item_Group_Table_Datas($group)
    {
        $datas=array();
        if (!empty($this->ItemDataSGroups[ $group ][ "TableDataMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "TableDataMethod" ];

            $datas=$this->$method($group);
        }
        elseif (!empty($this->ItemDataSGroups[ $group ][ "Data" ]))
        {
            $datas=$this->ItemDataSGroups[ $group ][ "Data" ];
        }
        
        return $datas;
    }
    
    //*
    //* Returns title for item data group.
    //*

    function MyMod_Item_Group_Table_Title($edit,$group)
    {
        $title=$this->GetRealNameKey($this->ItemDataSGroups[ $group ],"Name");
        if ($edit==1) { $title.=$this->SUP("","&dagger;"); }

        if ($this->LatexMode())
        {
            $title=
                "\\large{\\textbf{".$title."}}".
                "";
        }
        else
        {
            $title=$this->H(3,$title);
        }

        return $title;
    }
    
    //*
    //* Create item Group table (matrix).
    //*

    function MyMod_Item_Group_Table($edit,$group,$item,$plural=FALSE,$precgikey="",$title="",$precols=array(),$postcols=array())
    {
        $table=
            $this->Html_Table_Pad
            (
                $this->ItemTable
                (
                    $edit,
                    $item,
                    TRUE,
                    $this->MyMod_Item_Group_Table_Datas($group),
                    array(),
                    $plural,
                    FALSE,
                    FALSE,
                    $precgikey
                ),
                $precols,$postcols
            );

        if ($this->SGroups_NumberItems)
        {
            $n=1;
            foreach (array_keys($table) as $id)
            {
                array_unshift($table[ $id ],$this->B($n.":"));
                $n++;
            }
        }
        
        if (empty($title))
        {
            $title=$this->MyMod_Item_Group_Table_Title($edit,$group);
        }
        
        array_unshift
        (
            $table,
            $title
        );

        return $table;
    }
    
    //*
    //* MyMod_Item_Group_Table_Text_Pre
    //*

    function MyMod_Item_Group_Table_Text_Pre($group)
    {
        $pre="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PreText" ]))
        {
            $pre=$this->ItemDataSGroups[ $group ][ "PreText" ];
        }

        return $pre;
    }
    
    //*
    //* MyMod_Item_Group_Table_Text_Post
    //*

    function MyMod_Item_Group_Table_Text_Post($group)
    {
        $pre="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PostText" ]))
        {
            $pre=$this->ItemDataSGroups[ $group ][ "PostText" ];
        }

        return $pre;
    }
    

}

?>