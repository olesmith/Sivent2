array
(
   'MailHead' => array
   (
      'Head' => 'Prezado(a) #Name',
      'Head_UK' => 'Dear #Name',
   ),
   'MailTail' => array
   (
      'Name' => 
        "Atenciosamente,\n".
        "#Department\n".
        "#Institution",

      'Name_UK' =>
        "Regards\n".
        "#Department\n".
        "#Institution",
   ),
   'Emails' => array
   (
      'Subject' => 'Mensagem, #Name',
      'Subject_UK' => 'Message, #Name_UK',
      'Body' => 
        "Prezado(a)\n\n".
        "Mensagem do Administrador para todos os Candidatos...\n\n#Name, #Institution\n\n",

      'Body_UK' =>
        "Dear\n\n".
        "Message from the Administrator to all the Candidates...\n\n#Name_UK, #Institution\n\n",
   ),
);
