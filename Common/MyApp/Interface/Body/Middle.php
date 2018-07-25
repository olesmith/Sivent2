<?php


trait MyApp_Interface_Body_Middle
{
    //*
    //* sub MyApp_Interface_Body_Middle_Row_First, Parameter list:
    //*
    //* Generates Middle section leading part:
    //*
    //* Left menu cell, until central module cell TD.
    //*

    function MyApp_Interface_Body_Middle_Row_First()
    {
        return
            $this->Htmls_Comment_Section
            (
                "BODY middle row",
                $this->Htmls_Tag_Start
                (
                    "TR",
                    array
                    (
                        $this->Htmls_Tag
                        (
                            "TD",
                            $this->MyApp_Interface_LeftMenu(),
                            array
                            (
                                "CLASS" => 'leftmenu',
                            )
                        ),
                        
                        $this->Htmls_Tag_Start
                        (
                            "TD",
                            $this->MyApp_Interface_Body_PreText(),
                            array
                            (
                                "VALIGN" => 'top',
                                "CLASS" => 'ModuleCell',
                            )
                        ),
                    )
                )
            );
    }


    //*
    //* sub MyApp_Interface_Body_Middle_Row_Last, Parameter list:
    //*
    //* Generates Middle section leading part:
    //*
    //* Left menu cell, until central module cell TD.
    //*

    function MyApp_Interface_Body_Middle_Row_Last()
    {
        return
            array
            (
                $this->Htmls_Comment_Section
                (
                    "BODY middle row, latter part: Start",
                    array
                    (
                        $this->Htmls_Tag_Close("TD"),
                        $this->Htmls_Tag
                        (
                            "TD",
                            array
                            (
                                $this->Htmls_Tag
                                (
                                    "ASIDE",
                                    array
                                    (
                                        $this->MyApp_Interface_Sponsors(),
                                    )
                                ),
                            ),
                            array
                            (
                                "CLASS" => 'applicationright',
                            )
                        ),
                        $this->Html_Tag_Close("TR"),
                    )
                )
            );
    }
}

?>