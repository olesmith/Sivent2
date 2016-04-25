<?php


trait MyMod_Item_Form
{
    //*
    //* Create item table.
    //*

    function MyMod_Item_Table_Contents($edit,$args)
    {
        return
            $this->H(5,"Editar ".$this->ItemName).
            $this->MyMod_Item_Table_Html
            (
               $edit,
               $args[ "Item" ],
               $args[ "Datas" ],
               TRUE //plural
            ).
             "";
    }

    //*
    //* Updates item form.
    //*

    function MyMod_Item_Update(&$item,$datas)
    {
        $items=$this->UpdateItems
        (
           array($item),
           $datas
        );

        $item=array_pop($items);
    }

    //*
    //* Updates item form.
    //*

    function MyMod_Item_Table_Update(&$args)
    {
        $this->MyMod_Item_Update($args[ "Item" ],$args[ "Datas" ]);
    }

    
    //*
    //* Runs item form.
    //*

    function MyMod_Item_Table_Form($args=array())
    {
        $args=array_merge
        (
           array
           (
              "Anchor"     => "TOP",
              "Uploads" => FALSE,
              "CGIGETVars" => array(),
              "CGIPOSTVars" => array(),

              "Item"   => array(),
              "Datas"   => array(),
              "Contents"   => "MyMod_Item_Table_Contents",
              "Options"    => array(),

              "EndButtons"   => $this->Buttons(),
              "Hiddens"   => array(),

              "Edit"   => 1,
              "Update" => 1,

              "ReadMethod" => "",
              "UpdateMethod" => "MyMod_Item_Table_Update",

              "UpdateCGIVar" => "Update",
              "UpdateCGIValue" => 1,
           ),
           $args
        );

        return $this->Form_Run($args);       
     }    
}

?>