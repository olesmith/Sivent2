<?php

//include_once("Tail/Thanks.php");


trait MyApp_Interface_Head
{
    //use MyApp_Interface_Head_Thanks;

    //*
    //* sub MyApp_Interface_Head, Parameter list:
    //*
    //* Prints leading interface html:
    //*
    //* Sends http header then prints application head part.
    //*
    //*

    function MyApp_Interface_Head()
    {
        echo
            $this->MyApp_Interface_Header().
            $this->MyApp_Interface_Doc_Head().
            "";

        if (method_exists($this,"HtmlDocHead"))
        {
            $this->HtmlDocHead();
        }
    }


    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Header()
    {
        if ($this->HeadersSend!=0)
        {
            //$this->AddMsg("Warning! Double header (not) send",2);
            return;
        }

        if ($this->Module)
        {
            $this->Module->AddSearchVars2Cookies();
            foreach ($this->Module->CookieVars as $cid => $cookievar)
            {
                array_push($this->CookieVars,$cookievar);
            }
        }


        $vars=array
        (
           "Profile" => $this->Profile,
        );

        if ($this->LoginType=="Admin") { $vars[ "Admin" ]=1; }

        header('Content-type: text/html;charset='.$this->HtmlSetupHash[ "CharSet"  ]);
        $this->HTML=TRUE;

        $this->HeadersSend=1;  

        return
            '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
            "<HTML>\n".
            $this->HtmlTags
            (
               "HEAD",
               $this->HtmlTags
               (
                  "TITLE",
                  $this->ApplicationWindowTitle()
               )."\n".
               "    ".
               $this->HtmlTag
               (
                  "LINK",
                  "",
                  array
                  (
                     "REL"  => 'shortcut icon',
                     "HREF" => $this->FindIconsPath()."/SAdE.owl.jpg",
                  )
               )."\n".
               "    ".
               $this->HtmlTag
               (
                  "META",
                  "",
                  array
                  (
                     "HTTP-EQUIV" => 'Content-type',
                     "CONTENT"    => "text/html; charset=".$this->HtmlSetupHash[ "CharSet"  ],
                  )
               )."\n".
               "    ".
               $this->HtmlTag
               (
                  "META",
                  "",
                  array
                  (
                     "NAME"    => 'Autor',
                     "CONTENT" => $this->HtmlSetupHash[ "Author"  ],
                  )
               )."\n".
               "    ".
               $this->HtmlTags
               (
                 "STYLE",
                 $this->ReadCSS(),
                 array("TYPE" => 'text/css')
               ).
               "\n"
            ).
            $this->HtmlTag
            (
               "BODY",
               "",
               array
               (
                  " " => $this->HtmlSetupHash[ "BodyArgs"  ],
                  /* "ONLOAD" => "setFocus()", */
               )
            )."\n".
            "    ".
            $this->HtmlTag
            (
               "DIV",
               "",
               array
               (
                  "ALIGN" => "center",
               )
            )."\n".
            "";   
    }

}

?>