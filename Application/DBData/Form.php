<?php


class DBDataForm extends DBDataUpdate
{
    //*
    //* function DBDataQuest, Parameter list: $event
    //*
    //* Displays example questionary form, when defining Quest data.
    //*

    function DBDataQuest()
    {
        return
            $this->ShowQuest().
            "";            
    }
    
    //*
    //* function DBDataForm, Parameter list: $event
    //*
    //* Displays event quest lists.
    //*

    function DBDataForm()
    {
        $this->ItemData();
        $this->ItemDataGroups();
        
        $this->InitActions();
        $this->SetPertains();

        return
            $this->ItemsForm_Run
            (
               array
               (
                  "FormTitle" => $this->DBDataFormTitle(),
                  "ID"         => 2,
                  "Name"       => "Datas",
                  "Method"     => "post",
                  "Action"     => 
                     "?Unit=".$this->GetCGIVarValue("Unit").
                     "&ModuleName=Events&Action=".
                     $this->CGI_Get("Action").
                     "&Event=".
                     $this->GetGET("Event")
                  ,

                  "Anchor"     => "TOP",
                  "Uploads" => FALSE,
                  "CGIGETVars" => array("Group","Datas","Datas_Sort","Datas_Reverse"),


                  "Edit"   => 1,
                  "Update" => 1,

                  "RowMethod"   => "",
                  "RowsMethod"   => "Table_Rows",
                  "RowMethod"   => "",
                  "RowsMethod"   => "ItemsForm_ItemRows",

                  "DefaultSorts" => array("SortOrder","ID"),
                  "ReadWhere" => array
                  (
                     "Event" => $this->Event("ID"),
                     "Pertains" => $this->ApplicationObj()->Pertains,
                  ),

                  "IgnoreGETVars" => array("CreateTable"),
                  "UpdateCGIVar" => "Update",
                  "UpdateCGIValue" => 1,
                  "UpdateItems"   => array(),


                  "Group" => $this->DBDataFormDataGroup(),

                  "Edit"   => 1,

                  "Items" => array(),
                  "AddGroup" => "Basic",
                  "AddItem" => array
                  (
                      "Unit" => $this->Unit("ID"),
                      "Event" => $this->Event("ID"),
                      "Pertains" => $this->ApplicationObj()->Pertains,
                  ),
                  "AddDatas" => array("Pertains","DataGroup","SqlKey","Type","SortOrder","Text","Text_UK"),
                  "UniqueDatas" => array("SqlKey"),
                  "NCols" => 20,
                  
                  "DetailsMethod"   => "DBDataFormDetailsCell",
                  "DetailsSGroups"   => "GetDetailsSGroups",
              )
            ).
            $this->DBDataQuest().
            "";
    }


    //*
    //* function DBDataFormTitle, Parameter list: 
    //*
    //* Returns form title.
    //*

    function DBDataFormTitle()
    {
        return
            $this->GetRealNameKey
            (
               $this->ApplicationObj()->PertainsSetup[ $this->ApplicationObj()->Pertains ],
               "Data_Form_Title"
            );
     }

    //*
    //* function DBDataFormDataGroup, Parameter list: 
    //*
    //* Returns Data Group for DBData Form.
    //*

    function DBDataFormDataGroup()
    {
       $groups=$this->GetPermittedDataGroups();

        $group=$this->CGI_GET("Group");
        if (empty($group))
        {
            $group=array_keys($groups);
            $group=array_shift($group);
        }

        if (empty($groups[ $group ])) { $group="Basic"; }

        return $group;
    }
}

?>