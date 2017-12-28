<?php


class Certificates_Table extends Certificates_Friend
{
    //*
    //* function Certificate_Row, Parameter list: $n,$friend,$event,$cert,$datas=array()
    //*
    //* Creates Friend $event $cert row.
    //*

    function Certificate_Row($n,$friend,$event,$cert,$datas=array())
    {
        return
            $this->MyMod_Items_Table_Row
            (
                0,
                $n,
                $cert,
                $datas
            );
    }

    
    //*
    //* function Certificates_Table, Parameter list: $datas,$friend,$event,$certs,$datas=array()
    //*
    //* Creates Friend $event $cert table.
    //*

    function Certificates_Table($friend,$event,$certs,$datas=array())
    {
        if (empty($datas)) { $datas=$this->Certificates_Table_Datas(); }
        
        $n=1;
        
        $table=array();
        foreach ($certs as $cert)
        {
            if (!$this->Certificate_Verify($cert) ) { continue; }
        
            array_push
            (
                $table,
                $this->Certificate_Row($n++,$friend,$event,$cert,$datas)
            );
        }

        if (!empty($table))
        {
            array_unshift
            (
                $table,
                $this->H(3,$this->GetRealNameKey($event,"Name"))
            );
            array_push
            (
                $table,
                $this->Certificates_Table_SumRow($friend,$event,$certs)
            );
        }

        return $table;
    }
    
     //*
    //* function Certificates_Table_SumRow, Parameter list: $friend,$event,$certs,$datas=array()
    //*
    //* Creates Friend $event certificates table sumrow.
    //*

    function Certificates_Table_SumRow($friend,$event,$certs,$datas=array())
    {
        if (empty($datas)) { $datas=$this->Certificates_Table_Datas(); }
        
        $cht=0;
        foreach ($certs as $cert)
        {
            if (!$this->Certificate_Verify($cert) ) { continue; }
            
            if (!empty($cert[ "TimeLoad" ])) { $cht+=$cert[ "TimeLoad" ]; }
        }

        $pos=array_search("TimeLoad",$datas);
        $row=
            array
            (
                $this->MultiCell($this->ApplicationObj->Sigma,$pos,'r'),
                $this->B($cht),
                ""
            );

        return $row;
    }

    
   //*
    //* function Certificates_Table_Titles, Parameter list: $datas=array()
    //*
    //* Creates Friend certificates table title row.
    //*

    function Certificates_Table_Titles($datas=array())
    {
        if (empty($datas)) { $datas=$this->Certificates_Table_Datas(); }
        
        $titles=$this->MyMod_Data_Titles($datas);

        return $titles;
    }
    
    //*
    //* function Certificates_Table_Datas, Parameter list: 
    //*
    //* Returns list of data to show for Friend/Event certificates tablew..
    //*

    function Certificates_Table_Datas()
    {
        $datas=array("No","Generate","Generated","Mailed","Type","Name","TimeLoad","Code",);

        return $datas;
    }
        
}

?>