<?php


trait MyMod_Item_Group_Html
{
    //*
    //* Create item Group tables html version.
    //*

    function MyMod_Item_Group_Tables_Html($redit,$groupdefs,$item,$buttons,$plural=FALSE,$options=array())
    {
        if (empty($options))
        {
            $options=
                array
                (
                    "ALIGN" => 'center',
                );
        }

        return
            $this->Htmls_Table
            (
                "",
                $this->MyMod_Item_Group_Tables($redit,$groupdefs,$item,$buttons,$plural),
                $options,
                array(),
                array("VALIGN" => "middle")
            );
    }
    
    //*
    //* Create item Group html table.
    //*

    function MyMod_Item_Group_Table_HTML($edit,$group,$item,$plural=FALSE,$precgikey="",$options=array(),$title="",$prerows=array(),$postrows=array(),$precols=array(),$postcols=array())
    {
        if (!empty($this->ItemDataSGroups[ $group ][ "GenTableMethod" ]))
        {
            $method=$this->ItemDataSGroups[ $group ][ "GenTableMethod" ];
            return $this->$method($edit,$item,$group);
        }

        $gtable=
            array_merge
            (
                $prerows,
                $this->MyMod_Item_Group_Table($edit,$group,$item,$plural,$precgikey,$title,$precols,$postcols),
                $postrows
            );

        $table="";
        if (!empty($this->ItemDataSGroups[ $group ][ "Data" ]))
        {
            if ($this->LatexMode())
            {
                $table=
                    $this->Latex_Table
                    (
                        "",
                        $gtable,
                        $options,
                        array(),
                        array(),
                        False,
                        False
                    );
            }
            else
            {
                $table=
                    $this->Htmls_Table
                    (
                        "",
                        $gtable,
                        $options,
                        array(),
                        array(),
                        False,
                        False
                    );
            }
        }

        

        return
            array
            (
                $this->MyMod_Item_Group_Table_Text_Pre($group),
                $table,
                $this->MyMod_Item_Group_Table_Text_Post($group),
            );
    }

}

?>