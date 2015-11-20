#!/usr/bin/perl

use strict;
use DBI;

my $dsn = "DBI:mysql:";
my $username = "root";
my $password = "root";

my %attr = (PrintError=>0, RaiseError=>1);

my $dbh = DBI->connect($dsn,$username,$password, \%attr);

    my $query1 = "drop database test";
    my $query2 = "create database test";
    #for my $sql($query){
       $dbh->do($query1);
       $dbh->do($query2);
    #}
