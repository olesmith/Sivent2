<?php


trait MyMod_Item_Form
{
    //*
    //* Create item table.
    //*

    function MyMod_Item_Table_Contents($edit,$args)
    {
        $table=
            $this->MyMod_Item_Table
            (
               $edit,
               $args[ "Item" ],
               $args[ "Datas" ],
               TRUE //plural
             );

        if (!empty($args[ "TablePreRows" ]))
        {
            $table=array_merge($args[ "TablePreRows" ],$table);
        }
        
        if (!empty($args[ "TablePostRows" ]))
        {
            $table=array_merge($table,$args[ "TablePostRows" ]);
        }

        $method="Html_Table";
        if ($this->LatexMode())
        {
            $method="LatexTable";
        }
        
        $method=$this->TableMethod();
        return
            $this->H(5,$args[ "Form_Title" ]).
            $this->$method("",$table).
            "";
    }

    
    //*
    //* Runs item form.
    //*

    function MyMod_Item_Table_Form($args=array())
    {
        $this->Actions();
        $submit=
            $this->GetMessage($this->HtmlMessages,"SendButton").
            " ".
            $this->MyMod_ItemName();
        
        $args=array_merge
        (
           array
           (
              "Anchor"     => "TOP",
              "Uploads" => TRUE,
              "CGIGETVars" => array(),
              "CGIPOSTVars" => array(),

              "Item"   => array(),
              "Datas"   => array(),
              "Contents"   => "MyMod_Item_Table_Contents",
              "Options"    => array(),
              "Form_Title"    => "Editar ".$this->ItemName,

              "EndButtons"   => $this->Buttons($submit),
              "Hiddens"   => array(),

              "Edit"   => 1,
              "Update" => 1,

              "ReadMethod" => "",
              "UpdateMethod" => "MyMod_Item_Table_Update",

              "UpdateCGIVar" => "Update",
              "UpdateCGIValue" => 1,
              
              "TablePreRows" => array(),
              "TablePostRows" => array(),
           ),
           $args
        );

        return $this->FrameIt($this->Form_Run($args));       
     }    
}

?>