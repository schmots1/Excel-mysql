# Excel-mysql
A converting tool for getting UP and 7mtt excel docs into mysql
* currently only supports UP outputs


System Requirements:

  * At least 4 gigs of ram. (VM will require 2)
  * 2 Gigs of HD space
  * Access to internet during initial startup.
  * Windows/Mac/Linux
  * 64-bit virt processor option (workaround available if needed)

Software Requirements:

(All)
* Vagrant http://www.vagrantup.com
* Virtualbox http://virtualbox.org

(Windows Only)
* Git Bash https://git-scm.com/download/win
(Git suggested on Mac, Linux)

UP Requirements:
Must be at least version 3.0.1.1 of UP.  4.0.0.1 also works.

Setup Instructions:

1. Install Virtualbox, Vagrant(, and Git Bash on Windows).
2. Download or git clone the project https://github.com/schmots1/Excel-mysql/archive/master.zip / #git clone https://github.com/schmots1/Excel-mysql.git.
3. If you downloaded the zip file extract it. (If you use the zip file the working directory will be called Excel-mysql-master)

*If you don't have virt on in bios, or can't virtualize 64-bit.

4. Open for editing the file called "Vagrantfile" in the newly created/extracted Excel-mysql directory.  
5. Modify the line that says '   config.vm.box = "ubuntu/trusty64"' to say '   config.vm.box = "ubuntu/trusty32"'.
6. Save the file.

*add note about forward ports

(The vm will shutdown sometimes when the Host system sleeps.  Simply repeat steps 3-4 to restart the vm.

Unified Parcer output prep:
* This will remove three tabs and prepare the rest for import to mysql.  

1. Open the UP excel file you want to prep, as well as the 'UP_3.0.1.1_prepare.xls' file from the Excel-mysql dir.  
2. From the file you want to prep choose 'view->view macros' and run the macro from the UP_3.0.1.1_prepare.xls.  
3. When done save the file as up.xls in Excel-mysql directory.  
*The file must be saved as a .xls and not a .xlsx

Database/Dashboard prep:

1. From a console or git bash, navigate into the Excel-mysql directory and run 'vagrant ssh'.  *Git Bash must be run as Administrator.  
2. Run 'cd /vagrant' to switch to the shared folder.  
3. Run './convert.pl' and follow the instructions.
4. Open a browser and point it to localhost:8081.

Refreshing or removing the VM:
(If you want to clear your system and start over)
* From a console or git bash, navigate into the Excel-mysql directory and run 'vagrent destroy'

To update:

1. Download the zip again and overwrite the current directory.  
1a. If you used git the command 'git pull' from within the Excel-mysql directory will update the files.
