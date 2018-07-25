<?php


trait MyApp_Interface_Body_Bottom
{
    //*
    //* sub MyApp_Interface_Body_Bottom_Row, Parameter list:
    //*
    //* Generates Bottom section row.
    //*

    function MyApp_Interface_Body_Bottom_Row()
    {
        if ($this->NoTail>0) { return array(); }

        return
            array
            (
                array
                (
                    $this->MyApp_Interface_Post_Row(),
                    $this->Htmls_Comment_Section
                    (
                        "BODY bottom row",
                        $this->Htmls_Tag
                        (
                            "TR",
                            array
                            (
                                $this->MyApp_Interface_Body_Bottom_Left(),
                                $this->MyApp_Interface_Body_Bottom_Center(),
                                $this->MyApp_Interface_Body_Bottom_Right(),
                            )
                        )
                    ),
                    $this->Htmls_Tag_Close("TABLE"),
                ),
            );
    }
    
    //*
    //* sub MyApp_Interface_Body_Bottom_Left, Parameter list:
    //*
    //* Generates Bottom section left cell-.
    //*

    function MyApp_Interface_Body_Bottom_Left()
    {
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    $this->Img
                    (
                        $this->HtmlSetupHash[ "TailIcon_Left" ],
                        "Owl",
                        "100"
                    )
                ),
                array
                (
                    #"WIDTH" => '20%',
                    "CLASS" => 'applicationbottom applicationleft',
                )
            );
    }
    
    //*
    //* sub MyApp_Interface_Body_Bottom_Right, Parameter list:
    //*
    //* Generates Bottom section left cell-.
    //*

    function MyApp_Interface_Body_Bottom_Right()
    {
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    $this->Img
                    (
                        $this->HtmlSetupHash[ "TailIcon_Left" ],
                        "Owl",
                        "100"
                    )
                ),
                array
                (
                    #"WIDTH" => '20%',
                    "CLASS" => 'applicationbottom applicationright',
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_Body_Bottom_Center, Parameter list:
    //*
    //* Generates Bottom section center cell-.
    //*

    function MyApp_Interface_Body_Bottom_Center()
    {
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    $this->Htmls_Tag
                    (
                        "FOOTER",
                        array
                        (
                            array_merge
                            (
                                $this->Htmls_HR('100%'),
                                $this->MyApp_Interface_Cookies_Message(),
                                $this->Htmls_HR('75%'),
                                $this->MyApp_Interface_Support(),
                                $this->Htmls_HR('75%'),
                                $this->MyApp_Interface_Thanks(),
                                $this->Htmls_HR('75%'),
                                $this->MyApp_Interface_Phrase(),
                                $this->Htmls_HR('75%'),
                                $this->MyApp_Interface_Messages_System(),
                                $this->Htmls_HR('100%')
                            )
                        )
                    ),
                ),
                array
                (
                    "CLASS" => 'applicationbottom applicationcenter',
                )
            );
    }

    
}

?>