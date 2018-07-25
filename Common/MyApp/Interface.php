<?php


include_once("Interface/Headers.php");
include_once("Interface/Head.php");
include_once("Interface/Body.php");
include_once("Interface/Doc.php");
include_once("Interface/Messages.php");
include_once("Interface/Titles.php");
include_once("Interface/Icons.php");
include_once("Interface/Logos.php");
include_once("Interface/LeftMenu.php");
include_once("Interface/CSS.php");


trait MyApp_Interface
{
    use
        MyApp_Interface_Headers,
        MyApp_Interface_Head,
        MyApp_Interface_Body,
        MyApp_Interface_Doc,
        MyApp_Interface_Messages,
        MyApp_Interface_Titles,
        MyApp_Interface_Icons,
        MyApp_Interface_Logos,
        MyApp_Interface_LeftMenu,
        MyApp_Interface_CSS;

    //*
    //* function AllowedProfiles, Parameter list: 
    //*
    //* .
    //*

    function AllowedProfiles()
    {
        return $this->AllowedProfiles;
    }

    
    //*
    //* function MyApp_Interface_Init, Parameter list: 
    //*
    //* Initializes applicatiion interface.
    //*

    function MyApp_Interface_Init()
    {
        if (empty($this->HtmlSetupHash[ "CharSet" ]))
        {
            $this->HtmlSetupHash[ "CharSet"  ]="utf-8";
        }
        if (empty($this->HtmlSetupHash[ "WindowTitle" ]))
        {
            $this->HtmlSetupHash[ "WindowTitle"  ]="Yes I am a Mother Nature Son...)";
        }
        if (empty($this->HtmlSetupHash[ "DocTitle" ]))
        {
            $this->HtmlSetupHash[ "DocTitle"  ]="Please give me a title (HtmlSetupHash->DocTitle)";
        }
        if (empty($this->HtmlSetupHash[ "Author" ]))
        {
            $this->HtmlSetupHash[ "Author"  ]="Prof. Dr. Ole Peter Smith, IME, UFG, ole'at'mat'dot'ufg'dot'br";
        }

        $this->ApplicationName=$this->HtmlSetupHash[ "ApplicationName"  ];
    }

    //*
    //* sub MyApp_Interface_Cookies_Message, Parameter list:
    //*
    //* Generates and sends the document tail part.
    //*
    //*

    function MyApp_Interface_Tail()
    {
        if ($this->DocHeadSend==1)
        {
            $this->Htmls_Indent_Inc(-$this->Body_Increment);
            echo
                $this->Htmls_Text
                (
                    array
                    (
                        $this->MyApp_Interface_Body_End_Comments(),                    

                        $this->Htmls_Comment_Section
                        (
                            "HTML TAIL section",
                            array_merge
                            (
                                $this->MyApp_Interface_Body_End(),
                                $this->Htmls_Tag_Close("HTML")
                            )
                        )
                    )
                );
        }
    }
    
    //*
    //* sub MyApp_Interface_Cookies_Message, Parameter list:
    //*
    //* Generates cookies info message.
    //*
    //*

    function MyApp_Interface_Cookies_Message()
    {
        return
            array
            (
                "This system uses",
                $this->A('http://www.google.com/search?q=cookies',"Cookies,"),
                "please enable them in you browser!",
            );
    }
    //*
    //* sub MyApp_Interface_Support, Parameter list:
    //*
    //* Generates support info.
    //*
    //*

