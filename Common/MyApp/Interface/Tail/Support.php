<?php

trait MyApp_Interface_Tail_Support
{
    //*
    //* function MyApp_Interface_Support_Info, Parameter list: 
    //*
    //* Initializes loggin, if no.
    //*

    function MyApp_Interface_Tail_Support_Info()
    {
        $supports=array();
        $this->MyApp_Setup_ConfigFiles($this->SetupPath,"Support.php",$supports);

        if (empty($supports)) { return ""; }

        $row=array();
        foreach ($supports as $id => $supportlist)
        {
            array_push
            (
               $row,
               $this->B
               (
                  $this->U
                  (
                     array_shift($supportlist) //First in $support is title
                  )
               )
            );

            foreach ($supportlist as $rid => $support)
            {
                array_push
                (
                   $row,
                   $this->A
                   (
                      $support[ "Href" ],
                      $this->Img
                      (
                         $support[ "SRC" ],
                         $support[ "ALT" ],0,0,
                         array
                         (
                            "BORDER" => 0,
                            "ALIGN" => 'middle',
                            "WIDTH" => "75px",
                         )
                      ),
                      array("TITLE" => $support[ "Title" ])
                   )
                );
            }

        }

        return 
            $this->Html_Table
            (
               "",
               array($row),
               array("ALIGN" => 'center'),
               array("CLASS" => 'colaboratortable'),
               array("CLASS" => 'colaboratortable')
            ).
            $this->Html_HR('75%').
            "";
    }

    //*
    //* sub MyApp_Interface_Tail_Support, Parameter list:
    //*
    //* Generates support info.
    //*
    //*

    function MyApp_Interface_Tail_Support()
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

        return $this->Html_Table
        (
           "",
           array
           (
              $this->Center
              (
                 "This system uses ".
                 $this->A('http://www.google.com/search?q=cookies',"Cookies").
                 ", please enable them in you browser!"
              ),
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
                   $color1,
                   $color2
                 ),
                 ""
              ),
           ),
           array("ALIGN" => 'center'),
           array("CLASS" => 'supporttable'),
           array("CLASS" => 'supporttable')
        );
    }


}

?>