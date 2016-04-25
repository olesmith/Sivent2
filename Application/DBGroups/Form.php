<?php


class DBGroupsForm extends DBGroupsAccess
{
    //*
    //* function SetPertains, Parameter list:
    //*
    //* Sets $this->Pertains.
    //*

    function SetPertains()
    {
        $action=$this->CGI_GET("Action");

        foreach ($this->ApplicationObj()->PertainsSetup as $pertains => $def)
        {
            $raction=$def[ "Group_Action" ];
            if (preg_match('/^'.$raction.'/',$action))
            {
                $this->ApplicationObj()->Pertains=$pertains;
                break;
            }
        }

        return $this->ApplicationObj()->Pertains;
    }

    //*
    //* function DBGroupsFormTitle, Parameter list: 
    //*
    //* Returns form title.
    //*

    function DBGroupsFormTitle()
    {
        return
            $this->GetRealNameKey
            (
               $this->ApplicationObj()->PertainsSetup[ $this->ApplicationObj()->Pertains ],
               "Groups_Form_Title"
            );
     }

    //*
    //* function DBDataFormDataGroup, Parameter list: 
    //*
    //* Returns form title.
    //*

    function DBDataFormDataGroup()
    {
        return $this->DatasObj()->DBDataFormDataGroup();
    }

    //*
    //* function DBGroupsDatasForm, Parameter list:
    //*
    //* Displays event data groups lists.
    //*

    function DBGroupsDatasForm()
    {
        $this->InscriptionsObj()->ItemData();
        
        $this->ItemData();
        $this->ItemDataGroups();
        
        $this->InitActions();
        $this->SetPertains();
 
        return
            $this->ItemsForm_Run
            (
               array
               (
                  "ID"         => 2,
                  "FormTitle" => $this->DBGroupsFormTitle(),
                  "Name"       => "GroupDatas",
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
                  "CGIGETVars" => array("Group","GroupDatas","GroupDatas_Sort","GroupDatas_Reverse"),


                  "Edit"   => 1,
                  "Update" => 1,

                  "DefaultSorts" => array("SortOrder","ID"),
                  "ReadWhere" => array
                  (
                     "Event" => $this->ApplicationObj->Event[ "ID" ],
                     "Pertains" => $this->ApplicationObj()->Pertains,
                  ),

                  "UpdateCGIVar" => "Update",
                  "UpdateCGIValue" => 1,
                  "UpdateItems"   => array(),


                  "Group" => $this->DBDataFormDataGroup(),

                  "Edit"   => 1,

                  "Items" => array(),
                  "AddGroup" => "Basic",
                  "AddItem" => array
                  (
                      "Unit" => $this->GetCGIVarValue("Unit"),
                      "Event" => $this->ApplicationObj->Event[ "ID" ],
                  ),

                  "AddDatas" => array
                  (
                      "Pertains","SortOrder","Text","Text_UK",
                      "Friend",
                      //SiPos? "Assessor",
                      "Singular","Plural"
                  ),
                  "UniqueDatas" => array(),

                  "DetailsSGroups"   =>  array
                  (
                     array
                     (
                        "Basic" => 1,
                     ),
                  )
               )
            ).
            "";
            
    }
    
}

?>