    function MyApp_Interface_Support()
    {
        $authorlinks=$this->HtmlSetupHash[ "AuthorLinks"  ];
        $authorlinknames=$this->HtmlSetupHash[ "AuthorLinkNames"  ];

        $links=array();
        for ($n=0;$n<count($authorlinks);$n++)
        {
            $name=$authorlinks[$n];
            if (!empty($authorlinknames[$n])) { $name=$authorlinknames[$n]; }
            
            array_push
            (
               $links,$this->A
               (
                  $authorlinks[$n],
                  $name,
                  array
                  (
                     "Target" => "_ext",
                  )
                  
               )
            );
        }

        $color1=$this->ColorCode2Color($this->Layout[ "DarkGrey" ]);
        $color2=$this->ColorCode2Color($this->Layout[ "LightBlue" ]);

        return
            $this->Htmls_Tag
            (
                "CENTER",
                array
                (
                    $this->Htmls_Table
                    (
                        "",
                        array
                        (
                            array
                            (
                                $this->U($this->B("Author:")),
                                $this->HtmlSetupHash[ "Author"  ],
                                join(" - ",$links)
                            ),
                            array
                            (
                                $this->U($this->B("Support:")),
                                $this->IconText
                                (
                                    $this->HtmlSetupHash[ "SupportEmail" ].".png",
                                    $this->HtmlSetupHash[ "SupportEmail" ],
                                    $this->ColorCode2Color($this->Layout[ "DarkGrey" ]),
                                    $this->ColorCode2Color($this->Layout[ "LightBlue" ])
                                ),
                                ""
                            ),
                        ),
                        array("CLASS" => 'supporttable')
                    ),
                )
            );
    }
    
    //*
    //* function MyApp_Interface_ThanksTable, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Thanks()
    {
        $table=$this->MyApp_Setup_Files2Hash
        (
           array("../Application/System/","../MySql2/System/","System/"),
           array("Thanks.php")
        );

        foreach (array_keys($table) as $tid)
        {
            if
                (
                    !empty($table[ $tid ][2])
                    &&
                    !preg_match('/<A/',$table[ $tid ][2])
                )
            {
                $table[ $tid ][2]=
                    $this->A
                    (
                        $table[ $tid ][2],
                        $table[ $tid ][2],
                        array("TARGET" => '_blank')
                    );
            }
        }

        return
            array
            (
                $this->Htmls_DIV
                (
                    "Collaborators (alfabetical order):",
                    array("CLASS" => 'collaboratorstitle')
                ),
                $this->BR(),
                $this->Htmls_Tag
                (
                    "CENTER",
                    array
                    (
                        $this->Htmls_Table
                        (
                            "",
                            $table,
                            array("CLASS" => 'collaboratorstable'),
                            array(),array(),
                            True,True
                        )
                    )
                )
            );
     }

    
    //*
    //* function MyApp_Interface_Phrase, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Phrase()
    {
        return
            $this->Htmls_DIV
            (
                $this->IMG
                (
                    "icons/kierkegaard.png",
                    "Life sure is a Mystery to be Lived, ".
                    "Not a Problem to be Solved",
                    100,400
                ),
                array("ALIGN" => 'center')
            );
    }

    //*
    //* function MyApp_Interface_Sponsors, Parameter list: 
    //*
    //* Generates sponsors as to in setup path Sponsors.php, if existent.
    //*

    function MyApp_Interface_Sponsors()
    {
        $file=$this->SetupPath."/"."Sponsors.php";

        $table=array();
        if (file_exists($file))
        {
            $sponsors=$this->ReadPHPArray($file);
            foreach ($sponsors as $sponsor)
            {
                $link=
                    $this->Href
                       (
                          $sponsor[ "URL" ],
                          $this->IMG
                          (
                             "icons/".$sponsor[ "Icon" ],
                             "Logo ".$sponsor[ "Name" ],
                             $sponsor[ "Height" ],
                             $sponsor[ "Width" ]
                          ),
                          $sponsor[ "Name" ].": ".$sponsor[ "URL" ]
                       );

                array_push
                (
                    $table,
                    array
                    (
                        $this->Htmls_Href
                        (
                            $sponsor[ "URL" ],
                            $this->IMG
                            (
                                "icons/".$sponsor[ "Icon" ],
                                "Logo ".$sponsor[ "Name" ],
                                $sponsor[ "Height" ],
                                $sponsor[ "Width" ]
                            ),
                            $sponsor[ "Name" ].": ".$sponsor[ "URL" ]
                        ),
                    )
                );
            }
        }

        return
            $this->Htmls_Table
            (
                "",
                $table,
                array("ALIGN" => 'center')
            );
    }
}

?>