<?php


trait MyApp_Interface_LeftMenu_Generate
{
    //*
    //* function MyApp_Interface_LeftMenu_Generate, Parameter list:
    //*
    //* Generates (returns) the Left menu.
    //*

    function MyApp_Interface_LeftMenu_Generate()
    {
        $this->CompanyHash[ "Language" ]=$this->GetLanguage();
        $this->CompanyHash[ "Path" ]=$this->CGI_Script_Path();

        $html=array();
        foreach ($this->MyApp_Interface_LeftMenu_Read() as $submenuname => $submenu)
        {
            array_push
            (
                $html,
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu($submenu)
            );

        }
        
        return $this->Htmls_Tag("NAV",$html);
    }

    
    //*
    //* function MyApp_Interface_LeftMenu_SubMenu_Name, Parameter list: $submenu
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function MyApp_Interface_LeftMenu_SubMenu_Name($submenu)
    {
        $name=$this->GetRealNameKey($submenu,"Name");
        if (empty($name)) { $name=$this->GetRealNameKey($submenu,"Title"); }

        return $name;        
    }
    
    //*
    //* function MyApp_Interface_LeftMenu_Generate_SubMenu, Parameter list: $submenu
    //*
    //* Generates (returns) full submenu entry, incl. title.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu($submenu)
    {
        $html=array();
        if (is_array($submenu))
        {
            if ($this->MyMod_Access_HashAccess($submenu,1))
            {
                $menu=$this->MyApp_Interface_LeftMenu_Generate_SubMenu_List($submenu);
                if (empty($menu)) { return array(); }
           
                $html=array_merge
                (
                    $html,
                    $this->Htmls_DIV
                    (
                        $this->MyApp_Interface_LeftMenu_SubMenu_Name($submenu),
                        array("CLASS" => 'leftmenutitle')
                    )
                );
                
                $html=array_merge($html,$menu);
            }
        }
        else
        {
            array_push($html,$submenu);
        }

        return $html;
    }

    //*
    //* function MyApp_Interface_LeftMenu_Generate_SubMenu_Access_Has, Parameter list:
    //*
    //* Generates (returns) the Left menu list.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Access_Has($submenu,$menuid)
    {
        return
            is_array($submenu[ $menuid ])
            &&
            $this->MyMod_Access_HashAccess($submenu[ $menuid ],1);
    }
    
    //*
    //* function MyApp_Interface_LeftMenu_Generate_SubMenu_List, Parameter list:
    //*
    //* Generates (returns) the Left menu list.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_List($submenu,$item=array(),$postlist=array())
    {
        $list=array();
        if (isset($submenu[ "Method" ]))
        {
            $method=$submenu[ "Method" ];
            $list=$this->$method();
            if (!is_array($list)) { $list=array($list); }
        }
        else
        {
            $menuids=array_keys($submenu);
            sort($menuids);

            foreach ($menuids as $menuid)
            {
                if ($this->MyApp_Interface_LeftMenu_Generate_SubMenu_Access_Has($submenu,$menuid))
                { 
                    array_push
                    (
                        $list,
                        $this->MyApp_Interface_LeftMenu_Generate_SubMenu_Item
                        (
                            $submenu[ $menuid ],
                            $item
                        )
                    );
                }
            }
        }

        if (empty($list)) { return array(); }


        return
           $this->Htmls_List
            (
                array_merge($list,$postlist),
                array
                (
                    "CLASS" => 'leftmenulist',
                )
            );
    }

    //*
    //* function MyApp_Interface_LeftMenu_Generate_SubMenu_Item, Parameter list:
    //*
    //* Generates (returns) the Left menu list.
    //*

    function MyApp_Interface_LeftMenu_Generate_SubMenu_Item($submenuitem,$item=array())
    {

        $url="";
        if (!empty($submenuitem[ "Href" ])) { $url=$submenuitem[ "Href" ]; }

        if (!empty($url))
        {
            $anchor="HorMenu";
            if (isset($submenuitem[ "Anchor" ]))
            {
                $anchor=$submenuitem[ "Anchor" ];
            }
                    
            $noqueryargs=FALSE;
            if (isset($submenuitem[ "OmitArgs" ]))
            {
                $noqueryargs=$submenuitem[ "OmitArgs" ];
            }
                    
            if (isset($submenuitem[ "OmitArgs" ]))
            {
                foreach ($submenuitem[ "OmitArgs" ] as $arg)
                {
                    $url=preg_replace('/'.$arg.'=[^\&]*&?/',"",$url);
                }
            }

            $url=
                array
                (
                    $this->MyApp_Interface_LeftMenu_Bullet("+"),
                    $this->Htmls_HRef
                    (
                        $this->FilterHash($url,$item),
                        $this->GetRealNameKey($submenuitem,"Name"),
                        $this->GetRealNameKey($submenuitem,"Title"),
                        "leftmenulinks",
                        array
                        (
                            "Target" => $this->GetRealNameKey($submenuitem,"Target"),
                            "Anchor" => $anchor,
                        )
                    ),
                );
                    
        }
        else
        {
            $url=
                array
                (
                    $this->MyApp_Interface_LeftMenu_Bullet("*").
                    $this->Span
                    (
                        $this->GetRealNameKey($submenuitem,"Name"),
                        array
                        (
                            "TITLE" => $this->GetRealNameKey($submenuitem,"Title"),
                        )
                    ),
                );
        }

        return $url;
    }

    
    //*
    //* function MyApp_Interface_LeftMenu_Generate_Items_Menu, Parameter list: $obj,$menumethod,$items,$activeid,$href,$name,$title,$class="leftmenulinks",$add="+",$sub="-"
    //*
    //* Generates (returns) the Left menu.
    //*

    function MyApp_Interface_LeftMenu_Generate_Items_Menu($obj,$menumethod,$items,$activeid,$href,$name,$title,$class="leftmenulinks",$add="+",$sub="-")
    {
        $list=array();
        foreach ($items as $id => $item)
        {
            $text="";

            $item=$obj->MyMod_Data_Fields_Enums_ApplyAll($item);

            $rhref=$this->Href
            (
               $this->Filter($href,$item),
               $this->Filter($name,$item),
               $this->Filter($title,$item),
               "",
               $class
            );
                        
            if ($item[ "ID" ]==$activeid)
            {
                $text=
                    "&nbsp;".$sub."111 ".
                    $rhref.
                    ":".
                    $this->BR().
                    $this->$menumethod();
            }
            else
            {
                $text=
                    $add."222  ".
                    $rhref;
            }

            array_push($list,$text);
        }

        return $list;
    }
}

?>