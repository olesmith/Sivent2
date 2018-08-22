<?php


trait MyApp_Interface_Body_Top
{
    //*
    //* sub MyApp_Interface_Body_Top, Parameter list:
    //*
    //* Print Document Header row: Left, center and right cells.
    //*

    function MyApp_Interface_Body_Top_Row()
    {
        $noheads=$this->GetCookieOrGET("NoHeads");
        if ($noheads!=1)
        {
            return
                $this->Htmls_Comment_Section
                (
                    "BODY top row: Start",
                    $this->Htmls_Tag
                    (
                        "TR",
                        array
                        (
                            $this->MyApp_Interface_Body_Top_Left(),
                            $this->MyApp_Interface_Body_Top_Center(),
                            $this->MyApp_Interface_Body_Top_Right()
                        ),
                        array(
                            "CLASS" => "website-header-row"
                        )
                    )
                );
        }
        else
        {
            return array();
        }
    }


    //*
    //* sub MyApp_Interface_Body_Top_Left, Parameter list:
    //*
    //* return inteerface head left cell.
    //*

    function MyApp_Interface_Body_Top_Left()
    {
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    array($this->MyApp_Interface_Logo(1))
                ),
                array
                (
                    #"WIDTH" => '20%',
                    "CLASS" => 'applicationtop applicationleft',
                )
            );
    }


    //*
    //* sub MyApp_Interface_Body_Right, Parameter list:
    //*
    //* return inteerface head right cell.
    //*

    function MyApp_Interface_Body_Top_Right()
    {
        return
            $this->Htmls_Tag
            (
                "TD",
                array
                (
                    array($this->MyApp_Interface_Logo(2)),
                ),
                array
                (
                    #"WIDTH" => '10%',
                    "CLASS" => 'applicationtop applicationright',
                )
            );
    }

    //*
    //* sub MyApp_Interface_Body_Top_Center, Parameter list:
    //*
    //* return inteerface head center cell.
    //*

    function MyApp_Interface_Body_Top_Center()
    {
        $class='headtable';

        return
            $this->Htmls_Tag
            (
                "TD",
                $this->Htmls_Tag
                (
                    "HEADER",
                    array(array
                    (
                        $this->MyApp_Interface_Body_Top_Center_Titles()
                    ))
                ),
                array
                (
                    "CLASS" => $class,
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_Body_Top_Center_Titles, Parameter list:
    //*
    //* return inteerface head center cell.
    //*

    function MyApp_Interface_Body_Top_Center_Titles()
    {
        $class='headtable';
        $classes=$this->MyApp_Interface_Title_Classes();
        
        $classno=0;
        $titles=array();
        foreach ($this->MyApp_Interface_Titles() as $title)
        {
            if (!empty($title))
            {
                array_push
                (
                    $titles,
                    $this->DIV
                    (
                        $title,
                        array
                        (
                            "ALIGN" => 'center',
                            "CLASS" => $classes[ $classno ],
                        )
                    )
                );

                $classno++;
            }
        }

        return $titles;
    }
}

?>