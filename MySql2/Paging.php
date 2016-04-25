<?php


class Paging extends Items
{

    //
    // Variables of Items class:

    var $Page,$PageURL="",
        $NItemsPerPage=15,
        $NumberOfItems=0,
        $FirstItemNo=0,
        $LastItemNo=0,
        $OffSet=0;


    var $NPagesInMenu=5,$NIntermediatePages=20;
    var $PageFirstNames=array();

    var $ActiveID=0;
    var $PresetPage="",$PageNo=0,$NPages=0;
    var $PagingFormWritten=FALSE;
    var $PagingMessages="Paging.php";

    //*
    //* function , Parameter list: 
    //*
    //* 
    //*

    function InitPaging($hash=array())
    {
        $query=$this->ScriptQueryHash();
        unset($query[ "Page" ]);

        $query=$this->SearchVarsAsHash($query);

        $this->PageURL=$this->ScriptExec($this->Hash2Query($query));
 
        $this->NumberOfItems=count($this->ItemHashes);
        foreach (array_keys($this->ItemHashes) as $id)
        {
            $name="";
            if (!empty($this->ItemHashes[ $id ][ $this->ItemNamer ]))
            {
                $name=$this->ItemHashes[ $id ][ $this->ItemNamer ];
            }
            if (!empty($this->ItemHashes[ $id ][ "Name" ]))
            {
                $name=$this->ItemHashes[ $id ][ "Name" ];
            }

            $this->PageFirstNames[ $id ]=$name;
        }

        $this->SetNItemsPerPage();
        $this->SetNPages();
        $this->SetPageNo();
        $this->PageNo2ItemNos();
    }

    //*
    //* function , Parameter list: 
    //*
    //* Updates $this->NItemsPerPage.
    //*

    function SetNItemsPerPage()
    {
        $val=$this->GetCGIVarValue($this->ModuleName."_NItemsPerPage");;
        if (!empty($val) && preg_match('/^\d+$/',$val))
        {
            $this->NItemsPerPage=$val;
        }
    }

    //*
    //* function , Parameter list: 
    //*
    //* Updates $this->NPages.
    //*

    function SetNPages()
    {
        if ($this->NumberOfItems>$this->NItemsPerPage)
        {
            $this->NPages=intval($this->NumberOfItems/$this->NItemsPerPage);
            $res=$this->NumberOfItems % $this->NItemsPerPage;
            if ($res>0) { $this->NPages++; }
        }
        elseif ($this->NumberOfItems>0)
        {
            $this->NPages=1;
        }
        else
        {
            $this->NPages=0;
        }
    }

    //*
    //* function GetPageNo, Parameter list: 
    //*
    //* Returns value of pageno, as from CGI.
    //*

    function GetPageNo()
    {
        $this->PageNo=$this->GetPOST($this->ModuleName."_Page");
        if (empty($this->PageNo))
        {
            $this->PageNo=$this->GetGETOrPOST("Page");
        }

        if (empty($this->PageNo)) { $this->PageNo=1; }

        return $this->PageNo;
    }


    //*
    //* function SetPageNo, Parameter list: 
    //*
    //* Updates $this->PageNo.
    //*

    function SetPageNo()
    {
        //$this->PageNo=$this->PresetPage;
        if (empty($this->PageNo))
        {
            $this->PageNo=$this->GetPOST($this->ModuleName."_Page");
            if (empty($this->PageNo))
            {
                $this->PageNo=$this->GetGETOrPOST("Page");
            }
        }

        if (empty($this->PageNo) || $this->PageNo>$this->NPages) { $this->PageNo=1; }
    }


    //*
    //* function PageNo2ItemNos, Parameter list: 
    //*
    //* Updates $this->FirstItemNo, $this->LastItemNo and $this->OffSet.
    //*

    function PageNo2ItemNos()
    {
        if ($this->NumberOfItems>$this->NItemsPerPage)
        {
            if ($this->ActiveID && $this->ActiveID>0)
            {
                $this->FirstItemNo=0;
                foreach ($items as $id => $item)
                {
                    if ($item[ "ID" ]==$this->ActiveID)
                    {
                        $this->FirstItemNo=$id;
                        $this->OffSet=$this->NumberOfItems;
                    }
                }
            }
            else
            {
                if ($this->PageNo==0)
                {
                    $this->FirstItemNo=0;
                    $this->OffSet=$this->NumberOfItems;
                }
                elseif (preg_match('/\d+/',$this->PageNo) && $this->PageNo>0)
                {
                    $res=$this->NItemsPerPage % $this->NumberOfItems;

                    $this->FirstItemNo=($this->PageNo-1)*$this->NItemsPerPage;
                    $this->OffSet=$res;
                }
                else
                {
                    $this->FirstItemNo=0;
                    $this->OffSet=0;
                }
            }
        }
        else
        {
            $this->FirstItemNo=0;
            $this->OffSet=$this->NumberOfItems;
        }

        $this->LastItemNo=$this->FirstItemNo+$this->OffSet;

        //return array($this->FirstItemNo,$this->OffSet);
     }



    //*
    //* function PagingFormPagingRow, Parameter list: 
    //*
    //* Creates the Search Form Pagin Row.
    //* Includes field for user to input desired pageno.
    //*

