<?php

trait Events_Config_Menu
{
    function Event_Config_Menu()
    {
        $args=$this->CGI_Query2Hash();
        unset($args[ $this->Event_Config_Group_CGI_Key ]);

        $cgroup=$this->Event_Config_Group_CGI_Value();
        
        $hrefs=array();
        foreach ($this->Event_Config_Groups_Get() as $group => $groupdefs)
        {
            $title=
                $this->GetRealNameKey
                (
                    $this->Event_Config_Group_Key($group,"Text")
                );

            if ($group!=$cgroup)
            {
                $args[ $this->Event_Config_Group_CGI_Key ]=$group;
                array_push
                (
                    $hrefs,
                    $href=
                    $this->Htmls_HRef
                    (
                        "?".$this->CGI_Hash2Query($args),
                        array
                        (
                            $this->GetRealNameKey
                            (
                                $this->Event_Config_Group_Key($group,"Title")
                            )
                        ),
                        $title="",
                        $class="",
                        array
                        (
                            "Anchor" => 'GROUP'
                        )
                    )
                );
            }
        }

        return
            $this->Htmls_Tag
            (
                "NAV",
                $this->Htmls_DIV
                (
                    $this->Event_Config_Menues_List($hrefs),
                    array("CLASS" => 'center')
                )
            );
    }
    function Event_Config_Menues_List($hrefs)
    {
        $menues=array();
        foreach ($this->MyHashes_Page($hrefs,6) as $id => $hrefs)
        {
            array_push
            (
                $menues,
                array
                (
                    "[ ",
                    $this->Htmls_Join(" | ",$hrefs),
                    " ]",
                    $this->BR(),
                )
            );
        }

        return $menues;
    }
}

?>