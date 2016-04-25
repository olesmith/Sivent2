array
(
      "00_Register" => array
      (
         'Title' => 'Registrar-se:',
         'Title_UK' => 'Register:',

         'Public'   => 1,
         'Person'   => 0,
         "Admin"    => 0,
         "Friend"     => 0,
         "Coordinator" => 0,
         "Assessor"  => 0,
         '00_Register' => array
         (
            'Name' => 'Cadastrar-se',
            'Name_UK' => 'Register',
            'Href' => '?Unit=#Unit&Action=Register',
            'Public'   => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
         '10_ResendConfirm' => array
         (
            'Name' => 'Reenviar Código de Confirmação',
            'Name_UK' => 'Resend Confirm Code',
            'Href' => '?Unit=#Unit&Action=ResendConfirm',
            'Public  ' => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
         '20_Confirm' => array
         (
            'Name' => 'Confirmar Cadastro',
            'Name_UK' => 'Confirm Registration',
            'Href' => '?Unit=#Unit&Action=Confirm',
            'Public'   => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
         '25_ResendConfirm' => array
         (
            'Name' => 'Reenviar Cod. de Cadastro',
            'Name_UK' => 'Resend Confirm Code',
            'Href' => '?Unit=#Unit&Action=ResendConfirm',
            'Public'   => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
         '30_Recover' => array
         (
            'Name' => 'Recuperar Senha',
            'Href' => '?Unit=#Unit&Action=Recover',
            'Public'   => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
       ),



       "00_Personal" => array
       (
         'Title' => 'Pessoal:',
         'Title_UK' => 'Personal:',

         'Public'   => 1,
         'Person'   => 1,
         "Admin"    => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "Assessor"  => 1,
         '00_Top' => array
         (
            'Name' => 'Início',
            'Name_UK' => 'Start',
            'Title' => 'Voltar ao Início',
            'Href' => '?Unit=#Unit&Action=Start',

            'Public'   => 1,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
         ),
         '40_Logon' => array
         (
            'Name' => 'Efetuar Login',
            'Name_UK' => 'Logon',
            'Href' => '?Unit=#Unit&Action=Logon',
            'Public' => 1,
            'Person' => 0,
            'Admin' => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
          ),
         '50_Logoff' => array
         (
            'Name' => 'Sair',
            'Title' => 'Efetuar Logoff (Sair) do Sistema',
            'Name_UK' => 'Logoff',
            'Title_UK' => 'Logoff from the Sistema',

            'Href' => '?Unit=#Unit&Action=Logoff',
            "SiPE" => 1,
            "SiDS" => 0,
            'Public'      => 0,
            'Person'      => 1,
            'Admin'       => 1,
            "Friend"     => 1,
            "Coordinator" => 1,
            "Assessor"  => 1,
         ),
         '60_NewPassword' => array
         (
            'Name' => 'Alterar Senha',
            'Title' => 'Alterar minha Senha',
            'Name_UK' => 'Change Password',
            'Title_UK' => 'Change my Password',
            'Href' => '?Unit=#Unit&Action=NewPassword',
            'Public'   => 0,
            'Person'   => 0,
            'Admin'    => 1,
            "Friend"     => 1,
            "Coordinator" => 1,
            "Assessor"  => 1,
         ),
         /* '65_NewLogin' => array */
         /* ( */
         /*    'Name' => 'Alterar Email (Login)', */
         /*    'Title' => 'Alterar meu Email', */
         /*    'Name_UK' => 'Change Email (Login)', */
         /*    'Title_UK' => 'Change my Email Email', */

         /*    'Href' => '?Unit=#Unit&Action=NewLogin', */
         /*    'Public'   => 0, */
         /*    'Person'   => 0, */
         /*    'Admin'    => 1, */
         /*    "Friend"     => 1, */
         /*    "Coordinator" => 1, */
         /*    "Assessor"  => 1, */
         /* ), */
         '70_SU' => array
         (
            'Name' => 'Trocar Usuário',
            'Title' => 'Virar para outro Usuário',
            'Name_UK' => 'Shift User',
            'Title_UK' => 'Switch to Another User',

            'Href' => '?Unit=#Unit&Action=SU',
            'Public'   => 0,
            'Person'   => 0,
            'Admin'    => 1,
            "Friend"     => 0,
            "Coordinator" => 1,
            "Assessor"  => 0,
         ),
         '80_MyData' => array
         (
            'Name' => 'Meus Dados',
            'Title' => 'Editar Dados do meu Cadastro',
            'Name_UK' => 'My Personal Info',
            'Title_UK' => 'Edit Registration Data',

            'Href' => '?Unit=#Unit&ModuleName=Friends&Action=Edit&ID=#LoginID',
            'Public'   => 0,
            'Person'   => 0,
            'Admin'       => 1,
            "Friend"     => 1,
            "Coordinator" => 1,
            "Assessor"     => 1,
         ),
         '90_MyUnit' => array
         (
            'Name' => 'Minha Unidade',
            'Title' => 'Editar Dados da Minha Unidade',
            'Name_UK' => 'My Unit',
            'Title_UK' => 'Edit Unit Data',

            'Href' => '?Unit=#Unit&ModuleName=Units&Action=Edit',
            'Public'   => 0,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 1,
            "Assessor"  => 0,
         ),
      ),



      "01_Profile" => array
      (
         'Title' => 'Perfís:',
         'Title_UK' => 'Profiles:',
         "Method" => "MyApp_Interface_LeftMenu_Profile",

         'Public'   => 0,
         'Person'   => 0,
         'Admin'    => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "Assessor"  => 1,
      ),
      "03_Units" => array
      (
         'Title' => 'Entidades:',
         'Title_UK' => 'Entities:',

         'Public'   => 0,
         'Person'   => 0,
         "Admin"    => 0,
         "Friend"     => 0,
         "Coordinator" => 0,

         '10_Units' => array
         (
            'Name' => 'Gerenciar Entidades',
            'Title' => 'Manage Entities',
            'Name_UK' => 'Entidades',
            'Title_UK' => 'Entities',

            'Href' => '?ModuleName=Units&Action=Search',
            'Public'   => 0,
            'Person'   => 0,
            'Admin'    => 0,
            "Friend"     => 0,
            "Coordinator" => 0,
            "Assessor"  => 0,
         ),
      ),
      "04_App" => array
      (
         'Title' => 'SiVent2:',
         'Title_UK' => 'SiVent2:',

         'Public'   => 1,
         'Person'   => 0,
         "Admin"    => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "Assessor"  => 1,
         "Method" => "HtmlUnitMenu",
     ),
      "05_Language" => array
      (
         'Title' => 'Línguas:',
         'Title_UK' => 'Language:',

         'Public'   => 1,
         'Person'   => 1,
         "Admin"    => 1,
         "Friend"     => 1,
         "Coordinator" => 1,
         "Assessor"  => 1,
         "Method" => "MyApp_Interface_LeftMenu_Language",
     ),
);
