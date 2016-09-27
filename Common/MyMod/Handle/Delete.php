<?php

trait MyMod_Handle_Delete
{
  //*
  //* function MyMod_Handle_Delete, Parameter list: 
  //*
  //* 
  //*

  function MyMod_Handle_Delete($echo=TRUE,$actionname="Delete",$formurl="?Action=Delete",$idvar="ID")
  {
      if ($this->MyAction_Allowed($actionname))
      {
          $title=$this->GetRealNameKey($this->Actions[ $actionname ]);
          $ptitle=$this->GetRealNameKey($this->Actions[ $actionname ],"PName");

          return $this->MyMod_Handle_Delete_Form($title,$ptitle,array(),$echo,$formurl,$idvar);
      }
      else { $this->DoDie("Deletar não permitido"); }
  }

  
    //*
    //* Creates form for deleting an item. If $_POST[ "Delete" ] is 1,
    //* calls Delete for actual deletion.
    //*

    function MyMod_Handle_Delete_Form($title,$deletedtitle,$item=array(),$echo=TRUE,$formurl="?Action=Delete",$idvar="ID")
    {
        if (! is_array($item) || count($item)==0) { $item=$this->ItemHash; }

        //$this->ApplicationObj->LogMessage("MyMod_Handle_Delete_Form",$item[ "ID" ].": ".$this->GetItemName($item));

        $uri=$_SERVER[ "HTTP_REFERER" ];
        if ($this->CGI_POSTint("Delete")==1)
        {
            $uri=$this->CGI_POST("Referer");
        }
        
        $hash=$this->CGI_URI2Hash($uri);
        //unset($hash[ "ID" ]);
        
        $returnuri="?".$this->CGI_Hash2URI($hash)."#HorMenu";
        
        $returnlink=$this->H
        (
            3,
            $this->A
            (
               $returnuri,
               $this->MyLanguage_GetMessage("DeleteReturnTitle")
            )
        );
        
        $html="";
        if ($this->CGI_POSTint("Delete")==1)
        {
            $this->Delete($item,$echo);
            $html=
                $this->HTMLTable
                (
                   "",
                   $this->ItemTable(0,$item)
                ).
                $this->H(2,$deletedtitle).
                $returnlink.
                "";      
        }
        else
        {
            $button=
                $this->Center
                (
                   $this->MakeButton
                   (
                      "submit",
                      ">>".
                      $this->MyLanguage_GetMessage("DeleteButtonTitle").
                      "<<"
                   )
                );
            
            $html.=
                $this->H(2,$title).
                $this->H
                (
                   3,
                   "Tem certeza que quer deletar '".$this->ItemName.": ".
                   $this->GetRealNameKey($item,$this->ItemNamer)."'?"
                ).
                $returnlink.
                $this->StartForm($formurl,"post",FALSE,array("Anchor" => "HorMenu")).
                $button.
                $this->HTMLTable
                (
                   "",
                   $this->ItemTable(0,$item)
                ).
                $this->MakeHidden($idvar,$item[ "ID" ]).
                $this->MakeHidden("Delete",1).
                $this->MakeHidden("Referer",$_SERVER[ "HTTP_REFERER" ]).
                $button.
                $this->EndForm().
                "";
        }

        if ($echo)
        {
            echo $html;
            return $item;
        }
        else
        {
            return $html;
        }
    }
}

?>