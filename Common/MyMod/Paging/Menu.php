<?php



trait MyMod_Paging_Menu
{    
    //*
    //* function MyMod_Paging_Menu_Horisontal, Parameter list: $args=array()
    //*
    //* Creates paging horisontal menu of links.
    //*

    function MyMod_Paging_Menu_Horisontal($args=array())
    {
        if ($this->MyMod_Paging_N<=1) { return ""; }
        if (empty($args)) { $args=$this->CGI_URI2Hash(); }

        $pages=$this->MyMod_Paging_Menu_Pages_First();
        $this->MyMod_Paging_Menu_Pages_Active_Add($pages);
        #$this->MyMod_Paging_Menu_Pages_Active_Add($pages);

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
                #array_push($rpages,"...");
                #array_push($rpagetitles,"");
            }

            if ($page==$this->MyMod_Paging_No)
            {
                array_push($rpages,$page);
            }
            else
            {
                array_push
                (
                   $rpages,
                   $this->MyMod_Paging_Menu_Page_Item($args,$page)
                );
            }
            
            $last=$page;
        }

        return
            $this->Htmls_Comment_Section
            (
                "Module Horisontal Menus",
                $this->Htmls_DIV
                (
                    $this->Htmls_HRef_Menu
                    (
                        "Paging",
                        $this->MyMod_Paging_N." Páginas: ",
                        $rpages,
                        array()
                    ),
                    array
                    (
                        "CLASS" => 'center',
                        "ID" => 'PagingMenu',
                    )
                )
            );
    }
    
    //*
    //* function MyMod_Paging_Menu_Pages_First, Parameter list:
    //*
    //* Returns tthe first pages.
    //*

    function MyMod_Paging_Menu_Pages_First()
    {
        if ($this->MyMod_Paging_N==0) { return array("Nenhum(a) ".$this->ItemName." Selecionado"); }

        $first=1;
        $last=$this->MyMod_Paging_NPages_In_Menu;
        if ($first<$this->MyMod_Paging_No && $this->MyMod_Paging_No<=$last)
        {
            $last+=$this->MyMod_Paging_NPages_In_Menu/2;
        }

        $last=$this->Min($last,$this->MyMod_Paging_N);

        $pages=array();
        for ($n=$first;$n<=$last;$n++)
        {
            $pages[ $n ]=1;
        }

        return $pages;
    }
    
    //*
    //* function MyMod_Paging_Menu_Pages_Active, Parameter list: &$pages
    //*
    //* Adds pages surrounding the active page to $pages.
    //*

    function MyMod_Paging_Menu_Pages_Active_Add(&$pages)
    {
        if ($this->MyMod_Paging_N<=$this->MyMod_Paging_NPages_In_Menu) { return; }

        $nps=$this->MyMod_Paging_NPages_In_Menu/2;

        for
            (
                $n=$this->MyMod_Paging_No-$nps;
                $n<$this->MyMod_Paging_No;
                $n++
            )
        {
            $pages[ $n ]=1;
        }

        $pages[ $this->MyMod_Paging_No ]=1;

        $max=$this->Min($this->MyMod_Paging_No+$nps,$this->MyMod_Paging_N);
        for ($n=$this->MyMod_Paging_No+1;$n<=$max;$n++)
        {
            $pages[ $n ]=1;
        }

        for
            (
                $n=$this->MyMod_Paging_NPages_Intermediate;
                $n<=$this->MyMod_Paging_N;
                $n+=$this->MyMod_Paging_NPages_Intermediate
            )
        {
            $pages[ $n ]=1;
        }
    }
    
    //*
    //* function MyMod_Paging_Menu_Pages_Last, Parameter list: &$pages
    //*
    //* Adds last pages to $pages.
    //*

    function MyMod_Paging_Menu_Pages_Last_Add(&$pages)
    {
        if ($this->MyMod_Paging_N<=$this->MyMod_Paging_NPages_In_Menu) { return; }

        $first=$this->MyMod_Paging_N-$this->MyMod_Paging_NPages_In_Menu+1;
        $last=$this->MyMod_Paging_N;
        if
            (
                $first<$this->MyMod_Paging_No
                &&
                $this->MyMod_Paging_No<=$last
            )
        {
            $first+=$this->MyMod_Paging_NPages_In_Menu/2;
        }

        $first=
            $this->Min
            (
                $first,
                $this->MyMod_Paging_N-$this->MyMod_Paging_NPages_In_Menu+1
            );
        
        for ($n=$first;$n<=$last;$n++)
        {
            $pages[ $n ]=1;
        }
    }

    
    //*
    //* function MyMod_Paging_Menu_Page_Item, Parameter list: $args,$page
    //*
    //* Creates paging horisontal menu entry for $page.
    //*

    function MyMod_Paging_Menu_Page_Item($args,$page)
    {
        return
            $this->Htmls_HRef
            (
                $this->MyMod_Paging_Menu_Page_Item_URI($args,$page),
                      
                $page,
                $this->MyMod_Paging_Menu_Page_Item_Title($page),
                "",
                array
                (
                    "Anchor" => "PagingMenu",
                )
            );
    }

    //*
    //* function MyMod_Paging_Menu_Page_Item_Title, Parameter list: $page
    //*
    //* URI for $page link
    //*

    function MyMod_Paging_Menu_Page_Item_Title($page)
    {
        return
            "Página ".
            $page.
            ", ".
            $this->MyMod_Paging_Menu_Page_Item_Start($page).
            "-".
            $this->MyMod_Paging_Menu_Page_Item_End($page).
            $this->MyMod_Paging_Menu_Page_Item_Name($page);
    }
    
    //*
    //* function MyMod_Paging_Menu_Page_Item_Name, Parameter list: $page
    //*
    //* Name to display for $page.
    //*

    function MyMod_Paging_Menu_Page_Item_Name($page)
    {
        $start=$this->MyMod_Paging_Menu_Page_Item_Start($page);
        $name="";
        if (!empty($this->MyMod_Paging_First_Names[ $start-1 ]))
        {
            $name=$this->MyMod_Paging_First_Names[ $start-1 ];
        }
                
        if (!empty($name)) { $name=": ".$name; }

        return $name;
    }
    
    //*
    //* function MyMod_Paging_Menu_Page_Item_Start, Parameter list: $page
    //*
    //* First item on page.
    //*

    function MyMod_Paging_Menu_Page_Item_Start($page)
    {
        return ($page-1)*$this->NItemsPerPage+1;
    }
    
     //*
    //* function MyMod_Paging_Menu_Page_Item_End, Parameter list: $page
    //*
    //* Last item on page.
    //*

    function MyMod_Paging_Menu_Page_Item_End($page)
    {
        return
            $this->Min
            (
                $page*$this->NItemsPerPage,
                $this->NumberOfItems
            );
    }
    
    //*
    //* function MyMod_Paging_Menu_Page_Item_URI, Parameter list: $args,$page
    //*
    //* URI for $page link
    //*

    function MyMod_Paging_Menu_Page_Item_URI($args,$page)
    {
        return
            "?".
            $this->CGI_Hash2URI
            (
                $this->MyMod_Paging_Menu_Page_Item_Args($args,$page)
            );
    }
    
    //*
    //* function MyMod_Paging_Menu_Page_Item_Args, Parameter list: $args,$page
    //*
    //* Creates paging horisontal menu entry for $page.
    //*

    function MyMod_Paging_Menu_Page_Item_Args($args,$page)
    {
        if ($this->MyMod_Search_CGI_Include_All_Value()==2)
        {
            $args[ $this->MyMod_Search_CGI_Include_All_Name() ]=2;
        }

        $args[ $this->ModuleName."_NItemsPerPage" ]=
            $this->CGI_GETOrPOST($this->ModuleName."_NItemsPerPage");

        $args[ "Page" ]=$page;

        return $args;
    }
}

?>