<?php


trait MyMod_Items_PHP
{
    //*
    //* function MyMod_Import_Datas_Show, Parameter list:
    //*
    //* Returns datas supposed to show when importing.
    //*

    function MyMod_Import_Datas_Show()
    {
        $datas=$this->ItemDataGroups("Common","Data");
        $datas=$this->Datas2Datas($datas);

        if (!preg_grep('/^ID$/',$datas))
        {
            array_unshift($datas,"ID");
        }
        
        return $datas;
    }
    
    //*
    //* Exports items to PHP.
    //*

    function MyMod_Items_PHP($items)
    {
        $text="   array\n   (\n";
        foreach ($items as $item)
        {
            $text.=$this->MyMod_Item_PHP($item);
        }
        $text.="\n   ),\n";
        
        return $text;
    }
    
    //*
    //* Exports item to PHP.
    //*

    function MyMod_Item_PHP($item)
    {
        $empty="   ";
        $text=$empty.$empty."array\n".$empty.$empty."(\n";
        foreach ($item as $key => $value)
        {
            $value=preg_replace('/^\s+/',"",$value);
            $value=preg_replace('/\s+$/',"",$value);
            $value=preg_replace('/\s+/'," ",$value);
            $text.=
                $empty.$empty.$empty.
                "'".$key."'".
                " => ".
                '"'.$value.'",'.
                "\n";
        }
        $text.=$empty.$empty."),\n";

        return $text;
    }
    
    //*
    //* Exports items to PHP.
    //*

    function MyMod_Items_Export($items)
    {
        $text=
            $this->MyMod_Items_PHP($items);

        return $text;
    }
    
    //*
    //* Imports items from PHP into SQL table.
    //*

    function MyMod_Items_Import($items,$sqltable)
    {
        $this->ItemData("ID");
        $this->ItemDataGroups("Basic");

        $updatemsg="SQL Table: ".$sqltable;
        if ($this->CGI_POSTint("Structure")==1)
        {
            $this->Sql_Table_Structure_Update_Force=TRUE;
            $this->Sql_Table_Structure_Update(array(),array(),TRUE,$sqltable);
            $updatemsg.="Structure Updated";
        }
        
        $datas=$this->MyMod_Import_Datas_Show();

        $titles=$datas;
        array_push($titles,"Status");
        
        $table=array($this->H(5,$updatemsg));
        foreach ($items as $item)
        {
            $row=$this->MyMod_Item_Import($item,$sqltable,$datas);

            array_push($table,$row);
        }
        
        return
            $this->Html_Table
            (
               $titles,
               $table
            );
    }
    
    //*
    //* Imports item from PHP.
    //*

    function MyMod_Item_Import($item,$sqltable,$datas)
    {
        $row=array();
        foreach ($datas as $data)
        {

            array_push($row,$item[ $data ]);
        }

        $ritem=$this->Sql_Select_Hash(array("ID" => $item[ "ID" ]),array(),FALSE,$sqltable);
        $status="non-existent";
        $query="";

        if (empty($ritem))
        {
            $status="Create";
            if ($this->CGI_POSTint("Insert")==1)
            {
                $query=$this->Sql_Insert_Item_Query($item,$sqltable);
                $this->Sql_Insert_Item($item,$sqltable);
                $status="Created";
            }
        }
        else
        {
            $changed=array();
            foreach ($item as $key => $value)
            {
                if (empty($this->ItemData[ $key ])) { continue; }
                
                if (!isset($ritem[ $key ]) || $item[ $key ]!=$ritem[ $key ])
                {
                    array_push($changed,$key);
                }
            }

            if (count($changed)>0)
            {
                $status="Not Updated: ".join(", ",$changed);
                if ($this->CGI_POSTint("Insert")==1)
                {
                    $query=
                        $this->Sql_Update_Item_Query
                        (
                           $item,
                           array("ID" => $item[ "ID" ]),
                           $changed,
                           $sqltable
                        );
                    
                    $this->Sql_Update_Item
                    (
                       $item,
                       array("ID" => $item[ "ID" ]),
                       $changed,
                       $sqltable
                    );
                    
                    $status="Updated: ".join(", ",$changed);
                }
            }
            else {$status="Uptodate"; }
        }

        array_push($row,$status,$query);
        
        return $row;
    }
    
}

?>