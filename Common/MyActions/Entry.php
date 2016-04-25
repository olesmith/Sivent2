<?php

//include_once("Actions/Defaults.php");

trait MyActions_Entry
{
    //*
    //* function MyActions_Entry, Parameter list: $data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array()
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry($data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array(),$alt=FALSE)
    {
        $size=20;
        if ($this->IconsPath=="")
        {
            $this->IconsPath=$this->FindIconsPath();
        }

        if (!empty($this->Actions[ $data ]) && is_array($this->Actions[ $data ]))
        {
            if ($this->MyAction_Allowed($data,$item))
            {
                return $this->MyActions_Entry_Gen($data,$item,$noicons,$class,$rargs,$noargs);
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
        if (!empty($this->Actions[ $data ][ "Icon" ]))
        {
            if ($even)
            {
                $this->Actions[ $data ][ "Icon" ]=
                    preg_replace
                    (
                       '/light.png$/',
                       "dark.png",
                       $this->Actions[ $data ][ "Icon" ]
                    );
            }
            else
            {
                $this->Actions[ $data ][ "Icon" ]=
                    preg_replace
                    (
                       '/dark.png/',
                       "light.png",
                       $this->Actions[ $data ][ "Icon" ]
                     );
            }
        }
        
        
        
        return $this->MyActions_Entry($data,$item,$noicons,$class,$rargs,$noargs);
    }


    //*
    //* function MyActions_Entry_Gen, Parameter list: $data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array()
    //*
    //* Creates Action Entry.
    //*

    function MyActions_Entry_Gen($data,$item=array(),$noicons=0,$class="",$rargs=array(),$noargs=array())
    {
        if (!isset($this->Actions[ $data ][ "Name" ])) { return ""; }

        $action=$this->Href
        (
           $this->MyActions_Entry_URL($data,$item,$rargs,$noargs),
           $this->MyActions_Entry_Name($data,$noicons,$item),
           $this->MyActions_Entry_Title($data,$item),
           $this->Actions[ $data ][ "Target" ],
           $class
        );

        $action=$this->Filter($action,$item);

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
        return $this->GetRealNameKey($this->Actions[ $data ],$this->ActionTitleKey); 
    }

    //*
    //* function MyActions_Entry_Name, Parameter list: $data,$noicons=0,$item=array()
    //*
    //* Generates only action name (content
    //*

    function MyActions_Entry_Name($data,$noicons=0,$item=array())
    {
        if (!empty($this->Actions[ $data ][ "NameMethod" ]))
        {
            $method=$this->Actions[ $data ][ "NameMethod" ];
            return $this->$method($data,$item);
        }
         $size=20;

         $text=$this->Actions[ $data ][ "Icon" ];

         if ($noicons==1 || $text=="")
         {
             $text=$this->GetRealNameKey($this->Actions[ $data ],$this->ActionNameKey); 
         }
         else
         {
             $text=$this->IMG
             (
                $this->Icons."/".$text,
                $text,
                $size,
                $size
             );
         }

         return $text;
    }


    //*
    //* function MyActions_Entry_URL, Parameter list: $data,$item=array(),$rargs=array(),$noargs=array()
    //*
    //* Generates only action title.
    //*

    function MyActions_Entry_URL($data,$item=array(),$rargs=array(),$noargs=array())
    {
        if (!isset($this->Actions[ $data ][ "Name" ])) { return ""; }

        $args=$this->CGI_URI2Hash("");
        $args=$this->Hidden2Hash($args);

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

        if (!empty($this->ModuleName))
        {
            $args[ "ModuleName" ]=$this->ModuleName();
        }
        $args[ "Action" ]=$data;

        foreach ($rargs as $key => $value) { $args[ $key ]=$value; }

        if ($this->Actions[ $data ][ "HrefArgs" ]!="")
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
        //if (empty($href)) { $href="index.php"; }


        $action=
            $href."?".
            $this->Hash2Query($args);

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

        return $action;
    }

}

?>