<?php


trait MyMod_Search_Options_Tabulator
{
    //*
    //* function MyMod_Search_Table_Tab_Moves_Down_Row, Parameter list: 
    //*
    //* Returns search table tabulator field moves down row.
    //*

    function MyMod_Search_Options_Tab_Moves_Down_Row()
    {
        $action=$this->CGI_GET("Action");
        $action=$this->Actions($action);

        $row=array();
        if (!empty($action[ "Edit" ]))
        {
            $row=
                array
                (
                    $this->B
                    (
                        $this->GetMessage($this->MyMod_Search_Messages,"TabMovesDown").":"
                    ),
                    $this->MultiCell
                    (
                        $this->MakeCheckBox
                        (
                            $this->ModuleName."_TabMovesDown",
                            1,
                            $this->CGI_VarValue($this->ModuleName."_TabMovesDown")
                        ).
                        " ".
                        $this->GetMessage($this->MyMod_Search_Messages,"TabMovesDownText"),
                        3,
                        'left'
                    )
                );
        }

        return $row;
    }
}

?>