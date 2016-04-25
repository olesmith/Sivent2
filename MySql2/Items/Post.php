<?php


class ItemsPost extends ItemsGroupTable
{
    //*
    //* function PostInitItems, Parameter list:
    //*
    //* Items post initializer. Joins names of data groups.
    //*

    function PostInitItems()
    {
        $groups=array();
        foreach ($this->ItemDataGroups as $groupname => $group)
        {
            //Check if group allowed
            if (
                !empty($this->ItemDataGroups[ $groupname ][ $this->LoginType ])
                ||
                !empty($this->ItemDataGroups[ $groupname ][ $this->Profile ])
               )
            {
                array_push($groups,$groupname);
            }
        }

        $this->ItemDataGroupNames=$groups;
    }


    //*
    //* function PostProcessItems, Parameter list: $ids=array()
    //*
    //* Post processes all items, according to $ids. Also updates ATime's.
    //*

    function PostProcessItems($ids=array())
    {
        if (count($ids)==0) { $ids=array_keys($this->ItemHashes); }

        foreach ($ids as $id)
        {
            $this->ItemHashes[$id]=$this->SetItemTime("ATime",$this->ItemHashes[$id]);
            //$this->SetItemTime("ATime",$this->ItemHashes[$id]); //do not store, read next time through

            $this->ItemHashes[$id]=$this->PostProcessItem($this->ItemHashes[$id]);
       }
    }

    //*
    //* function PostProcessAllItems, Parameter list: $datas
    //*
    //* Reads and post processes all items.
    //*

    function PostProcessAllItems()
    {
        $this->NoSearches=TRUE;
        $this->NoPaging=TRUE;
        $this->IncludeAll=TRUE;

        $this->ReadItems("",array(),TRUE,TRUE,TRUE);
   }

    //*
    //* function PostProcessAllItems, Parameter list: &$items
    //*
    //* Reads and post processes list of $items.
    //*

    function PostProcessItemList(&$items)
    {
        foreach (array_keys($items) as $id)
        {
            $items[$id]=$this->PostProcessItem($items[$id]);
        }
    }

}
?>