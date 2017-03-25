<?php


trait MyMod_Item_Group_Table
{
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

    function MyMod_Item_Group_Table($edit,$group,$item,$plural=FALSE,$precgikey="")
    {
        $table=
            $this->ItemTable
            (
               $edit,
               $item,
               TRUE,
               $this->ItemDataSGroups[ $group ][ "Data" ],
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
        
        array_unshift
        (
            $table,
            $this->MyMod_Item_Group_Table_Title($edit,$group)
        );

        return $table;
    }
    
    //*
    //* Create item Group html table.
    //*

    function MyMod_Item_Group_Table_HTML($edit,$group,$item,$plural=FALSE,$precgikey="",$options=array())
    {
        if (!empty($this->ItemDataSGroups[ $group ][ "GenTableMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "GenTableMethod" ];

            return $this->$method($edit,$item,$group);
        }

        $pre="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PreText" ]))
        {
            $pre=$this->ItemDataSGroups[ $group ][ "PreText" ];
        }

        $post="";
        if (!empty($this->ItemDataSGroups[ $group ][ "PostText" ]))
        {
            $post=$this->ItemDataSGroups[ $group ][ "PostText" ];
        }

        $method="Html_Table";
        if ($this->LatexMode())
        {
            $method="Latex_Table";
        }

        $table="";
        if (!empty($this->ItemDataSGroups[ $group ][ "Data" ]))
        {
            $table=
               $this->$method
               (
                  "",
                  $this->MyMod_Item_Group_Table($edit,$group,$item,$plural,$precgikey),
                  $options,
                  array(),
                  array(),
                  TRUE,
                  TRUE
               );
        }

        return 
            $pre.
            $table.
            $post.
            "";
    }
}

?>