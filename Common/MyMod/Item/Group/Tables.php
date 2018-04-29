<?php


trait MyMod_Item_Group_Tables
{
    //*
    //* Create item Group tables. Returns row list.
    //*

    function MyMod_Item_Group_Tables($redit,$groupdefs,$item,$buttons="",$plural=FALSE,$prekey="")
    {
        $tables=array();
        foreach ($groupdefs as $groupdef)
        {
            $row=array();
            foreach ($groupdef as $group => $gedit)
            {
                $gredit=$this->Max($gedit,$redit);

                $res=False;
                if (!empty($this->ItemDataSGroups[ $group ]))
                {
                    $res=$this->MyMod_Item_Group_Allowed
                    (
                        $this->ItemDataSGroups[ $group ],
                        $item
                    );
                }                

                if ($res)
                {
                    array_push
                    (
                       $row,
                       $this->MyMod_Item_Group_Table_HTML
                       (
                           $gredit,
                           $group,
                           $item,
                           $plural,
                           $prekey,
                           array
                           (
                               "WIDTH" => '100%'
                           )
                       )
                    );
                }
                else { array_push($row,$group); }
                
            }

            if (!empty($row))
            {
                array_push($tables,$row);

                if ($redit==1 && !empty($buttons))
                {
                    array_push($tables,$buttons);
                }
            }
        }


        return $tables;
    }

    
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

        $tdoptions=array("VALIGN" => "middle");
        
        return
            $this->Html_Table
            (
                "",
                $this->MyMod_Item_Group_Tables($redit,$groupdefs,$item,$buttons,$plural),
                $options,
                array(),
                $tdoptions
            ).
            "";
    }
    
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