<?php

trait MyMod_Handle_Search
{
    //*
    //* function MyMod_Handle_Search_Generate, Parameter list: 
    //*
    //* Handles module object Search.
    //*

   function MyMod_Handle_Search_Generate($where="",$searchvarstable=TRUE,$edit=0,$group="",$omitvars=array(),$action="",$module="",$savebuttonname="",$resetbottonname="")
  {
      $this->Singular=FALSE;
      $this->Plural=TRUE;

      if ($this->GetGETOrPOST("LatexDoc")>0)
      {
          $this->MyMod_Handle_Prints($where);
      }

      $output=$this->CGI_GETOrPOST("Output");
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
          $group=$this->MyMod_Data_Group_Actual_Get();
      }

      $datas=$this->MyMod_Data_Group_Datas_Get($group);
      if (!empty($group))
      {
          if (empty($where) && isset($this->ItemDataGroups[ $group ][ "SqlWhere" ]))
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

          
          if (!empty($this->ItemDataGroups[ $group ][ "NItemsPerPage" ]))
          {
              $this->NItemsPerPage=$this->ItemDataGroups[ $group ][ "NItemsPerPage" ];
              
          }
      }


      $print="";
      
      $this->MyMod_Sort_Detect($group);
      if ($output=="html")
      {
          if ($searchvarstable)
          {
              $print.= 
                  $this->MyMod_Search_Form($omitvars,"",$action,array(),array(),$module).
                  $this->BR();
          }
      }

      $hasitems=FALSE;
      if (count($this->ItemHashes)==0)
      {
          if ($where=="")
          {
              $this->MyMod_Items_Read("",$datas,$searchvarstable);
          }
          else
          {
              $this->MyMod_Items_Read($where,$datas,FALSE,FALSE);
          }
      }

      if (count($this->ItemHashes)>0) { $hasitems=TRUE; }

      $action=$this->MyActions_Detect();
      if ($this->MyMod_Search_CGI_Edit_Value()==2)
      {
          $edit=1;
      }

      if ($action=="EditList")
      {
          $edit=1;
      }

      $title="";
      if (!empty($this->Actions[ "ShowList" ]))
      {
          $title=$this->GetRealNameKey($this->Actions[ "ShowList" ]);
      }

      if ($edit==1)
      {
          $title=$this->GetRealNameKey($this->Actions[ "EditList" ]);
      }

      $table=array();
      if ($output=="html")
      {           
          $table=
              $this->MyMod_Data_Group_Table
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

      $searchvars=$this->MyMod_Search_Vars_Hash($datas);
      if ($this->MyMod_Search_Vars_Add_2_List)
      {
          $datas=$this->MyMod_Search_Vars_Add_2_List($datas);
      }

      
      if ($hasitems && $output=="html")
      {
          $print.= 
              $this->MyMod_Paging_Menu_Horisontal();

          if (!empty($this->ItemDataGroups[ $group ][ "Name" ]))
          {
              $print.= 
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
          $print.= 
              $this->Anchor("EditListForm").
              $this->StartForm
              (
                  "?ModuleName=".$this->GetGET("ModuleName")."&Action=".$this->MyActions_Detect(),
                  $method="post",$fileupload=FALSE,$options=array("Anchor" => "EditListForm")
              ).
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
              $print.=  $table;
          }
          else
          {
              $print.= 
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
          $print.= 
              $this->CGI_MakeHiddenFields(TRUE).//include tabmovesdown hidden var
              $this->ItemGroupHidden($group).
              $this->ItemEditListHidden($edit).
              $this->ItemPageHidden($edit).
              join("\n",$this->MyMod_Search_Hiddens_Fields()).
              $this->MakeHidden("Update",1).
              $this->MakeHidden("EditList",1).
              $this->MakeHidden("__MTime__",time()).
              $this->Buttons($savebuttonname,$resetbottonname).
              $this->EndForm();
      }

      return $print;
  } 
    //*
    //* function MyMod_Handle_Search, Parameter list: 
    //*
    //* Handles module object Search.
    //*

   function MyMod_Handle_Search($where="",$searchvarstable=TRUE,$edit=0,$group="",$omitvars=array(),$action="",$module="",$savebuttonname="",$resetbottonname="")
  {
      echo
          $this->MyMod_Handle_Search_Generate
          (
              $where,
              $searchvarstable,
              $edit,
              $group,
              $omitvars,
              $action,
              $module,
              $savebuttonname,
              $resetbottonname
          ).
          "";
  } 
}

?>