<?php


class HandleList extends HandleZip
{
  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleList($where="",$searchvarstable=TRUE,$edit=0,$group="",$omitvars=array(),$action="",$module="",$savebuttonname="",$resetbottonname="")
  {
      $this->Singular=FALSE;
      $this->Plural=TRUE;

      if ($this->GetGETOrPOST("LatexDoc")>0)
      {
          $this->HandlePrints($where);
      }

      $output=$this->GetGETOrPOST("Output");
      $outputs=array
      (
         "0" => "html",
         "1" => "pdf",
         "2" => "tex",
         "3" => "csv",
      );

      if ($output=="") { $output=0; }
      if (!isset($outputs[ $output ]))
      {
          echo "Invalid output: $output<BR>";
          exit();
      }

      $output=$outputs[ $output ];

      if (empty($group))
      {
          $group=$this->GetActualDataGroup();
      }

      $datas=$this->GetGroupDatas($group);
      if ($group!="")
      {
          if ($where=="" && isset($this->ItemDataGroups[ $group ][ "SqlWhere" ]))
          {
              $where=$this->ItemDataGroups[ $group ][ "SqlWhere" ];
          }

          if (
                isset($this->ItemDataGroups[ $group ][ "Edit" ])
                &&
                $this->ItemDataGroups[ $group ][ "Edit" ]
             )
          {
              $edit=1;
          }
      }

      $this->DetectSort($group);
      if ($output=="html")
      {
          if ($searchvarstable)
          {
              echo 
                  $this->SearchVarsTable($omitvars,"",$action,array(),array(),$module).
                  $this->BR();
          }
      }

      $hasitems=FALSE;
      if (count($this->ItemHashes)==0)
      {
          if ($where=="")
          {
              $this->ReadItems("",$datas,$searchvarstable);
          }
          else
          {
              $this->ReadItems($where,$datas,FALSE,FALSE);
          }
      }

      if (count($this->ItemHashes)>0) { $hasitems=TRUE; }

      $action=$this->MyActions_Detect();
      if ($this->CGI2Edit()==2)
      {
          $edit=1;
      }

      $title="";
      if (!empty($this->Actions[ "ShowList" ]))
      {
          $title=$this->GetRealNameKey($this->Actions[ "ShowList" ]);
      }

      if ($action=="EditList")
      {
          $edit=1;
      }

      if ($edit==1)
      {
          $title=$this->GetRealNameKey($this->Actions[ "EditList" ]);
      }

      $tdatas=$datas;
      if (isset($this->ItemDataGroups[ $group ][ "TitleData" ]))
      {
          $tdatas=$this->ItemDataGroups[ $group ][ "TitleData" ];
      }

      $table=array();
      if ($output=="html")
      {           
          $table=$this->ItemsTableDataGroup
          (
           $title,
           $edit,
           $group,
           array()
          );
      }
      elseif ($output=="pdf")
      {
          $table=$this->ItemsLatexTable();
      }
      elseif ($output=="tex")
      {
          $table=$this->ItemsLatexTable(TRUE);
      }
      elseif ($output=="csv")
      {
          $table=$this->ItemsCSVTable();
      }

      $searchvars=$this->GetDefinedSearchVars($datas);
      if ($this->AddSearchVarsToDataList)
      {
          $datas=$this->AddSearchVarsToDataList($datas);
      }

      if ($hasitems && $output=="html")
      {
          echo 
              $this->PagingHorisontalMenu();

          if (!empty($this->ItemDataGroups[ $group ][ "Name" ]))
          {
              echo
                  $this->H
                  (
                     3,
                     $this->FilterItemNames($this->GetMessage($this->ItemDataMessages,"PluralTableTitle")).": ".
                     $this->GetRealNameKey($this->ItemDataGroups[ $group ])
                   );
          }
      }

      if ($hasitems && $edit && $output=="html")
      {
          echo 
              $this->StartForm("?ModuleName=".$this->GetGET("ModuleName")."&Action=".$this->MyActions_Detect()).
              $this->MakeHidden("Update",1).
              $this->Buttons($savebuttonname,$resetbottonname);
      }
      
      if (empty($table)) { $table=array(); }

      

      if ($output=="html")
      {
          if (!empty($this->ItemDataGroups[ $group ][ "TitleGenMethod" ]))
          {
              $method=$this->ItemDataGroups[ $group ][ "TitleGenMethod" ];
              array_unshift($table,array($this->$method()));
          }

          if (!is_array($table))
          {
              echo $table;
          }
          else
          {
              echo
                  $this->Html_Table
                  (
                     "",
                     $table,
                     array("ALIGN" => 'center'),
                     array(),
                     array()
                  );
          }
      }


      if ($hasitems && $edit && $output=="html")
      {
          echo 
              $this->MakeHiddenFields(TRUE).//include tabmovesdown hidden var
              $this->ItemGroupHidden($group).
              $this->ItemEditListHidden($edit).
              $this->ItemPageHidden($edit).
              join("\n",$this->SearchVarsAsHiddens()).
              $this->MakeHidden("Update",1).
              $this->MakeHidden("EditList",1).
              $this->MakeHidden("__MTime__",time()).
              $this->Buttons($savebuttonname,$resetbottonname).
              $this->EndForm();
      }
  }
}

?>