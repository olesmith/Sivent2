<?php

class MyEventApp_Overrides extends MyEventApp_Access
{
   //*
    //* function Latex_PDF, Parameter list: $file,$latex
    //*
    //* Filters out Unit and Event and calls parent Latex_PDF.
    //*

    function Latex_PDF($file,$latex, $printpdf = true, $runbibtex = false, $copypdfto = false)
    {
        $latex=$this->FilterHash($latex,$this->Unit(),"Unit_");
        $latex=$this->FilterHash($latex,$this->Event(),"Event_");
        
        $latex=$this->TrimLatex($latex);
        
        return parent::Latex_PDF($file,$latex,$printpdf,$runbibtex,$copypdfto);
    }
    
    //*
    //* function MyApp_Interface_HEAD_Title, Parameter list: 
    //*
    //* Overrides title maker, including Unit title.
    //*

    function MyApp_Interface_HEAD_Title()
    {
        $comps=preg_split('/::/',parent::MyApp_Interface_HEAD_Title());
        $keys=array("Initials","Name","Title");
        
        $unit=$this->Unit();
        foreach ($keys as $key)
        {
            $name=$this->GetRealNameKey($unit,$key);
        
            if (!empty($name))
            {
                array_push($comps,$name);
                break;
            }
        }
        
        $event=$this->Event();
        foreach ($keys as $key)
        {
            $name=$this->GetRealNameKey($event,$key);
        
            if (!empty($name))
            {
                array_push($comps,$name);
                break;
            }
        }

        return join("::",array_reverse($comps));            
    }

    //*
    //* sub MyApp_Interface_Titles, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Titles()
    {
        $this->UnitsObj()->Sql_Table_Structure_Update();
        $unit=$this->Unit();
        if (empty($unit))
        {
            return $this->MyApp_Info();
        }

        $titles=array($this->MyApp_Name());

        $unit=$this->Unit();
        if (!empty($unit))
        {
            array_push($titles,$unit[ "Title" ]);

            $event=$this->Event();

             if (!empty($event))
            {
                $keys=array_keys($event);
                $keys=preg_grep('/Place/',$keys);
                array_push
                (
                    $titles,
                    $event[ "Title" ],
                    $this->Event_DateSpan($event),
                    $this->Event_Place($event)
                    
                );
            }
            else
            {
                
            }
        }

        return $titles;
    }
    

    //*
    //* sub MyApp_Interface_Logo_Get, Parameter list: $n
    //* 
    //* Returns left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Logo_Get($n)
    {
        $args=array();
        if ($n==2)
        {
            $logo=$this->Event("HtmlIcon2");
            if (!empty($logo))
            {
                $args=
                    array
                    (
                        "ModuleName" => "Events",
                        "Action" => "Download",
                        "Event" => $this->Event("ID"),
                        "Unit" => $this->Unit("ID"),
                        "Data" => "HtmlIcon2",
                    );
            }
        }

        if (empty($args))
        {
            $logo=$this->Unit("HtmlIcon".$n);
            if (!empty($logo))
            {
                $args=
                    array
                    (
                        "ModuleName" => "Units",
                        "Action" => "Download",
                        "Unit" => $this->Unit("ID"),
                        "Data" => "HtmlIcon".$n,
                    );
            }
        }

        if (!empty($args))
        {
            return "?".$this->CGI_Hash2URI($args);
        }

        //Still here, fall back to parent behaviour.
        return parent::MyApp_Interface_Logo_Get($n);
    }
    
    //*
    //* function MyApp_Interface_Sponsors, Parameter list: 
    //*
    //* Generates sponsors as to in setup path Sponsors.php, if existent.
    //*

    function MyApp_Interface_Sponsors()
    {
        if (method_exists($this,"SponsorsObj"))
        {
            return $this->SponsorsObj()->Sponsors_Table_Html();
        }

        return "";        
    }
    //*
    //* function MyApp_Common_URIs, Parameter list: $args
    //*
    //* The URI's to add for all links.
    //*

    function MyApp_Common_URIs()
    {
        $hash=
            array
            (
                "Unit" => $this->Unit("ID"),
                "Event" => $this->Event("ID"),
            );

        return $hash;
    }
}
?>
