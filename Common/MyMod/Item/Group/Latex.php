<?php


trait MyMod_Item_Group_Latex
{
    //*
    //* Create item Group tables latex version.
    //*

    function MyMod_Item_Groups_Tables_Latex($groupdefs,$item,$options)
    {
        $table=array();
        foreach ($groupdefs as $groupdef)
        {
            foreach ($groupdef as $group => $edit)
            {
                $res=
                    $this->MyMod_Item_Group_Allowed
                    (
                        $this->ItemDataSGroups[ $group ],
                        $item
                    );

                

                if ($res)
                {
                    $table=
                        array_merge
                        (
                            $table,
                            $this->MyMod_Item_Group_Table($edit,$group,$item)
                        );
                }
            }
        }
        
        return
            $this->Latex_Table
            (
                "",
                $table,
                $options
            ).
            "";
    }
}

?>