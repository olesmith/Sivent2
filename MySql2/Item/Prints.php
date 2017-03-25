<?php


class ItemPrints extends ItemTable
{

    function PrintItem($item=array(),$printpdf=TRUE)
    {
        if  (count($item)==0) { $item=$this->ItemHash; }
        $this->ApplicationObj->LogMessage("PrintItem",$item[ "ID" ].": ".$this->MyMod_Item_Name_Get($item));
        $latexdocno=$this->CGI2LatexDocNo();

        $latex=
            $this->GetLatexHead("Singular",$latexdocno).
            $this->LatexItem($item).
            $this->GetLatexTail("Singular",$latexdocno);

        $latex=$this->TrimLatex($latex);
        $latex=$this->Filter($latex,$item);
        $latex=$this->FilterObject($latex);

        $texfilename="Item";
        if ($this->ItemName) { $texfilename=$this->ItemName; }
        $texfilename.=".".time().".tex";

        return $this->RunLatexPrint($texfilename,$latex,$printpdf);
    }



    function GetEmptyItem($datas=array())
    {
        if (count($datas)==0) { $datas=array_keys($this->ItemData); }

        $item=array();
        foreach ($datas as $id => $data)
        {
            $item[ $data ]="";
            if (isset($this->ItemData[ $data ][ "Default" ]))
            {
                $item[ $data ]=$this->ItemData[ $data ][ "Default" ];
            }
        }

        unset($item[ "ID" ]);
        return $item;
    }
}
?>