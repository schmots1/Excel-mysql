#!/usr/bin/perl
# For each tab (worksheet) in a file (workbook),
# spit out columns separated by ",",
# and rows separated by c/r.

use Spreadsheet::ParseExcel;
use FileHandle;
use strict;
print "Name for Database:";
chomp(my $input = <STDIN>);
my $database = "up_$input";
my $dsn = "DBI:mysql:";
my $username = "root";
my $password = "root";

my %attr = (PrintError=>0, RaiseError=>1);

my $dbh = DBI->connect($dsn,$username,$password, \%attr);

    my $query = "create database $database";
    #for my $sql($query){
       $dbh->do($query);
    #}



my $filename = shift || "./up.xls";
my $e = new Spreadsheet::ParseExcel;
my $eBook = $e->Parse($filename);
my $sheets = $eBook->{SheetCount};
my ($eSheet, $sheetName);

foreach my $sheet (0 .. $sheets - 1) {
    $eSheet = $eBook->{Worksheet}[$sheet];
    $sheetName = $eSheet->{Name};
    #print "#Worksheet $sheet: $sheetName\n";
    my $fh = FileHandle->new(">$sheetName.csv") || die $!; 
    next unless (exists ($eSheet->{MaxRow}) and (exists ($eSheet->{MaxCol})));
    foreach my $row ($eSheet->{MinRow} .. $eSheet->{MaxRow}) {
        foreach my $column ($eSheet->{MinCol} .. $eSheet->{MaxCol}) {
            if (defined $eSheet->{Cells}[$row][$column])
            {
                print $fh "\"" . $eSheet->{Cells}[$row][$column]->Value . "\",";
            } else {
                print $fh ",";
            }
        }
        print $fh "\n";
    }
$fh->close();
}
#
#removes comans from the end of lines
#
my $dir;
my $ENV;
$dir = $ENV{"PWD"};
opendir (DIR, $dir) || die "can not list the $dir directory";
while (my $FILE = readdir(DIR)) {
	# Skip files that are not ending in csv or CSV and skip the . and .. folders
	next if ( ($FILE !~ /(csv|CSV)$/) || ($FILE =~ /^.$|^..$/) );
	print "Processing $FILE\n";
	my $BAK = $FILE;
	$BAK =~ s/csv$/bak/g;
#	$BAK =~ s/CSV$/bak/g;
	rename ($FILE, $BAK);
	open (BAK, "< $BAK") || die "unable to open $BAK\n";
	open (NEW, "> $FILE") || die "unable to open $FILE\n";
	while (<BAK>) {
		$_ =~ s/,\s*$/\n/;
		print NEW $_;
	}
	close (BAK);
	close (NEW);
}

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
