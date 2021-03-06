array
(
   "Basic" => array
   (
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Status","Visible","Initials","Name","Title","Site",
         "Place","Place_Address","Place_Site",
         "EventStart","EventEnd",
         "Date","AnnouncementLink","Announcement",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => FALSE, //????
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Common" => array
   (
       #Leading table to be shown in Inscription Form
      "Name" => "Evento",
      "Name_UK" => "Event",

      "Data" => array
      (
         "Status","Visible",
         "Initials","Name","Title","Site",
         "AnnouncementLink","Announcement",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => FALSE, //????
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Place" => array
   (
      "Name" => "Local do Evento",
      "Name_UK" => "Event Venue",

      "Data" => array
      (
         "Place","Place_Address","Place_Site",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => FALSE, //????
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Dates" => array
   (
      "Name" => "Datas do Evento",
      "Name_UK" => "Event Dates",

      "Data" => array
      (
          "Date","EventStart","EventEnd",
          "Inscriptions_Public",
          "StartDate","EndDate","EditDate",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Single" => FALSE, //????
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Icons" => array
   (
      "Name" => "Ícones, LaTex",
      "Name_UK" => "Icons, LaTex",

      "Data" => array
      (
         "LatexIcon1","LatexIcon2"
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 0,
      "Admin" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "SubAction" => "Icons",
    ),
   "Banner" => array
   (
      "Name" => "Banner do Evento",
      "Name_UK" => "Event Banner",

      "Data" => array
      (
         "HtmlIcon1",
         "HtmlIcon1_Width","HtmlIcon1_Height",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 0,
      "Admin" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "SubAction" => "Icons",
    ),
   "Logo" => array
   (
      "Name" => "Logo do Event",
      "Name_UK" => "Event Logo",

      "Data" => array
      (
         "HtmlIcon2",
         "HtmlIcon2_Width","HtmlIcon2_Height",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 0,
      "Admin" => 1,
      "Friend"     => 0,
      "Coordinator" => 1,
      "SubAction" => "Icons",
    ),
     "Components" => array
    (
       "Name" => "Componentes",
       "Name_UK" => "Components",
       "Data" => array
       (
          "Payments",
          "Selection",
          "Certificates","Certificates_Published",
          "Collaborations","Caravans",
          "Submissions","Assessments",
          "Schedule_Public","Info",
       ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
    "Payments" => array
    (
       "Name" => "Pagamentos",
       "Name_UK" => "Payments",
       "Data" => array
       (
          "Payments",
          "Payments_Deposit",
          "Payments_PagSeguro",
          "Payments_Info","Payments_URL",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Payments_Has",
       "SubAction" => "Payments",
       "EditAccessMethod" => array("Current_User_Event_May_Edit",),
    ),
    "Payments_Deposit" => array
    (
       "Name" => "Depósito",
       "Name_UK" => "Deposito",
       "Data" => array
       (
          "Payments_Deposit",
          "Payments_Institution","Payments_Name",
          "Payments_Agency","Payments_Operation","Payments_Account","Payments_Variation"
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Payments_Has",
       "SubAction" => "Payments",
       "EditAccessMethod" => array("Current_User_Event_May_Edit",),
       #"TableDataMethod" => "Event_Payments_Datas",
    ),
    "Payments_PagSeguro" => array
    (
       "Name" => "PagSeguro",
       "Name_UK" => "PagSeguro",
       "Data" => array
       (
          "Payments_PagSeguro",
          "Payments_PagSeguro_Login",
          "Payments_PagSeguro_Code"
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Payments_Has",
       "SubAction" => "Payments",
       "EditAccessMethod" => array("Current_User_Event_May_Edit",),
       #"TableDataMethod" => "Event_Payments_Datas",
    ),
    "Collaborations" => array
    (
       "Name" => "Colaborações",
       "Name_UK" => "Collaborations",
       "Data" => array
       (
          "Collaborations","Collaborations_Inscriptions","Collaborations_StartDate","Collaborations_EndDate",
       ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Collaborations_Has",
       "SubAction" => "Collaborations",
       "EditAccessMethod" => "Current_User_Event_Collaborations_May_Edit",
    ),
    "Caravans" => array
    (
       "Name" => "Inscrição de Caravanas",
       "Name_UK" => "Caravans Inscription",
       "Data" => array
       (
        "Caravans","Caravans_StartDate","Caravans_EndDate",
        "Caravans_Min","Caravans_Max",
        "Caravans_Coord_Timeload","Caravans_Timeload",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Caravans_Table_Html",
       "AccessMethod" => "Event_Caravans_Has",
       "SubAction" => "Caravans",
       "EditAccessMethod" => "Current_User_Event_Caravans_May_Edit",
    ),
    "Submissions" => array
    (
       "Name" => "Submissão de Atividades",
       "Name_UK" => "Submission of Activities",
       "Data" => array
       (
          "Submissions","Submissions_Inscriptions",
          "Submissions_NAuthors",
          "Submissions_StartDate","Submissions_EndDate",
          "Certificates_Submissions_TimeLoad",
          "Contents","Proceedings",
          "Submissions_Public",
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Submissions_Table",
       "AccessMethod" => "Event_Submissions_Has",
       "SubAction" => "Submissions",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
    ),
    "PreInscriptions" => array
    (
       "Name" => "Preinscrições",
       "Name_UK" => "PreInscriptions",
       "Data" => array
       (
          "PreInscriptions_StartDate","PreInscriptions_EndDate","PreInscriptions_MustHavePaid"
       ),

       "Person" => 1,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       //"AccessMethod" => "Event_PreInscriptions_Has",
       "SubAction" => "PreInscriptions",
       "EditAccessMethod" => "Current_User_Event_PreInscriptions_May_Edit",
    ),
    "Certificates" => array
    (
       "Name" => "Certificados",
       "Name_UK" => "Certificates",
       "Data" => array
       (
          "Certificates","Certificates_Published","TimeLoad","Certificates_Watermark",
          "GenCert",
          "Certificates_Latex_Sep_Vertical",
          "Certificates_Latex_Sep_Horisontal",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "GenTableMethod" => "Event_Certificate_Table",
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
    ),
    "Certificate_Signatures" => array
    (
       "Name" => "Certificados, Assinaturas",
       "Name_UK" => "Certificates, Signatures",
       "Data" => array
       (
          "Certificates_Signature_1","Certificates_Signature_1_Text1","Certificates_Signature_1_Text2",
          "Certificates_Signature_2","Certificates_Signature_2_Text1","Certificates_Signature_2_Text2",
          "Certificates_Signature_3","Certificates_Signature_3_Text1","Certificates_Signature_3_Text2",
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "AccessMethod" => "Event_Certificates_Has",
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
    ),
    "Certificate_Latex" => array
    (
       "Name" => "Certificados, Participante",
       "Name_UK" => "Certificates, Participant",
       "Data" => array
       (
           "Certificates_Latex",//"Certificates_Latex_UK"
        ),

       "Person" => 0,
       "Public" => 1,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => "Event_Certificates_Has",
       "SubAction" => "Certificates",
       "EditAccessMethod" => "Current_User_Event_Inscriptions_May_Edit",
    ),
    "Submissions_Latex" => array
    (
       "Name" => "Atividades, Certificados",
       "Name_UK" => "Activities, Certificates",
       "Data" => array
       (
          "Certificates_Submissions_Latex",
          "Certificates_Submissions_Latex_UK",
          
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Submissions_Has","Event_Certificates_Has"),
       "SubAction" => "Submissions",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
    ),
    "Proceedings" => array
    (
       "Name" => "Anais",
       "Name_UK" => "Proceedings",
       "Data" => array
       (
          "Proceedings_DocType",
          "Proceedings_DocType_Options",
          "Proceedings_Preamble",
          "Proceedings_Postamble",
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array
       (
           "Event_Submissions_Has",
           "Current_User_Event_Submissions_Proceedings_Has",
           "Current_User_Event_Submissions_Proceedings_May",
       ),
       "SubAction" => "Submissions",
    ),
    "Collaborators_Latex" => array
    (
       "Name" => "Colaborações, Certificados",
       "Name_UK" => "Collaborators, Certificates",
       "Data" => array
       (
          "Certificates_Collaborations_Latex",
          "Certificates_Collaborations_Latex_UK",         
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Collaborations_Has","Event_Certificates_Has"),
       "SubAction" => "Collaborations",
       "EditAccessMethod" => "Current_User_Event_Collaborations_May_Edit",
   ),
    "Caravaneers_Latex" => array
    (
       "Name" => "Caravaneiros, Certificados",
       "Name_UK" => "Caravaneers, Certificates",
       "Data" => array
       (
          "Certificates_Caravans_Latex",
          "Certificates_Caravaneers_Latex",         
        ),

       "Person" => 0,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 0,
       "Coordinator" => 1,
       "Single" => 1,
       "AccessMethod" => array("Event_Caravans_Has","Event_Certificates_Has"),
       "SubAction" => "Caravans",
       "EditAccessMethod" => "Current_User_Event_Caravans_May_Edit",
    ),
    "Assessments" => array
    (
       "Name" => "Avaliação das Atividades",
       "Name_UK" => "Activities Assessment",
       "Data" => array
       (
          "Assessments","Assessments_StartDate","Assessments_EndDate",
       ),

       "Person" => 1,
       "Public" => 0,
       "Admin" => 1,
       "Friend"     => 1,
       "Coordinator" => 1,
       "SubAction" => "Assessments",
       "AccessMethod" => "Event_Assessments_Has",
       "EditAccessMethod" => "Current_User_Event_Submissions_May_Edit",
    ),
   
   "Conf_Basic" => array
   (
      "Name" => "Dados Básicos",
      "Name_UK" => "Basic Data",

      "Data" => array
      (
         "Status","Date","Visible",
         "Initials","Name","Title",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Visible" => False,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Conf_Place" => array
   (
      "Name" => "Local do Evento",
      "Name_UK" => "Event ",

      "Data" => array
      (
         "Place","Place_Address","Place_Site",
         "Site",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Visible" => False,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Conf_Occurs" => array
   (
      "Name" => "Datas do Evento",
      "Name_UK" => "Event Dates",

      "Data" => array
      (
         "EventStart","EventEnd",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Visible" => False,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Conf_Inscriptions" => array
   (
      "Name" => "Datas das Inscrições",
      "Name_UK" => "Dates of Inscriptions",

      "Data" => array
      (
         "StartDate","EndDate",
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Visible" => False,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
   "Conf_Admin" => array
   (
      "Name" => "Admin",
      "Name_UK" => "Admin",

      "Data" => array
      (
          "Visible","SystemURL"
      ),
      "Admin" => 1,
      "Person" => 0,
      "Public" => 1,
      "Admin" => 1,
      "Friend"     => 1,
      "Coordinator" => 1,
      "Visible" => False,
      "EditAccessMethod" => "Current_User_Event_May_Edit",
    ),
);
