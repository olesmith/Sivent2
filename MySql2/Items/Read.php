<?php


class ItemsRead extends ItemsLatex
{
    var $SortsAsOrderBy=FALSE;
    var $LastWhereClause="";

    //*
    //* function ReadItems, Parameter list: $where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=0,$nopostprocess=FALSE
    //*
    //* Reads items according to parameters:
    //*
    //* $where: where clause to use in select statement. Default *.
    //* $datas: array of data to read, default all.
    //* $nosearches: Ignore search vars. Default FALSE.
    //* $nopaging: do not do paging. Default FALSE.
    //* $includeall: If ==1, includes all items in table. Default Include_All CGI var,
    //*              from search form.
    //*
    //* If $includeall==0 and no search vars specified, ReadItems do not read any items at all.
    //* Prevents delayed onload, when 'many' items.
    //* ReadItems reads the CGI vars from the search table, calling GetDefinedSearchVars.
    //* If defined search vars not ijn $datas, these will be added.
    //* Stores list read in $this->ItemHashes, and returns this list.
    //*

    function ReadItems($where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=0,$nopostprocess=FALSE)
    {
        $this->ItemData=array();
        $this->ItemData();
 

        if (!is_array($where)) { $where=$this->SqlClause2Hash($where); }

        if ($this->NoSearches) { $nosearches=TRUE; }
        $this->NoSearches=$nosearches;

        if ($this->NoPaging) { $nopaging=TRUE; }
        if ($this->GetPOST($this->ModuleName."_NoPaging")==1) { $nopaging=TRUE; }

        $this->NoPaging=$nopaging;

        $rsearchvars=$this->MyMod_Items_Search_Vars_Get();
        
        if ($this->IncludeAll) { $includeall=2; }

        if ($includeall==0)
        {
            if (!$this->MyMod_Items_Search_Vars_Defined())
            {
                $includeall=$this->CGI2IncludeAll();
            }
        }

        //Figure out which data we should read
        $rdatas=$this->FindDatasToRead($datas,$nosearches);

        //Figure out where clause
        $rwhere=$this->MyMod_Items_Search_Where($where,$datas,$nosearches,$includeall);

        //Read
        $this->ItemHashes=array();
        if (!empty($rwhere) || count($rsearchvars)>0 || $includeall==2 || !empty($this->OnlyReadIDs))
        {
            $rwhere=$this->GetRealWhereClause($rwhere);
            if (empty($rwhere)) { $rwhere=array(); }
            if (!is_array($rwhere))
            {
                $rwhere=$this->SqlClause2Hash($rwhere);
            }
            if ($includeall!=2)
            {
                $rwhere=array_merge
                (
                   $rwhere,
                   $this->GetPreSearchVars()
                );
            }
            

            if ($this->OnlyReadIDs)
            {
                $rrwhere="ID IN ('".join("', '",$this->OnlyReadIDs)."')";
                if (empty($rwhere))
                {
                    $rwhere=$rrwhere;
                }
                else
                {
                    $rwhere=$rrwhere." AND ".$rwhere;
                }
            }

            $orderby="";
            if ($this->SortsAsOrderBy)
            {
                if (is_array($this->Sort))
                {
                    $orderby=join(", ",$this->Sort);
                }
                else
                {
                    $orderby=$this->Sort;
                }
            }

            $this->ItemHashes=$this->SelectHashesFromTable
            (
               $this->SqlTableName(),
               $rwhere,
               $rdatas,
               FALSE,
               $orderby
            );
            $this->LastWhereClause=$rwhere;

            //var_dump($rwhere);
            //var_dump($this->SqlTableName());
            //var_dump($rdatas);
            //var_dump(count($this->ItemHashes));
            //var_dump($this->ItemHashes[0]);
        }

        $this->SkipNonAllowedItems();

       //Search items
        if (!$nosearches && $includeall!=2)
        {
           $this->SearchItems();
        }

        $this->NumberOfItems=count($this->ItemHashes);

        if (!$this->SortsAsOrderBy)
        {
            $this->SortItems();
        }

        if (!$nopaging)
        {
            $this->InitPaging();

            $this->ItemHashes=array_splice
            (
               $this->ItemHashes,
               $this->FirstItemNo,
               $this->OffSet
            );
        }

        $this->ReadItemsDerivedData($rdatas);
        $this->SetItemsDefaults($rdatas);
        $this->TrimItems($rdatas);

        if (!$nopostprocess)
        {
            $this->PostProcessItems();
        }
    }

    //*
    //* function ReadItemsAsHashes, Parameter list: $where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=FALSE
    //*
    //* Calls ReadItems to read items, and the restores in a assoc array, id as keys.
    //*

    function ReadItemsAsHashes($where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=FALSE)
    {
        $this->ReadItems($where,$datas,$nosearches,$nopaging,$includeall);
        $ritems=array();
        foreach ($this->ItemHashes as $id => $item)
        {
            $ritems[ $item[ "ID" ] ]=$item;
        }

        return $ritems;
    }
}
?>