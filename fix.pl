#!/usr/bin/perl
use Spreadsheet::ParseExcel;
use FileHandle;
use strict;
print "Name for Database:";
chomp(my $input = <STDIN>);
my $database = "up-$input";
my $dsn = "DBI:mysql:";
my $username = "root";
my $password = "root";

my %attr = (PrintError=>0, RaiseError=>1);

my $dbh = DBI->connect($dsn,$username,$password, \%attr);
print `rm *.bak`;
my $dir = ".";

opendir(DIR, $dir) || die "Can't open $dir\n";
for (readdir(DIR)) {
  next if $_ eq '.';
  next if $_ eq '..';
  next if $_ eq 'lost+found';
  my $newfile = $_;
  $newfile =~ s/ /_/g;
  rename $_, $newfile;
}

use DBI;

my $dsn = "DBI:mysql:$database";
my $username = "root";
my $password = "root";

my %attr = (PrintError=>0, RaiseError=>1);

my $dbh = DBI->connect($dsn,$username,$password, \%attr);

my @files = `ls *.csv`;
foreach my $file (@files){
    chomp($file);
    my @rename = split('\.', $file);
    my @sheet = `cat "$file"`;
    my @split = split(',', $sheet[0]);
    my $query = "create table `$rename[0]`(";
    foreach my $split (@split) {
        my @split = split('"', $split);
        next if ( $split[1] =~ /^ *$/ );
        next if ( $split[1] =~ /^\s*$/ );
        $query = $query . "`@split[1]` VARCHAR(250),";
    }
    $query = $query . "PRIMARY KEY ( LineID )";
    $query = $query . ") ENGINE=InnoDB";
    print "$query\n";
    #for my $sql($query){
       $dbh->do($query);
    #}

}


my $dsn = "DBI:mysql:$database";
my $username = "root";
my $password = "root";

my %attr = (PrintError=>0, RaiseError=>1);

my $dbh = DBI->connect($dsn,$username,$password, \%attr);

my @files = `ls *.csv`;
foreach my $file (@files){
    chomp($file);
    my @rename = split('\.', $file);
    my $query = "load data infile '/vagrant/$file' into table $rename[0] fields terminated by ',' enclosed by '\"' ignore 1 rows";
    print "$file\n";
    #for my $sql($query){
       $dbh->do($query);
    #}
}
foreach my $file (@files){
    chomp($file);
    my @rename = split('\.', $file);
    my $query = "delete from $rename[0] where LineID like ''";
        $dbh->do($query);
}
print `rm *.csv`;

