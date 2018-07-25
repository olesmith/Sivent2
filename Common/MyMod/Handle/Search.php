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


      $print=array();
      
      $this->MyMod_Sort_Detect($group);
      if ($output=="html")
      {
          if ($searchvarstable)
          {
              array_push
              (
                  $print,
                  $this->Htmls_Text
                  (
                      $this->MyMod_Search_Form_List
                      (
                          array
                          (
                              "OmitVars" => $omitvars,
                              "Action" => $this->CGI_GET("Action"),
                              "Module" => $module,
                          )
                      )
                  )
              );
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
              $this->MyMod_Items_Read($where,$datas,FALSE,$this->NoPaging);
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
      
      $searchvars=$this->MyMod_Search_Vars_Hash($datas);
      if ($this->MyMod_Search_Vars_Add_2_List)
      {
          $datas=$this->MyMod_Search_Vars_Add_2_List($datas);
      }

      
      if ($hasitems && $output=="html")
      {
          array_push
          (
              $print,
              $this->MyMod_Paging_Menu_Horisontal()
          );

          if (!empty($this->ItemDataGroups[ $group ][ "Name" ]))
          {
              array_push
              (
                  $print,
                  $this->Htmls_H
                  (
                     2,
                     $this->FilterItemNames
                     (
                         $this->GetMessage($this->ItemDataMessages,"PluralTableTitle")
                     ).": ".
                     $this->GetRealNameKey($this->ItemDataGroups[ $group ])
                   )
              );
          }
      }
      
      
      $table=
          $this->MyMod_Handle_Search_Items_Table
          (
              $output,
              $edit,
              $this->MyMod_Handle_Search_Table_Title($edit),
              $group
          );
      
      if ($output!="html")
      {
          return $table;
      }

      if ($edit==1)
      {
          array_push($table,$this->Buttons($savebuttonname,$resetbottonname));
      }

      if ($hasitems)
      {
          array_push
          (
              $print,
              $this->Htmls_Form
              (
                  $edit,
                  "Search_Items",
                  "?ModuleName=".$this->GetGET("ModuleName")."&Action=".$this->MyActions_Detect(),
                  $this->Htmls_Table
                  (
                      "",
                      $table,
                      array(),
                      array(),
                      array(),
                      True,True
                  ),
                  $args=array
                  (
                      "Hiddens" => $this->MyMod_Handle_Search_Hiddens_Hash($edit),
                  ),
                  $options=array("ID" => "EditListForm")
              )
          );
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
          $this->Htmls_Text
          (
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
              )
          );
   } 
   //*
   //* function MyMod_Handle_Search_Items_Table, Parameter list: 
   //*
   //* Generates the paged item list table.
   //*

   function MyMod_Handle_Search_Items_Table($output,$edit,$title,$group)
   {
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

           if (!empty($this->ItemDataGroups[ $group ][ "TitleGenMethod" ]))
           {
               $method=$this->ItemDataGroups[ $group ][ "TitleGenMethod" ];
               array_unshift($table,array($this->$method()));
           }
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

       if (empty($table)) { $table=array(); }
       
       return $table;
    }   
    //*
    //* function MyMod_Handle_Search_Hiddens_Hash, Parameter list: 
    //*
    //* Returns hiddens to include in result table form.
    //*

   function MyMod_Handle_Search_Hiddens_Hash($edit)
   {
       return
           array_merge
           (
               array
               (
                   "Update"    => 1,
                   "EditList"  => $edit,
                   "__MTime__" => time(),
                   $this->GroupDataCGIVar() => $this->MyMod_Data_Group_Actual_Get(),
                   $this->GroupDataEditListVar() => $edit+1,
                   #$this->GroupDataPageVar() => $this->CGI_GETOrPOST($this->GroupDataPageVar()),
               ),
               $this->MyMod_Search_Hiddens_Hash(),
               $this->CGI_Hiddens_Hash()
           );
   }
   
   //*
   //* function MyMod_Handle_Search_Table_Title, Parameter list: $edit
   //*
   //* Returns search table title.
   //*

   function MyMod_Handle_Search_Table_Title($edit)
   {
      $title="";
      if (!empty($this->Actions[ "ShowList" ]))
      {
          $title=$this->GetRealNameKey($this->Actions[ "ShowList" ]);
      }

      if ($edit==1)
      {
          $title=$this->GetRealNameKey($this->Actions[ "EditList" ]);
      }

      return $title;
   }

}

?>