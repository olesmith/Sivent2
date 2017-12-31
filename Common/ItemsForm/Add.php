<?php


trait ItemsFormAdd
{
    //*
    //* function ItemsForm_AddRowsForm, Parameter list:
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_AddItemForm()
    {
        return
            $this->Form_Run
            (
               array
               (
                  "ID"         => $this->Form_Number,
                  "Name"       => "AddForm",
                  "Method"     => "post",

                  "Action"     => 
                     "?Unit=".$this->GetCGIVarValue("Unit").
                     "&ModuleName=Events&Action=".
                     $this->CGI_Get("Action").
                     "&Event=".
                     $this->GetGET("Event")
                  ,

                  "Anchor"     => "TOP",
                  "Uploads" => FALSE,

                  "CGIGETVars" => array("Group","Datas","Datas_Sort","Datas_Reverse"),
                  "CGIPOSTVars" => array(),

                  "Contents"   => "ItemsForm_AddRowsTable",
                  "Options"    => array(),
                  "StartButtons"   => "",
                  "EndButtons"   => "",
                  "Buttons"   => "",
                  "Hiddens"   => array("Update" => 1),

                  "Edit"   => 1,
                  "Update" => 1,

                  "ReadMethod" => "",
                  //"UpdateMethod" => "ItemsForm_AddItem",
                  "ContentsHtml" => "",
                  "ContentsLatex" => "",

                  "UpdateCGIVar" => "Add",
                  "UpdateCGIValue" => 1,
               )
            ).
            "";

    }

    //*
    //* function ItemsForm_AddRowsTable, Parameter list:
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_AddRowsTable()
    {
        return $this->Html_Table
        (
           "",
           $this->ItemsForm_AddRows(),
           array("ALIGN" => 'center')
        );
    }


    //*
    //* function ItemsForm_AddTitleRows, Parameter list:
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_AddTitleRows()
    {
        $rows=array();
        foreach ($this->Table_TitleRows(FALSE) as $id => $titles)
        {
            array_push
            (
               $rows,
               array
               (
                  "Row" => $titles,
                  "Class" => 'head',
                  "TitleRow" => TRUE,
               )
            );
        }

        return $rows;
    }

    //*
    //* function ItemsForm_AddRows, Parameter list:
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_AddRows()
    {
        if (empty($this->Args[ "Edit" ]) || empty($this->Args[ "AddGroup" ])) { return array(); }

        $datas=array();
        foreach ($this->ItemDataGroups[ $this->Args[ "AddGroup" ] ][ "Data" ] as $data)
        {
            if (empty($this->Actions[ $data ]))
            {
                array_push($datas,$data);
            }
        }

        $showdatas=array();
        foreach ($this->ItemDataGroups[ $this->Args[ "AddGroup" ] ][ "ShowData" ] as $data)
        {
            if (empty($this->Actions[ $data ]))
            {
                array_push($showdatas,$data);
            }
        }

        $this->Args[ "Actions" ]=array();
        $this->Args[ "ShowDatas" ]=$showdatas;
        $this->Args[ "Datas" ]=$datas;

        $rows=array();
        $rows=array_merge
        (
           $rows,
           array($this->H(6,"Adicionar ".$this->ItemName))
        );

        if ($this->ItemsForm_ItemAdded)
        {
            $rows=array_merge
            (
               $rows,
               array
               (
                  $this->ItemsForm_ShowMessages
                  (
                     "Dado adicionado!",
                     "Dado ".$this->I("não")." Adicionado:"
                  )
               )
            );
        }

        $rows=array_merge
        (
           $rows,
           $this->ItemsForm_AddTitleRows(),
           $this->ItemsForm_AddTable()
        );


        return array("",$this->Html_Table("",$rows,array("ALIGN" => 'left')));
    }


    //*
    //* function ItemsForm_AddTable, Parameter list:
    //*
    //* Generates emtpy item add row as table matrix.
    //* 
    //*

    function ItemsForm_AddTable()
    {
        $nleadingcols=0;
        $n=0;
        foreach ($this->Table_RowDatas() as $data)
        {
            if (preg_match('/text/',$data))
            {
                $nleadingcols=$n;
                break;
            }

            $n++;
        }

        $rows=$this->Table_Rows
        (
           1,
           $this->ItemsForm_CGI2AddItem(),
           0,           //no counter!
           $this->Table_RowsNLeadingEmpties(),
           "Add_"
        );

        $ncols=0;
        foreach (array_keys($rows) as $id)
        {
            $ncols=$this->Max($ncols,count($rows[$id]));
        }

        array_push
        (
           $rows,
           array
           (
              $this->MultiCell
              (
                 $this->MakeButton('submit',"Adicionar",array("NAME" => "Add","VALUE" => 1)),
                 $ncols              
              )
           )
        );

        return $rows;
    }


    //*
    //* function ItemsForm_CGI2AddItem, Parameter list:
    //*
    //* Reads add item from cgi.
    //*

    function ItemsForm_CGI2AddItem()
    {
        $newitem=$this->Args[ "AddItem" ];
        foreach ($this->Args[ "AddDatas" ] as $data)
        {
            $newitem[ $data ]=$this->GetPOST("Add_".$data);
        }

        return $newitem;
    }

    //*
    //* function ItemsForm_AddItemMissingData, Parameter list: $newitem
    //*
    //* Reads add item from cgi.
    //*

    function ItemsForm_AddItemMissingData($newitem)
    {
        $missingdatas=array();
        foreach ($this->Args[ "AddDatas" ] as $data)
        {
            if (empty($newitem[ $data ]))
            {
                array_push($missingdatas,$data);
            }
        }

        if (count($missingdatas)>0) 
        {
            $this->ItemsForm_AddMessage
            (
                "Missing datas: ".
                join(", ",$missingdatas).
                " indefinidos.".
                $this->ItemName.
                "."
            );

            return FALSE;
        }

        return TRUE;
    }

    //*
    //* function ItemsForm_AddItemTestUniqueData, Parameter list: $newitem
    //*
    //* Reads add item from cgi.
    //*

    function ItemsForm_AddItemTestUniqueData($newitem)
    {
        $nitems=0;
        $nonuniquedatas=array();

        foreach ($this->Args[ "UniqueDatas" ] as $data)
        {
            $rnitems=$this->MySqlNEntries("",array($data => $newitem[ $data ]));
            if ($rnitems>0)
            {
                array_push($nonuniquedatas,$data);
                $nitems+=$rnitems;
            }
        }

        if ($nitems>0) 
        {
            $this->ItemsForm_AddMessage
            (
                "Chaves SQL: ".
                join(", ",$nonuniquedatas).
                " não única(s).".
                $this->ItemName.
                "."
            );

            return FALSE;
        }

        return TRUE;
    }


    //*
    //* function ItemsForm_AddItem, Parameter list: $event
    //*
    //* Adds new Event List to table.
    //*

    function ItemsForm_AddItem()
    {
        $newitem=$this->ItemsForm_CGI2AddItem();

        $add=TRUE;
        $add=$add && $this->ItemsForm_AddItemMissingData($newitem);
        $add=$add && $this->ItemsForm_AddItemTestUniqueData($newitem);

        if ($add)
        {
            $this->MySqlInsertItem("",$newitem);
            $newitem=$this->MyMod_Item_PostProcess($newitem);

            $this->ItemsForm_ItemAdded=TRUE;
            array_push($this->Args[ "Items" ],$newitem);
        }
   }

}

?>