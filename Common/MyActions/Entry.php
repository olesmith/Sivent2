<?php

trait MyActions_Entry
{
    //*
    //* function MyActions_Entry, Parameter list: $data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array()
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry($data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$alt=FALSE,$icon="")
    {
        $size=20;
        if ($this->IconsPath=="")
        {
            $this->IconsPath=$this->FindIconsPath();
        }

        $action=$this->Actions($data);
        if
            (
                !empty($data)
                &&
                !empty($action)
                &&
                is_array($action)
            )
        {
            if ($this->MyAction_Allowed($data,$item))
            {
                return $this->MyActions_Entry_Gen($data,$item,$noicons,$class,$rargs,$noargs,$icon);
            }
            elseif (isset($this->Actions[ $data ][ "AltAction" ]))
            {
                $rdata=$this->Actions[ $data ][ "AltAction" ];
                if (!$alt)
                {
                    return $this->MyActions_Entry($rdata,$item,$noicons,$class,array(),array(),TRUE);
                }
            }
        }
        else
        {
            $this->AddMsg("Warning: Action $data undefined!");
        }

        return "";
    }


    //*
    //* function MyActions_Entry_OddEven, Parameter list: $even,$data,$item=array(),$noicons=0,$class="",$args=array(),$noargs=array()
    //*
    //* Calls MyActions_Entry above, but beforehand, swaps beteeen odd/even icons.
    //*

    function MyActions_Entry_OddEven($even,$data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array())
    {
        $this->Actions();

        $icon=$data;
        if (!empty($this->Actions[ $data ][ "Icon" ]))
        {
            $icon=$this->Actions[ $data ][ "Icon" ];
            if ($this->MyMod_Data_Image_Value_Is($icon))
            {
                if ($even)
                {
                    $icon=preg_replace('/light.png$/',"dark.png",$icon);
                }
                else
                {
                    $icon=preg_replace('/dark.png$/',"light.png",$icon);
                }
            }
            elseif (preg_match('/^(fa[srlb])/',$icon,$matches))
            {
                if ($even)
                {
                    if (!empty($this->Actions[ $data ][ "Icon_Even" ]))
                    {
                        $icon=$this->Actions[ $data ][ "Icon_Even" ];
                    }
                }
            }

            $icon=
                $this->MyActions_Entry
                (
                    $data,
                    $item,
                    $noicons,
                    $this->MyMod_EvenOdd_Class($even),
                    $rargs,
                    $noargs,
                    $alt=False,
                    $icon
                );
        }
        
        return $icon;
    }


    //*
    //* function MyActions_Entry_Anchor, Parameter list: $data
    //*
    //* Returns Anchor associated with action $data..
    //*

    function MyActions_Entry_Anchor($data)
    {
        return $this->Actions($data,"Anchor");
    }
    
    //*
    //* function MyActions_Entry_Gen, Parameter list: $data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$icon=""
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry_Gen($data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$icon="")
    {
        if (empty($this->Actions[ $data ][ "Name" ])) { return ""; }
        $action=$this->Htmls_HRef
        (
           $this->MyActions_Entry_URL($data,$item,$rargs,$noargs),
           $this->MyActions_Entry_Name($data,$noicons,$item,$icon),
           $this->MyActions_Entry_Title($data,$item),
           $class,

           $args=array
           (
               "Target" => $this->Actions[ $data ][ "Target" ],
               "Anchor" => $this->MyActions_Entry_Anchor($data),
           ),
           $options=array()
        );


        return $action;
    }


    //*
    //* function MyActions_Entry_Title, Parameter list: $data,$item=array()
    //*
    //* Generates only action title.
    //*

    function MyActions_Entry_Title($data,$item=array())
    {
        if (!empty($this->Actions[ $data ][ "TitleMethod" ]))
        {
            $method=$this->Actions[ $data ][ "TitleMethod" ];
            return $this->$method($data,$item);
        }
        
        return
            $this->Filter
            (
                $this->GetRealNameKey($this->Actions[ $data ],$this->ActionTitleKey),
                $item
            ); 
    }

    //*
    //* function MyActions_Entry_Name, Parameter list: $data,$noicons=0,$item=array(),$icon="",$class=""
    //*
    //* Generates only action name (content
    //*

