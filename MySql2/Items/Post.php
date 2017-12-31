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
    //* function PostProcessAllItems, Parameter list: $datas
    //*
    //* Reads and post processes all items.
    //*

    function PostProcessAllItems()
    {
        $this->NoSearches=TRUE;
        $this->NoPaging=TRUE;
        $this->IncludeAll=TRUE;

        $this->MyMod_Items_Read("",array(),TRUE,TRUE,TRUE);
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
            $items[$id]=$this->MyMod_Item_PostProcess($items[$id]);
        }
    }

}
?>