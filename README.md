# Sivent2
Sistema de Gerenciamento de Eventos


Installation (tested on Debian until 9):

0: PhP version >= 5.5

1: Copy the files from the repository to the webserver directory, say /var/www/html.

2: Install lib.php-mailer (for sending emails)

3: Locate the Sivent2.sql file in the repository and import it into the sivent2 DB on the MySQL server, and adapt the data in Units to meet your needs. You may have to add credentials to your MySQL server mysql DB, the setup is specified in Sivent2/.DB.php.

4: For printing to work, you must have Latex installed - only tested on unix-like systems - however, on other platforms, it might work editing the pdflatex.sh script. Install texlive-full!

5: There's a mail setup for each entity using the system, found in the Units table. You may create a gmail account, using this to send the emails.

6: The same Sivent2 installation may contain several seperate units, which are kept in SQL tables seperate.
Only the Unit table is common. The default database from Sivent.sql contains an Unit table, with a default
unit, you may edit it to suit your needes. This unit has ID 1. In it's 1_Friends table, a default Admin user included.
The default password i 12345678, which clearly should be changed.

7: To access Sivent2, in your browser, type: your.server.com/your.path?Unit=1.
