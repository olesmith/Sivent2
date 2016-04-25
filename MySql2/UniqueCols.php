<?php

include_once("Unique.php");
include_once("Table.php");

class UniqueCols extends Unique
{
    var $UniqueColumns=array();
    var $TestUnicity=TRUE;
    var $CroakUnicity=TRUE;
    var $AutoCorrectUnicity=TRUE;

    //*
    //* function SetAutoCorrectUnicity, Parameter list: $value=TRUE
    //*
    //* Sets on AutoCorrectUnicity.
    //*

    function AutoCorrectUnicity($value=TRUE)
    {
        $this->AutoCorrectUnicity=$value;
    }

    //*
    //* function UniqueWhere, Parameter list: $item
    //*
    //* Returns Unique SQL where as hash.
    //*

    function UniqueWhere($item)
    {
        $where=array();
        foreach ($this->UniqueColumns as $column)
        {
            $where[ $column]=$item[ $column];
        }

        return $where;
    }

    //*
    //* function CleanUnicity, Parameter list: $where
    //*
    //* Cleans Unique item $where.
    //*

    function CleanUnicity($where)
    {
        if (!$this->TestUnicity)
        {
            return;
        }

        $items=$this->SelectHashesFromTable
        (
           "",
           $where,
           array("ID")
        );

        $item=array();
        if (count($items)>1)
        {
            $item=array_shift($items);
            if ($this->AutoCorrectUnicity)
            {
                foreach ($items as $ritem)
                {
                    $this->Sql_Delete_Item($ritem[ "ID" ]);
                }

                if ($this->CroakUnicity)
                {
                    var_dump(count($items)." cleaned");
                }
            }
        }

        return $item;
    }


    //*
    //* function TestUnicity, Parameter list: $where,$field=""
    //*
    //* Returns Unique SQL where as hash.
    //*

    function TestUnicity($where,$field="")
    {
        if (!$this->TestUnicity)
        {
            return;
        }

        $items=$this->SelectHashesFromTable
        (
           "",
           $where,
           array()
        );

        $item=array();
        if (count($items)>1)
        {
            $vals=array();
            if (!empty($field))
            {
                foreach ($items as $ritem) { array_push($vals,$ritem[ $field ]); }
            }

            if ($this->CroakUnicity)
            {
                var_dump(count($items)." Itens, Student ".$where[ "Student" ].": ".join(", ",$vals));
            }

          var_dump($this->AutoCorrectUnicity);
           $item=array_shift($items);
            if ($this->AutoCorrectUnicity)
            {

               $this->CleanUnicity($where);
            }

        }

        return $item;
    }

    //*
    //* function ReadUniqueItem, Parameter list: $where
    //*
    //* Returns Unique SQL where as hash.
    //*

    function ReadUniqueItem($where)
    {
        $this->TestUnicity($where);
        $items=$this->SelectHashesFromTable
        (
           "",
           $where,
           array()
        );

        $item=array();
        if (count($items)>=1)
        {
            $item=array_shift($items);
        }

        return $item;
    }

    //*
    //* function CreateUniqueEntry, Parameter list: $where,$values=array()
    //*
    //* Creates unique entry.
    //*

    function CreateUniqueEntry($where,$values=array())
    {
        //var_dump("create");
        $nentries=$this->MySqlNEntries("",$where);
        if ($nentries>1)
        {
            var_dump("Creating:  doubled item");
        }

        $item=array();
        if ($nentries==0)
        {
            $item=$where;
            foreach ($values as $key => $value)
            {
                $item[ $key ]=$value;
            }

            $this->MySqlInsertItem("",$item);

            return TRUE;
        }
    }

    //*
    //* function DeleteUniqueEntry, Parameter list: $where
    //*
    //* Deletes unique entry.
    //*

    function DeleteUniqueEntry($where)
    {
        //var_dump("delete");
        if ($this->MySqlNEntries("",$where)==1)
        {
            $this->Sql_Delete_Items($where);
            return TRUE;
        }

        return FALSE;
    }

    //*
    //* function UpdateUniqueEntry, Parameter list: $where,$values=array()
    //*
    //* Updates unique entry.
    //*

    function UpdateUniqueEntry($where,$values=array())
    {
        //var_dump("update");
        $item=$this->ReadUniqueItem($where);
        if ($this->MySqlNEntries("",$where)==1)
        {
            foreach ($values as $key => $value)
            {
                $item[ $key ]=$value;
            }

            $this->MySqlSetItemValues("",array_keys($values),$item);

        }

        return FALSE;
    }

}

?>