#!/bin/bash

#update repository
sudo apt-get -y update

#apparmor tools
sudo apt-get -y install apparmor-utils
sudo aa-complain /usr/sbin/mysqld
sudo /etc/init.d/apparmor reload

#install apache
sudo apt-get -y install apache2

if ! [ -L /var/www/html ]; then
  rm -rf /var/www/html
  ln -fs /vagrant/html /var/www/html
fi

#install and setup Mysql
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql

#install php
sudo apt-get -y install php5 libapache2-mod-php5 php5-mcrypt

#setup perl
sudo apt-get -y install cpanminus
sudo cpanm Spreadsheet::ParseExcel
