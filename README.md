# Excel-mysql
A converting tool for getting UP and 7mtt excel docs into mysql

* currently only supports UP


Requirements:

Vagrant http://www.vagrantup.com
Virtualbox http://virtualbox.org

At least 4 gigs of ram. (VM will require 2)
2 Gigs of HD space

Access to internet during initial startup.

Excel prep:

Open the UP excel file you want to prep, as well as the 'UP_3.0.1.1_prepare.xls' file.  From the file you want to prep choose tools->macros and run the macro from the UP_3.0.1.1_prepare.xls.  This will remove three tabs and prepare the rest for import to mysql.  When done save the file as up.xls in this directory.

LAMP prep:

After Vagrant and Virtualbox are installed, simply run `vagrant up` from within this directory.

Database/Dashboard prep:

From within this directory run 'vagrent ssh'.  This will ssh you into the LAMP system.  
Now run 'cd /vagrant' to switch to the shared folder.  
run './convert.pl'
Open a browser and point it to localhost:8081

