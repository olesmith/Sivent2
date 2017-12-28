<?php


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
    //* sub MyApp_Interface_Header_Send, Parameter list:
    //*
    //* Sends the HTML header .
    //*
    //*

    function MyApp_Interface_Header_HTTP()
    {
        if ($this->HeadersSend!=0) { return; }
        
        header('Content-type: text/html;charset='.$this->HtmlSetupHash[ "CharSet"  ]);
        $this->HTML=TRUE;

        $this->HeadersSend=1;  
    }
    
    //*
    //* sub MyApp_Interface_Comment, Parameter list:
    //*
    //* Sends 'before HTML tag' comment.
    //*
    //*

    function MyApp_Interface_Comment()
    {
        return
            '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
            "\n";
    }
    
    //*
    //* sub MyApp_Interface_Cookies, Parameter list:
    //*
    //* Returns before HTM tage comment.
    //*
    //*

    function MyApp_Interface_Cookies()
    {
        if ($this->Module)
        {
            $this->Module->AddSearchVars2Cookies();
            foreach ($this->Module->CookieVars as $cid => $cookievar)
            {
                array_push($this->CookieVars,$cookievar);
            }
        }
        
    }
    
    
    //*
    //* sub MyApp_Interface_, Parameter list:
    //*
    //* Returns interface header <TITLE>...</TITLE> section.
    //*
    //*

    function MyApp_Interface_Application_Title()
    {
        return
            $this->HtmlTags("TITLE",$this->ApplicationWindowTitle())."\n";
    }
    
    //*
    //* sub MyApp_Interface_, Parameter list:
    //*
    //* Returns interface header short cut icon entry.
    //*
    //*

    function MyApp_Interface_Application_ShortCut_Icon()
    {
        return 
            $this->HtmlTag
            (
               "LINK",
               "",
               array
               (
                  "REL"  => 'shortcut icon',
                  "HREF" => "icons/favicon.ico",
                  "TYPE" => "image/x-icon",
               )
            ).
            "\n".
            $this->HtmlTag
            (
               "LINK",
               "",
               array
               (
                  "REL"  => 'icon',
                  "HREF" => "icons/favicon.ico",
                  "TYPE" => "image/x-icon",
               )
            ).
            "\n";
    }
    
    //*
    //* sub MyApp_Interface_Application_METAs, Parameter list:
    //*
    //* Returns interface header META section
    //*
    //*

    function MyApp_Interface_Application_METAs()
    {
        return
            $this->HtmlTag
            (
               "META",
               "",
               array
               (
                  "HTTP-EQUIV" => 'Content-type',
                  "CONTENT"    => "text/html; charset=".$this->HtmlSetupHash[ "CharSet"  ],
               )
             ).
             "\n".
             $this->HtmlTag
             (
                "META",
                "",
                array
                (
                   "NAME"    => 'Autor',
                   "CONTENT" => $this->HtmlSetupHash[ "Author"  ],
                )
             ).
             "\n";
    }
    //*
    //* sub MyApp_Interface_Application_LINKs, Parameter list:
    //*
    //* Returns interface header LINKs.
    //*
    //*

    function MyApp_Interface_Application_LINKs()
    {
        return
            $this->HtmlTag
            (
               "META",
               "",
               array
               (
                  "HTTP-EQUIV" => 'Content-type',
                  "CONTENT"    => "text/html; charset=".$this->HtmlSetupHash[ "CharSet"  ],
               )
             ).
             "\n".
             $this->HtmlTag
             (
                "META",
                "",
                array
                (
                   "NAME"    => 'Autor',
                   "CONTENT" => $this->HtmlSetupHash[ "Author"  ],
                )
             ).
             "\n";
    }
    
    //*
    //* sub MyApp_Interface_Application_Styles, Parameter list:
    //*
    //* Returns interface header style section
    //*
    //*

    function MyApp_Interface_Application_Styles()
    {
        return
            $this->MyApp_Interface_Application_CSS_Generate().
            "\n";
    }
    
    //*
    //* sub MyApp_Interface_Application_Script, Parameter list:
    //*
    //* Returns interface header script section
    //*
    //*

    function MyApp_Interface_Application_Script()
    {
        return
            $this->HtmlTags
            (
               "SCRIPT",
               "",
               array
               (
                   "SRC" => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
               )
            )."\n\n".
            $this->HtmlTags
            (
               "SCRIPT",
               "function goto(site,title)\n".
               "{\n".
               "   var msg = confirm(title)\n".
               "   if (msg) {window.location.href = site}\n".
               "   else (null)\n".
               "}\n\n".
               
               
               "$(document).ready(function(){\n".
               "    $('#select_1').on('click',function(){\n".
               "        if(this.checked){\n".
               "            $('.checkbox_1').each(function(){\n".
               "                this.checked = true;\n".
               "            });\n".
               "        }else{\n".
               "             $('.checkbox_1').each(function(){\n".
               "                this.checked = false;\n".
               "            });\n".
               "        }\n".
               "    });\n".
               "    \n".
               
               "    $('.checkbox_1').on('click',function(){\n".
               "        if($('.checkbox_1:checked').length == $('.checkbox').length){\n".
               "            $('#select_1').prop('checked',true);\n".
               "        }else{\n".
               "            $('#select_1').prop('checked',false);\n".
               "        }\n".
               "    });\n".

               
               "    $('#select_2').on('click',function(){\n".
               "        if(this.checked){\n".
               "            $('.checkbox_2').each(function(){\n".
               "                this.checked = true;\n".
               "            });\n".
               "        }else{\n".
               "             $('.checkbox_2').each(function(){\n".
               "                this.checked = false;\n".
               "            });\n".
               "        }\n".
               "    });\n".
               "    \n".

               "    $('.checkbox_2').on('click',function(){\n".
               "        if($('.checkbox_2:checked').length == $('.checkbox').length){\n".
               "            $('#select_2').prop('checked',true);\n".
               "        }else{\n".
               "            $('#select_2').prop('checked',false);\n".
               "        }\n".
               "    });\n".

               
               "});\n".
               ""
            ).
            "\n";
    }
    
    
    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Header()
    {
        //Printed right away.
        $this->MyApp_Interface_Header_HTTP();
        
        $this->MyApp_Interface_Cookies();
        
        return
            $this->MyApp_Interface_Comment().
            "<HTML>\n".
            $this->HtmlTags
            (
               "HEAD",
               "\n".
               $this->MyApp_Interface_Application_CSS_LINKs().
               $this->MyApp_Interface_Application_Title().
               $this->MyApp_Interface_Application_ShortCut_Icon().
               $this->MyApp_Interface_Application_METAs().
               $this->MyApp_Interface_Application_Styles().
               $this->MyApp_Interface_Application_Script().
              "\n"
            ).
            $this->HtmlTag
            (
               "BODY",
               "",
               array
               (
                  " " => $this->HtmlSetupHash[ "BodyArgs"  ],
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