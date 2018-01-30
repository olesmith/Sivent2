<?php


trait MyMod_Items_Read
{
    //from Mysql2/Items/Read.php 
    var $SortsAsOrderBy=FALSE;
    
    //*
    //* function MyMod_Items_Read, Parameter list: $where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=0,$nopostprocess=FALSE
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

    
    function MyMod_Items_Read($where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=0,$nopostprocess=FALSE)
    {
        $this->ItemData=array();
        $this->ItemData();
 

        if (!is_array($where)) { $where=$this->SqlClause2Hash($where); }

        if ($this->NoSearches) { $nosearches=TRUE; }
        $this->NoSearches=$nosearches;

        if ($this->NoPaging) { $nopaging=TRUE; }
        if ($this->GetPOST($this->ModuleName."_NoPaging")==1) { $nopaging=TRUE; }

        $this->NoPaging=$nopaging;

        $rsearchvars=$this->MyMod_Search_Vars_Hash();
        
        if ($this->IncludeAll) { $includeall=2; }

        if ($includeall==0)
        {
            if (!$this->MyMod_Search_CGI_Vars_Defined_Has())
            {
                $includeall=$this->MyMod_Search_CGI_Include_All_Value();
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
            $rwhere=$this->MyMod_Items_Where_Clause_Real($rwhere);
            if (empty($rwhere)) { $rwhere=array(); }

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

            $this->ItemHashes=$this->Sql_Select_Hashes
            (
               $rwhere,
               $rdatas,
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
            $this->MyMod_Search_Items();
        }

        $this->NumberOfItems=count($this->ItemHashes);

        if (!$this->SortsAsOrderBy)
        {
            $this->MyMod_Sort_Items();
        }

        if (!$nopaging)
        {
            $this->MyMod_Paging_Init();

            $this->ItemHashes=array_splice
            (
               $this->ItemHashes,
               $this->FirstItemNo,
               $this->OffSet
            );
        }

        $this->MyMod_Items_Derived_Data_Read($rdatas);
        $this->SetItemsDefaults($rdatas);
        $this->TrimItems($rdatas);

        if (!$nopostprocess)
        {
            $this->MyMod_Items_PostProcess();
        }
    }

    function MyMod_Items_Derived_Data_Read($datas,$ids=array())
    {
        if (count($ids)==0) { $ids=array_keys($this->ItemHashes); }

        foreach ($ids as $id)
        {
            $this->ItemHashes[$id]=$this->MyMod_Item_Derived_Data_Read($this->ItemHashes[$id],$datas);
        }
    }
}

?>