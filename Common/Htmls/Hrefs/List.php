<?php


trait Htmls_Hrefs_List
{
    //*
    //* function Htmls_HRefs_List, Parameter list: $links,$titles,$args=array(),$btitles=array()
    //*
    //* HRefs a list of links.
    //* 
    //*

    function Htmls_HRefs_List($links,$titles,$args=array(),$btitles=array())
    {
        if (empty($btitles)) { $btitles=$titles; }
        
        $class="menuitem";
        if (!empty($args[ "Class" ])) { $class=$args[ "Class" ]; }
        
        $inactiveclass="menuinactive";
        if (!empty($args[ "ClassInactive" ])) { $inactiveclass=$args[ "ClassInactive" ]; }
                
        $current="";
        if (!empty($args[ "Current" ])) { $current=$args[ "Current" ]; }

        $rlinks=array();
        for ($n=0;$n<count($links);$n++)
        {
            if (! preg_match("/\S/",$titles[$n]) ) { $titles[$n]=$links[$n]; }
            $rlink=$titles[$n];
            if (!empty($links[$n]))
            {
                if ($current!=$titles[$n])
                {
                    $rlink=
                        $this->Htmls_HRef
                        (
                            $links[$n],
                            $titles[$n],
                            $btitles[$n],
                            $class
                        );
                }
                else
                {
                    $rlink=
                        $this->Htmls_SPAN
                        (
                            $btitles[$n],
                            array
                            (
                                "CLASS" => $inactiveclass,
                            )
                        );
                }
            }

            array_push($rlinks,$rlink);
        }

        return $rlinks;
    }
}
?>