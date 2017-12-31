<?php

class ItemPostProcess extends ItemReads
{

    var $PostProcessed=array();

    //*
    //* function PostInitItem, Parameter list:
    //*
    //* Post Initializer. Should be called when data definitions has been read.
    //* Gathers allowed Data SGroups, Single Item Groups, based on LoginType.
    //*

    function PostInitItem()
    {
        if (!is_array($this->ItemDataSGroups)) { return; }

        $rgroups=array();
        foreach ($this->ItemDataSGroups as $groupname => $group)
        {
            //Check if group allowed
            if ($this->ItemDataSGroups[ $groupname ][ $this->LoginType ]>0)
            {
                array_push($rgroups,$groupname);
            }
        }

        $this->ItemDataSGroupNames=$rgroups;
    }


    
    //*
    //* function PostProcessSqlObjects, Parameter list: $item
    //*
    //* 
    //*

    function PostProcessNestedData($item,$datadefs)
    {
        $updatedatas=array();
        foreach ($datadefs as $n => $datadef)
        {
            $startdata1=$datadef[ "From1" ];
            $startdata2=$datadef[ "From2" ];
            if ($startdata2=="") { $startdata2=$startdata1; }

            $destdata=$datadef[ "Dest" ];

            if (isset($item[ $startdata1 ]))
            {
                if (
                    isset($item[ $startdata2 ])
                    &&
                    $item[ $startdata2 ]>0
                    &&
                    (
                     !isset($item[ $destdata ])
                     ||
                     $item[ $destdata ]!=$item[ $startdata2 ]
                    )
                   )
                {
                    $item[ $destdata ]=$item[ $startdata2 ];
                    array_push($updatedatas,$destdata);
                }
            }
        }

        if (count($updatedatas)>0)
        {
            //var_dump($updatedatas);
            $this->MySqlSetItemValues
            (
               "",
               $updatedatas,
               $item
            );
        }

        return $item;
    }

}
?>