    function PagingFormPagingRow()
    {
        $nopagingfield=$this->ModuleName."_NoPaging";

        $pagingvalue=0;
        if ($this->GetGETOrPOST($nopagingfield)==1) { $pagingvalue=1; }

        $nitemspp=$this->GetGETOrPOST($this->ModuleName."_NItemsPerPage");
        if ($this->IntIsDefined($nitemspp)) { $this->NItemsPerPage=$nitemspp; }

        
        $nameacc="ItemsName".$this->MyLanguage_GetLanguageKey();

        return array
        (
           array
           (
              $this->B
              (
                 $this->GetMessage($this->SearchDataMessages,"PagingTitle").":"
              ),
              $this->MakeInput
              (
                 $this->ModuleName."_NItemsPerPage",
                 $this->NItemsPerPage,
                 2
              ).
              $this->$nameacc." ".
              $this->GetMessage($this->PagingMessages,"PerPage"),
              $this->B($this->GetMessage($this->PagingMessages,"Page").": ").
              $this->MakeInput($this->ModuleName."_Page",$this->GetPageNo(),2),
              $this->B($this->GetMessage($this->PagingMessages,"NoPaging").": ").
              $this->MakeCheckBox($nopagingfield,1,$pagingvalue),
           )
        );
    }


    //*
    //* function PagingFirstPages, Parameter list: 
    //*
    //* Returns hash with keys being the pagenos in the firsts secion.
    //*

    function PagingFirstPages()
    {
        if ($this->NPages==0) { return array("Nenhum(a) ".$this->ItemName." Selecionado"); }

        $first=1;
        $last=$this->NPagesInMenu;
        if ($first<$this->PageNo && $this->PageNo<=$last) { $last+=$this->NPagesInMenu/2; }

        $last=$this->Min($last,$this->NPages);

        $pages=array();
        for ($n=$first;$n<=$last;$n++)
        {
            $pages[ $n ]=1;
        }


        return $pages;
    }

    //*
    //* function PagingActivePages, Parameter list: &$pages
    //*
    //* Adds pages surrounding the active page to $pages.
    //*

    function PagingActivePages(&$pages)
    {
        if ($this->NPages<=$this->NPagesInMenu) { return; }

        $nps=$this->NPagesInMenu/2;

        for ($n=$this->PageNo-$nps;$n<$this->PageNo;$n++)
        {
            $pages[ $n ]=1;
        }

        $pages[ $this->PageNo ]=1;

        $max=$this->Min($this->PageNo+$nps,$this->NPages);
        for ($n=$this->PageNo+1;$n<=$max;$n++)
        {
            $pages[ $n ]=1;
        }

        for ($n=$this->NIntermediatePages;$n<=$this->NPages;$n+=$this->NIntermediatePages)
        {
            $pages[ $n ]=1;
        }
    }

    //*
    //* function PagingLastPages, Parameter list: &$pages
    //*
    //* Adds last pages to $pages.
    //*

    function PagingLastPages(&$pages)
    {
        if ($this->NPages<=$this->NPagesInMenu) { return; }

        $first=$this->NPages-$this->NPagesInMenu+1;
        $last=$this->NPages;
        if ($first<$this->PageNo && $this->PageNo<=$last) { $first+=$this->NPagesInMenu/2; }

        $first=$this->Min($first,$this->NPages-$this->NPagesInMenu+1);


        for ($n=$first;$n<=$last;$n++)
        {
            $pages[ $n ]=1;
        }
    }


    //*
    //* function PagingHorisontalMenu, Parameter list: $args=array()
    //*
    //* Creates paging horisontal menu of links.
    //*

    function PagingHorisontalMenu($args=array())
    {
        if ($this->NPages<=1) { return ""; }

        $pages=$this->PagingFirstPages();
        $this->PagingActivePages($pages);
        $this->PagingLastPages($pages);

        $pages=array_keys($pages);
        sort($pages,SORT_NUMERIC);

        $last=0;
        $rpages=array();
        $rpagetitles=array();
        
        foreach ($pages as $page)
        {
            if ($page<=0) { continue; }

            if ($page-$last>1)
            {
                array_push($rpages,"...");
                array_push($rpagetitles,"");
            }

            if ($page==$this->PageNo)
            {
                array_push($rpages,$page);
            }
            else
            {
                $extras="";
                foreach ($args as $key => $value)
                {
                    $extras.="&".$key."=".$value;
                }                

                $start=($page-1)*$this->NItemsPerPage+1;
                $end=$this->Min($page*$this->NItemsPerPage,$this->NumberOfItems);
                $name="";
                if (!empty($this->PageFirstNames[ $start-1 ])) { $name=$this->PageFirstNames[ $start-1 ]; }
                if (!empty($name)) { $name=": ".$name; }

                if ($this->CGI2IncludeAll()==2)
                {
                    $extras.="&".$this->CGI2IncludeAllKey()."=2";
                }

                array_push
                (
                   $rpages,
                   $this->Href
                   (
                      $this->PageURL.
                      $extras.
                      "&".$this->ModuleName."_NItemsPerPage=".
                      $this->GetGETOrPOST($this->ModuleName."_NItemsPerPage").
                      "&Page=".$page,
                      $page,
                      "Página ".$page.", ".$start."-".$end.$name,
                      $target="",
                      "ptablemenu"
                   )
                );
            }

            array_push($rpagetitles,"Página ".$page);

            $last=$page;
        }

        return 
            $this->HRefMenu
            (
               $this->NPages." Páginas: ",
               $rpages,
               array(),
               array(),
               count($rpages)
            );
    }
}
?>