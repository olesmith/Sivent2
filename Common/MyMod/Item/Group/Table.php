<?php


trait MyMod_Item_Group_Table
{
    //*
    //* Returns datas for item data group.
    //*

    function MyMod_Item_Group_Table_Datas($group)
    {
        if (!empty($this->ItemDataSGroups[ $group ][ "TableDataMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "TableDataMethod" ];

            $datas=$this->$method($group);
        }
        else
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

    function MyMod_Item_Group_Table($edit,$group,$item,$plural=FALSE,$precgikey="",$title="")
    {
        $table=
            $this->ItemTable
            (
               $edit,
               $item,
               TRUE,
               $this->MyMod_Item_Group_Table_Datas($edit,$item,$group),
               array(),
               $plural,
               FALSE,
               FALSE,
               $precgikey
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
    
    //*
    //* Create item Group html table.
    //*

    function MyMod_Item_Group_Table_HTML($edit,$group,$item,$plural=FALSE,$precgikey="",$options=array(),$title="",$prerows=array(),$postrows=array())
    {
        if (!empty($this->ItemDataSGroups[ $group ][ "GenTableMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "GenTableMethod" ];

            return $this->$method($edit,$item,$group);
        }

        $method="Html_Table";
        if ($this->LatexMode())
        {
            $method="Latex_Table";
        }

        $gtable=
            array_merge
            (
                $prerows,
                $this->MyMod_Item_Group_Table($edit,$group,$item,$plural,$precgikey,$title),
                $postrows
            );
        
        $table="";
        if (!empty($this->ItemDataSGroups[ $group ][ "Data" ]))
        {
            $table=
               $this->$method
               (
                  "",
                  $gtable,
                  $options,
                  array(),
                  array(),
                  TRUE,
                  TRUE
               );
        }

        

        return 
            $this->MyMod_Item_Group_Table_Text_Pre($group).
            $table.
            $this->MyMod_Item_Group_Table_Text_Post($group).
            "";
    }
}

?>