<?php


class Import extends Sort
{

    //*
    //* Variables of Import class:
    //*

    var $ImportItems=array();
    var $ImportDatas=array();
    var $ImportRegexes=array();

    //*
    //* Tries to scan $this->GetPOST("Import_Text") according to format specification.
    //*

    function UpdateImport($datas)
    {
        $text=$this->GetPOST("Import_Text");
        $nfields=$this->GetPOST("NFields");

        $text=preg_split('/\n+/',$text);

        $this->ImportDatas=array();
        $this->ImportRegexes=array();
        for ($n=0;$n<$nfields;$n++)
        {
            $this->ImportDatas[$n]=$this->GetPOST("Comp_".$n);
            $this->ImportRegexes[$n]=$this->GetPOST("Sep_".$n);
        }

        $this->ImportItems=array();
        foreach ($text as $line)
        {
            if (!preg_match('/\S/',$line)) { continue; }
            $line=preg_replace('/^\s+/',"",$line)."\n";

            $item=array();
            for ($n=0;$n<$nfields;$n++)
            {
                $data=$this->ImportDatas[$n];
                $regex=$this->ImportRegexes[$n];

                //if ($regex=="") { $regex='\t'; }
                if ($regex!="")
                {
                    if (preg_match('/([^'.$regex.']*)'.$regex.'(.*)/',$line,$matches))
                    {
                        $value=$matches[1];
                        $line=$matches[2];

                        if ($data!="")
                        {
                            $item[ $data ]=$value;
                        }
                    }
                }
                elseif ($regex=="" && $data!="")
                {
                    $item[ $data ]=$line;
                }
            }

            if (count($item)>0)
            {
                array_push($this->ImportItems,$item);
            }
        }
    }

    //*
    //* Actually Adds Imported items, and print Show Table of these Items.
    //*

    function AddImported()
    {
        $datas=preg_grep('/\S/',$this->ImportDatas);
        array_unshift($datas,"No");
        $titles=$this->B($this->MyMod_Data_Titles($datas));

        $this->MyMod_Data_Add_Default_Init();

        $table=array($titles);
        foreach ($this->ImportItems as $n => $item)
        {
            $ritem=$item;
            foreach ($this->AddDefaults as $data => $value)
            {
                $ritem[ $data ]=$value;
            }

            array_push
            (
                $table,
                $this->MyMod_Group_Row_Item(0,$item,$n+1,$datas)
            );
        }

        print
            $this->H(2,"Itens Importados").
            $this->H(3,count($this->ImportItems)." ".$this->ItemsName).
            $this->HtmlTable("",$table).
            $this->MakeHidden("Import",1);
    }

    //*
    //* Shows Interpreted items as tables, ready to edit and save.
    //*

    function ImportItemsTable()
    {
        $datas=preg_grep('/\S/',$this->ImportDatas);
        array_unshift($datas,"No");
        $titles=$this->B($this->MyMod_Data_Titles($datas));

        $table=array($titles);
        foreach ($this->ImportItems as $n => $item)
        {
            $item[ "ID" ]=$n+1;
            array_push
            (
                $table,
                $this->MyMod_Group_Row_Item(1,$item,$n+1,$datas)
            );
        }

        print
            $this->H(2,"Resultado da Importação").
            $this->H(3,count($this->ImportItems)." ".$this->ItemsName).
            $this->StartForm().
            $this->Buttons().
            $this->HtmlTable("",$table).
            $this->MakeHidden("Import",1).
            $this->Buttons().
            $this->EndForm();
    }

    //*
    //* Fabricates the Import Form.
    //*

    function ImportForm()
    {
        $datas=array_keys($this->ItemData);
        $datas=preg_grep('/^ID$/',$datas,PREG_GREP_INVERT);
        $datas=preg_grep('/^[AMC]Time$/',$datas,PREG_GREP_INVERT);

        $rdatas=array();
        $nos=array();
        $n=1;
        foreach ($datas as $data)
        {
            if ($this->MyMod_Data_Access($data)==2)
            {
                array_push($rdatas,$data);
                array_push($nos,$n);
                $n++;
            }
        }

        $nfields=$this->GetPOST("NFields");
        if ($nfields=="")
        {
            $nfields=5;
        }
        $width=$this->GetPOST("Width");
        if ($width=="")
        {
            $width=100;
        }

        if ($nfields>count($nos))
        {
            $nfields=count($nos);
        }


        $rrdatas=array();
        foreach ($rdatas as $data)
        {
            array_push($rrdatas,$this->MyMod_Data_Title($data));
        }

        array_unshift($rrdatas,"");
        array_unshift($rdatas,"");

        if ($this->GetPOST("Process")==1)
        {
           $this->UpdateImport($datas);
        }

        $table=array
        (
           array
           (
              $this->B("No. de Campos"),
              $this->MakeSelectField("NFields",$nos,$nos,$nfields),
              $this->B("Largura do Campo Texto"),
              $this->MakeInput("Width",$width)
           ),
           array
           (
              $this->B("Iníciar"),
              $this->MakeInput("Start",$this->GetPOST("Start"),2)
           )
        );

        for ($n=0;$n<$nfields;$n++)
        {
            $value=$this->GetPOST("Comp_".$n);
            $row=array
            (
               $this->B("Componente #".$n),
               $this->MakeSelectField("Comp_".$n,$rdatas,$rrdatas,$value),
               $this->B("Separador #".$n),
               $this->MakeInput("Sep_".$n,$this->GetPOST("Sep_".$n),2)
            );

            array_push($table,$row);

            if ($value!="")
            {
                $rdatas=preg_grep('/^'.$value.'$/',$rdatas,PREG_GREP_INVERT);
            }

        }

        array_push($table,$this->Button("submit","Verificar"));

        print
            $this->H(4,"Em Construção - Defunct ainda!!").
            $this->H(2,"Importar ".$this->ItemsName).
            $this->H(3,"Formatação:").
            $this->StartForm().
            $this->HtmlTable("",$table).
            $this->H(3,"Colar texto aqui, um Item por linha:").
            $this->Center($this->MakeTextArea
            (
               "Import_Text",
               25,$width,
               $this->GetPOST("Import_Text"),
               "off"
            )).
            $this->MakeHidden("Process",1).
            $this->EndForm().
            "";

        if (count($this->ImportItems)>0)
        {
            $this->ImportItemsTable();
        }

        if ($this->GetPOST("Import")==1)
        {
           $this->UpdateImport($datas);
        }

    }

}


?>