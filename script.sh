#!/bin/bash

#update repository
sudo apt-get -y update

#install apache
sudo apt-get -y install apache2

#install and setup Mysql
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql

#install php
sudo apt-get -y install php5 libapache2-mod-php5 php5-mcrypt

#setup perl
sudo apt-get -y install cpanminus
sudo cpanm Spreadsheet::ParseExcel
