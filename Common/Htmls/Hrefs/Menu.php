<?php


trait Htmls_Hrefs_Menu
{    
    //*
    //* function Htmls_HRef_Menu, Parameter list: $links,$titles
    //*
    //* Returns menu with HRefs (ie links), listed version.
    //* 
    //*

    function Htmls_HRef_Menu($id,$title,$links,$titles=array(),$args=array(),$btitles=array())
    {
        $nperline=8;
        if (!empty($args[ "NPerLine" ])) { $nperline=$args[ "NPerLine" ]; }
        
        $class="ptablemenu";
        if (!empty($args[ "Class" ])) { $class=$args[ "Class" ]; }
        
        $inactiveclass="inactivemenuitem";
        if (!empty($args[ "ClassInactive" ])) { $inactiveclass=$args[ "ClassInactive" ]; }
        
        $title="menutitle";
        if (!empty($args[ "Title" ])) { $titleclass=$args[ "Title" ]; }
        
        $current="";
        if (!empty($args[ "Current" ])) { $current=$args[ "Current" ]; }
        
        if (is_array($titles) && count($titles)>0)
        {
            $hrefs=
                $this->Htmls_HRef_List
                (
                    $links,
                    $titles,
                    $args=array
                    (
                        "Class" => $class,
                        "ClassInactive" => $inactiveclass,
                        "Current" => $current,
                    ),
                    $btitles
                );
        }
        else
        {
            $hrefs=$links;
        }

        $hhrefs=array();
        $rhrefs=array();
        for ($n=0;$n<count($hrefs);$n++)
        {
            if ($nperline>0 && ($n%$nperline)==($nperline-1))
            {
                $list=$rhrefs;
                array_push($list,$hrefs[$n]);
                array_push($hhrefs,$list);

                $rhrefs=array();
            }
            else
            {
                array_push($rhrefs,$hrefs[$n]);                
            }
        }

        if (count($rhrefs)>0)
        {
            array_push($hhrefs,$rhrefs);
        }

        ##$hhrefs is now list of lists, max nperline in each
        $html=array();

        foreach ($hhrefs as $hrid => $rhrefs)
        {
            $rhtml=array();
            array_push($html,"[");
            
            $first=True;
            foreach ($rhrefs as $rhref)
            {
                if (!$first)
                {
                    array_push($html,"|");
                }
                array_push($html,$rhref);
                $first=False;
            }

            #array_push($html,$rhtml);            
            array_push($html,"]");
        }

        return
            $this->Htmls_Tag
            (
                "CENTER",
                $html,
                array
                (
                    "ID" => $id,
                )
            );
    }
}
?>