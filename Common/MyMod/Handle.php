<?php

include_once("Handle/Help.php");
include_once("Handle/Show.php");
include_once("Handle/Edit.php");
include_once("Handle/Copy.php");
include_once("Handle/Delete.php");
include_once("Handle/Search.php");
include_once("Handle/Prints.php");
include_once("Handle/Info.php");
include_once("Handle/Download.php");
include_once("Handle/Unlink.php");
include_once("Handle/Zip.php");
include_once("Handle/Export.php");

trait MyMod_Handle
{
    use MyMod_Handle_Help,
        MyMod_Handle_Show,
        MyMod_Handle_Edit,
        MyMod_Handle_Copy,
        MyMod_Handle_Delete,
        MyMod_Handle_Search,
        MyMod_Handle_Prints,
        MyMod_Handle_Info,
        MyMod_Handle_Zip,
        MyMod_Handle_Download,
        MyMod_Handle_Unlink,
        MyMod_Handle_Export;
    
    //*
    //* function MyMod_Handle_Item_Read, Parameter list:
    //*
    //* Read Item based on CGI, if CGI parms specified.
    //*

    function MyMod_Handle_Item_Read()
    {
        //Do we need to read an item?
        $id=0;
        if ($this->IDGETVar)
        {
            $id=$this->CGI_GETOrPOSTint($this->IDGETVar);
        }

        if (empty($id))
        {
            $id=$this->CGI_GETOrPOSTint("ID");
        }

        if (!empty($id))
        {
            if (empty($this->ItemHash))
            {
                $this->ReadItem($id);
            }

            if (empty($this->ItemHash))
            {
                $this->DoDie
                (
                   "Table::Handle ".$this->ModuleName.
                   ": Not found or not allowed... (".$id.") - bye-bye.."
                );
            }
        }
    }
    
    //*
    //* function MyMod_Handle, Parameter list: $args=array()
    //*
    //* The main handler. Everything passes through here!
    //* Dispatches an Application or a Module action. 
    //* If it's a global action, handle it here.
    //* Ex: Logon, logoff, change password, etc.
    //* For admin, the admin utilities (in left menu).
    //*

    function MyMod_Handle($args=array())
    {
        $action=$this->CGI_Get("Action");
        if ($action=="") { $action=$this->DefaultAction; }
        $this->ModuleName=$this->CGI_Get("ModuleName");

        //Load actions if necessary
        $this->Actions();
        $this->MyMod_Handle_Item_Read();
        
        if (!empty($this->Actions[ $action ]))
        {
            $item=array();
            if (!empty($this->Actions[ $action ][ "Singular" ]))
            {
                $item=$this->ItemHash;
            }
            
            $res=$this->MyAction_Allowed($action,$item);
            if (!$res)
            {
                if (!empty($this->Actions[ $action ][ "AltAction" ]))
                {
                    $action=$this->Actions[ $action ][ "AltAction" ];
                    $res=$this->MyAction_Allowed($action,$item);
                }
            }
            if ($res)
            {
                if (empty($this->Actions[ $action ][ "NoLogging" ]))
                {
                    $this->ApplicationObj()->LogMessage($action,"MyMod_Handle");
                }
                
                $this->Handle($action);
            }
            else
            {
                $this->DoDie("Action not allowed",$this->ModuleName,$action,$this->Actions[ $action ]);
            }
        }
        else
        {
            $this->DoDie("Action inexistent",$this->ModuleName,$action,$this->Actions);
        }
    }


    //*
    //* function Handle, Parameter list: $action=""
    //*
    //* ModuleHandler
    //*

    function Handle($action="")
    {
        if ($this->NoHandle!=0) { return; }

        $this->ItemData();
        $this->Actions();
        $this->ItemDataGroups();


        
        $item=$this->ItemHash;

        //Do we have a suitable action?
        if (empty($action))
        {
            $action=$this->MyActions_Detect();
        }
        
        if (empty($action))
        {
            $this->DoDie
            (
               "Table::Handle ".
                $this->ModuleName.
                ": Undefined action '$action' - redirect\n"
             );

            $this->Redirect();
            $this->DoExit();
        }

        $res=$this->MyAction_Allowed($action);
        if (!$res)
        {
            $this->Redirect();
            $this->DoExit();
        }

        $handler=$this->Actions[ $action ][ "Handler" ];
        if ($handler=="")
        {
            $handler="Handle".$action;
        }

        if (!empty($this->Actions[ $action ][ "Singular" ])) { $this->Singular=TRUE; }

        if (!method_exists($this,$handler))
        {
            echo 
                $this->ModuleName.
                ": Undefined handler, action $action (".
                $this->Actions[ $action ][ "Handler" ].
                "), $handler\n";

            $this->Redirect();
            $this->DoExit();
        }

        $this->MyMod_Handle_DocHeads();

        $this->ItemHash=$item;
        if (method_exists($this,"PreHandle"))
        {
            $this->PreHandle();
        }

        //this->ApplicationObj->PrintHelpLink();
        $this->$handler();

        if (method_exists($this,"PostHandle"))
        {
            $this->PostHandle();
        }
    }

    
  function MyMod_Handle_DocHeads($force=FALSE)
  {
      $latex=0;
      $latex=$this->CGI_GETOrPOSTint("Latex");
      if ($latex>=1)
      {
          $this->ApplicationObj()->SetLatexMode();
          return;
      }

      $zip=0;
      $zip=$this->CGI_GETOrPOSTint("ZIP");

      if ($zip==1) { return; }

      $latexdoc=$this->CGI_GETOrPOSTint("LatexDoc");
      if (empty($latexdoc)) { $latexdoc=0; }
      if (empty($latexdoc)) { $latexdoc=0; }

      if ($latexdoc==0 || $force)
      {
          $action=$this->MyActions_Detect();
          if (
                empty($this->Actions[ $action ][ "NoHeads" ])
                ||
                $this->Actions[ $action ][ "NoHeads" ]!=1
                ||
                $force
             )
          {
              $this->ApplicationObj()->MyApp_Interface_Head();
          }

          if (
                !isset($this->Actions[ $action ][ "NoInterfaceMenu" ])
                ||
                $this->Actions[ $action ][ "NoInterfaceMenu" ]!=1
                ||
                $force
             )
          {
              if (empty($this->Actions[ $action ][ "NoInterfaceMenu" ]))
              {
                  $singular=FALSE;
                  if (isset($this->Actions[ $action ][ "Singular" ])) { $singular=!$this->Actions[ $action ][ "Singular" ]; }
                  $this->MyMod_HorMenu_Echo($singular);
                 
                  echo "<A NAME=\"TOP\"></A>\n";
              }
          }

      }
  }
}

?>