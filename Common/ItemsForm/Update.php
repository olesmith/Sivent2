<?php


trait ItemsFormUpdate
{
    //*
    //* function ItemsForm_Update, Parameter list:
    //*
    //* Updates items list form:
    //*
    //* Non-detailed items (data group row),
    //* Detailed item (data sgroups)
    //* Adds if specified.
    //*

    function ItemsForm_Update()
    {
        //Should run before table generation for new item to appear in first table.
        if ($this->GetPOST("Add")==1)
        {
            $this->ItemsForm_FromUpdated=TRUE;
            $this->ItemsForm_AddItem();
        }
        else
        {
            $this->ItemsForm_FromUpdated=TRUE;
            //Update List items
            $this->Args[ "Items" ]=$this->MyMod_Items_Update($this->Args[ "Items" ]);


            //Update Detailed Item
            foreach (array_keys($this->Args[ "Items" ]) as $id)
            {
                if ($this->CGI_GETint($this->Args[ "DetailsCGIVar" ])==$this->Args[ "Items" ][ $id ][ "ID" ])
                {
                    $this->ItemsForm_ItemDetailsUpdate($this->Args[ "Items" ][ $id ]);
                    break;
                }
            }
        }

        $this->ItemsForm_SortItems();
    }
}

?>