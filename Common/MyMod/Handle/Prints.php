<?php

trait MyMod_Handle_Prints
{
    var $BarDatas=array();
    
    //*
    //* function MyMod_Handle_Print_Init, Parameter list: &$item
    //*
    //* Initializes print item. May be overridden=, but should call this parent.
    //* 
    //*

    function MyMod_Handle_Print_Init(&$item)
    {
        if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); }

        foreach ($this->BarDatas as $data)
        {
            $file=$this->BarCode_File($item);
            if (!file_exists($file))
            {
                $this->BarCode_Generate($item);
            }
            
            $item[ $data."_File" ]=$file;
        }
        
    }
    
    //*
    //* function MyMod_Handle_Prints_Init, Parameter list: 
    //*
    //* Initializes print item.
    //*

    function MyMod_Handle_Prints_Init()
    {
        $this->BarDatas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->ItemData[ $data ][ "IsBarcode" ])
            {
                array_push($this->BarDatas,$data);
            }
        }
        
        foreach (array_keys($this->ItemHashes) as $id)
        {
            $this->MyMod_Handle_Print_Init($this->ItemHashes[$id]);
        }
    }
    
    //*
    //* function MyMod_Handle_Print, Parameter list: 
    //*
    //* Handles module one object Print.
    //*

    function MyMod_Handle_Print($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        $item=$this->TrimLatexItem($item);

        $latexdocno=$this->CGI2LatexDocNo();

        if (!empty($this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ]))
        {
            $handler=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ];
            $this->$handler();
            exit();
        }

        if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); }
        
        $this->MyMod_Item_Print($item);
    }
    
    //*
    //* function MyMod_Handle_Prints, Parameter list: 
    //*
    //* Handles module object Prints.
    //*

    function MyMod_Handle_Prints($where="")
    {
       $datas=array_keys($this->ItemData);

       $latexdocno=$this->CGI2LatexDocNo();
       $nempties=$this->GetPOST("NEmptyLines");


       $sort="";
       if (isset($this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "Sort" ]))
       {
           $sort=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "Sort" ];
       }

       if ($sort=="")
       {
           $this->MyMod_Sort_Detect();
       }
       else
       {
           $this->Sort=$sort;
       }

       $this->MyMod_Items_Read($where,$datas,FALSE,TRUE); //searching, but no paging

       $this->TrimLatexItems();

       if (count($this->ItemHashes)==0)
       {
           $this->ApplicationObj->MyApp_Interface_Head();
           echo 
               $this->H(4,"Nemhum item selecionado!").
               $this->H(4,"Volte, define alguma chave de pesquisa (ou marque 'Incluir Todos') e tente novamente.");
           exit();
       }

       $this->MyMod_Sort_Items();
       $this->MyMod_Handle_Prints_Init();

       if (!empty($this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ]))
       {
           $handler=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ];
           $this->$handler();
           exit();
       }

       $nmax=count(array_keys($this->ItemHashes) );

       $empty=array();
       foreach ($datas as $id => $data) { $empty[ $data ]=""; }
       for ($n=0;$n<$nempties;$n++)
       {
           $item=$empty;
           $item[ "No" ]=$nmax+$n+1;
           array_push($this->ItemHashes,$item);
       }

       $this->MyMod_Items_Print($this->ItemHashes);
    }
}

?>