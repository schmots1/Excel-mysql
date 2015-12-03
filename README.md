# Excel-mysql
A converting tool for getting UP and 7mtt excel docs into mysql
* currently only supports UP outputs


System Requirements:

  • At least 4 gigs of ram. (VM will require 2)
  • 2 Gigs of HD space
  • Access to internet during initial startup.
  • Windows/Mac/Linux
  • 64-bit virt processor option (workaround available if needed)

Software Requirements:
(All)
• Vagrant http://www.vagrantup.com
• Virtualbox http://virtualbox.org
(Windows Only)
Git Bash https://git-scm.com/download/win
(Git suggested on Mac, Linux)

Setup Instructions:

1. Install Virtualbox, Vagrant(, and Git Bash on Windows)
2. Download or git clone the project https://github.com/schmots1/Excel-mysql/archive/master.zip (#git clone https://github.com/schmots1/Excel-mysql.git)
3. From a console or git bash, navigate into the Excel-mysql directory that now exists.
•If you have 64-bit virtualiztaion on in your bios
4. Run the command 'vagrant up'
•If you don't have, or can't virtualize 64-bit
4a. Edit the "Vagrantfile".  Modify the line that says '   config.vm.box = "ubuntu/trusty64"' to say '   config.vm.box = "ubuntu/trusty32"'.  Save the file
4b. Run the command 'vagrant up'

(The vm will shutdown sometimes when the Host system sleeps.  Simply repeat steps 3-4 to restart the vm.

Unified Parcer output prep:

Open the UP excel file you want to prep, as well as the 'UP_3.0.1.1_prepare.xls' file from the Excel-mysql dir.  From the file you want to prep choose 'view->view macros' and run the macro from the UP_3.0.1.1_prepare.xls.  This will remove three tabs and prepare the rest for import to mysql.  When done save the file as up.xls in Excel-mysql directory.  The file must be saved as a .xls and not a .xlsx

Database/Dashboard prep:

From a console or git bash, navigate into the Excel-mysql directory and run 'vagrent ssh'.  This will ssh you into the LAMP system.  
Now run 'cd /vagrant' to switch to the shared folder.  
run './convert.pl'
Open a browser and point it to localhost:8081