    function MyActions_Entry_Name($data,$noicons=0,$item=array(),$icon="")
    {
        if (!empty($this->Actions[ $data ][ "NameMethod" ]))
        {
            $method=$this->Actions[ $data ][ "NameMethod" ];
            return $this->$method($data,$item);
        }

        return 
            $this->Filter
            (
                $this->MyActions_Entry_Icon($data,$noicons,$size=20,$icon),
                $item
            );
    }

    //*
    //* function MyActions_Entry_Alert, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array()
    //*
    //* Creates Aler'ed link: will raise confirming message, via java.
    //*

    function MyActions_Entry_Alert($url,$title)
    {
        return "javascript:goto('".$url."','".$title."')";
    }
    
    //*
    //* function MyActions_Entry_Icon, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array(),$icon=""
    //*
    //* Generates only action icon.
    //*

    function MyActions_Entry_Icon($data,$noicons=0,$size=20,$icon="")
    {
        if (empty($icon))
        {
            $icon=$this->Actions[ $data ][ "Icon" ];
        }

        if ($noicons==1 || empty($icon))
        {
            $icon=$this->GetRealNameKey($this->Actions[ $data ],$this->ActionNameKey); 
        }
        else
        {
            if ($this->MyMod_Data_Image_Value_Is($icon))
            {
                $icon=$this->ApplicationObj()->MyApp_Icon_IMG($icon,$size);
            }
            else
            {
                $icon=
                    $this->MyMod_Interface_Icon
                    (
                        $this->MyMod_Interface_Icon_Size($icon,2)
                    );
            }
        }

        return $icon;
    }
    
    //*
    //* function MyActions_Entry_URL, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array()
    //*
    //* Generates only action title.
    //*

    function MyActions_Entry_URL($data,$item=array(),$rargs=array(),$noargs=array())
    {
        if (!isset($this->Actions[ $data ][ "Name" ])) { return ""; }

        if (!empty($this->Actions[ $data ][ "URLMethod" ]))
        {
            $method=$this->Actions[ $data ][ "URLMethod" ];
            return $this->$method($data,$item);
        }
        
        $args=$this->CGI_URI2Hash("");
        $args=$this->CGI_Hidden2Hash($args);
        if (!empty($this->ModuleName))
        {
            $args[ "ModuleName" ]=$this->ModuleName();
        }
        $args[ "Action" ]=$data;

        unset($args[ "ID" ]);
        foreach (
                   array_merge
                   (
                      $noargs,
                      $this->NonPostVars,
                      $this->Actions[ $data ][ "NonPostVars" ],
                      $this->NonGetVars,
                      $this->Actions[ $data ][ "NonGetVars" ]
                   ) as $var
                )
        {
            if (isset($args[ $var ])) { unset($args[ $var ]); }
        }

        $var="";
        if (!empty($this->ModuleName)) $var=$this->IDGETVar;
        
        if (
              empty($this->Actions[ $data ][ "Singular" ])
              &&
              !empty($var)
              &&
              !empty($args[ $var ])
           )
        {
            unset($args[ $var ]);
        }


        foreach ($rargs as $key => $value) { $args[ $key ]=$value; }

        if (!empty($this->Actions[ $data ][ "HrefArgs" ]))
        {
            $args=$this->CGI_URI2Hash($this->Actions[ $data ][ "HrefArgs" ],$args);
        }
        
        $id="";
        if (isset($item[ "ID" ])) { $id=$item[ "ID" ]; }
        else                      { $id=$this->CGI_GETOrPOSTint("ID"); }

        if (
              $this->Actions[ $data ][ "AddIDArg" ]
              &&
              $id!="" && $id>0
           )
        {
            $args[ "ID" ]=$id;
        }

        $href=$this->Actions[ $data ][ "Href" ];

        $action=
            $href."?".
            $this->CGI_Hash2Query($args);

        if ($id!="" && $id>0) { $action=preg_replace('/#ID/',$id,$action); }
        else                  { $action=preg_replace('/\&?ID=#ID/',"",$action); }

        foreach ($this->ActionArgVars as $var)
        {
            $action=preg_replace('/#'.$var.'/',$this->$var,$action);
        }

        if (!empty($this->IDGETVar))
        {
            $action=preg_replace('/\&?ID=/',"&".$this->IDGETVar."=",$action);
        }

        if (!empty($this->Actions[ $data ][ "Confirm" ]))
        {
            $title=$this->GetRealNameKey($this->Actions[ $data ],"ConfirmTitle");
            $action=$this->MyActions_Entry_Alert($action,$title);
        }

        return $this->Filter($action,$item);
    }

}

?>