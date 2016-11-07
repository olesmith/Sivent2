<?php


trait MyApp_Interface_Doc_Head
{
    //*
    //* sub MyApp_Interface_Doc_Head, Parameter list:
    //*
    //* Prints leading interface html:
    //*
    //* Header row, with left, center and right cells.
    //* First middle cll, with Interface lleft (vertical) menu.
    //*
    //*

    function MyApp_Interface_Doc_Head()
    {
        if ($this->DocHeadSend!=0) { return; }

        $this->DocHeadSend=1;  
        $this->NoTail=0;

        return
            $this->MyApp_Interface_Doc_Head_Row().
            $this->HtmlTag
            (
               "TR",
               $this->HtmlTag
               (
                  "TD",
                  $this->MyApp_Interface_LeftMenu(),
                  array("CLASS" => 'leftmenu')
               )."\n".
               $this->HtmlTag
               (
                  "TD",
                  "",
                  array
                  (
                     "VALIGN" => 'top',
                     "CLASS" => 'ModuleCell',
                  )
               )
            ).
            $this->MyApp_Interface_Doc_Head_PreText().
            "";
   }


    //*
    //* sub MyApp_Interface_Doc_Head_PreText, Parameter list:
    //*
    //* Print prints some pretext, if defined.
    //*

    function MyApp_Interface_Doc_Head_PreText()
    {
        if ($this->Module && !empty($this->Module->PreTextMethod))
        {
            $method=$this->Module->PreTextMethod;
            if (method_exists($this->Module,$method))
            {
                return $this->Module->$method();
            }
            else
            {
                echo "No such Module 'PreTextMethod': ".$method."<BR>";
            }
        }
        elseif (!empty($this->PreTextMethod))
        {
            $method=$this->PreTextMethod;
            if (method_exists($this,$method))
            {
                return $this->$method();
            }
            else
            {
                return "No such Application 'PreTextMethod': ".$method."<BR>";
            }
        }
    }

    //*
    //* sub MyApp_Interface_Doc_Head_Row, Parameter list:
    //*
    //* Print Document Header row: Left, center and right cells.
    //*

    function MyApp_Interface_Doc_Head_Row()
    {
        $noheads=$this->GetCookieOrGET("NoHeads");
        if ($noheads!=1)
        {
            return
                $this->HtmlTag
                (
                   "TABLE",
                   "",
                   array
                   (
                      "WIDTH" => "100%",
                   )
                )."\n".
                $this->HtmlTags
                (
                   "TR",
                   $this->MyApp_Interface_Doc_Head_Left().
                   $this->MyApp_Interface_Doc_Head_Center().
                   $this->MyApp_Interface_Doc_Head_Right()
                 );
        }
        else
        {
            return $this->HtmlTag
            (
               "TABLE",
               "",
               array
               (
                  "WIDTH" => "100%",
                  "BORDER" => "1",
               )
            )."\n";
        }
    }


    //*
    //* sub MyApp_Interface_Doc_Head_Left, Parameter list:
    //*
    //* return inteerface head left cell.
    //*

    function MyApp_Interface_Doc_Head_Left()
    {
        return $this->HtmlTags
        (
           "TD",
           $this->MyApp_Interface_Icon(1),
           array("WIDTH" => '20%')
        ).
        "\n";
    }


    //*
    //* sub MyApp_Interface_Doc_Head_Right, Parameter list:
    //*
    //* return inteerface head right cell.
    //*

    function MyApp_Interface_Doc_Head_Right()
    {
        return $this->HtmlTags
        (
           "TD",
           $this->MyApp_Interface_Icon(2),
           array("WIDTH" => '10%')
        );
    }

    //*
    //* sub MyApp_Interface_Doc_Head_Center, Parameter list:
    //*
    //* return inteerface head center cell.
    //*

    function MyApp_Interface_Doc_Head_Center()
    {
        $classes=array("headinst","headdept","headaddress","headcity","headcontacts","headcontacts");
        $html="";
        $h=0;
        foreach ($this->MyApp_Interface_Titles() as $title)
        {
            if (!empty($title))
            {
                $html.=$this->DIV
                (
                   $title,
                   array("ALIGN" => 'center',"CLASS" => $classes[ $h ])
                 )."\n";

                $h++;
            }
        }

        return $this->HtmlTags("TD",$html,array("CLASS" => 'headtable'));
    }
}

?>