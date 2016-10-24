<?php


class PreInscriptionsInscriptionForm extends PreInscriptionsInscriptionUpdate
{
    //*
    //* function PreInscriptions_Inscription_Payment_Msg, Parameter list: $edit,$inscription,$datas=array()
    //*
    //* Shows $inscription preinscriptions form.
    //*

    function PreInscriptions_Inscription_Payment_Msg($inscription)
    {
        $paymentmsg="";
        
        $musthavepaid=$this->Event("PreInscriptions_MustHavePaid");
        if ($this->EventsObj()->Event_PreInscriptions_Paid_MustHave())
        {
            $havepaid=$inscription[ "Has_Paid" ];
            if (!$this->InscriptionsObj()->Inscription_Paid_Has($inscription))
            {
                $edit=0;
                $paymentmsg=
                    $this->Div
                    (
                        $this->Language_Message("PreInscriptions_NotPaid"),
                        array("CLASS" => 'errors')
                    );
            }
        }

        return $paymentmsg;
    }

    
    //*
    //* function PreInscriptions_Inscription_Form, Parameter list: $edit,$inscription,$datas=array()
    //*
    //* Shows $inscription preinscriptions form.
    //*

    function PreInscriptions_Inscription_Form($edit,$inscription,$datas=array())
    {
        if (empty($datas)) $datas=array("ID","Friend","Submission","Schedule");

        $paymentmsg=$this->PreInscriptions_Inscription_Payment_Msg($inscription);

        if (!empty($paymentmsg))
        {
            $edit=0;
        }
        
        $where=$this->UnitEventWhere(array("PreInscriptions" => 2));
        $this->SubmissionsObj()->ItemDataGroups("Basic");
        $this->SubmissionsObj()->ItemData("ID");
        $this->SubmissionsObj()->Actions("Show");

        $this->PreInscriptions_Submissions_Read();
        
        if (empty($this->Submissions))
        {
            return $this->H(2,$this->MyLanguage_GetMessage("Items_None_Found"));
        }

        $sdatas=$this->SubmissionsObj()->GetGroupDatas("PreInscriptions");

        //$timeids=$this->PreInscriptions_Submissions_Read_Times();
        $this->PreInscriptions_Submissions_Read_Times();

        $this->PreInscriptions_Inscription_Read($inscription);

        if ($this->CGI_POSTint("Save")==1)
        {
            $this->PreInscriptions_Submissions_Update($inscription);
        }
        

        $form="";
        if ($edit==1)
        {
            $sdatas[0]="No";
            $form.=
                $this->StartForm().
                $this->PreInscriptions_Submissions_Table_Html($edit,$inscription,$sdatas).
                $this->MakeHidden("Save",1).
                $this->EndForm().
                $this->HR(array("WIDTH" => '50%')).
                "";
        }
        
        return
            $paymentmsg.
            $this->PreInscriptions_Times_Table($inscription).
            $form.
            "";
    }
    
}

?>