# Ottivo Employees Vacation

## Documentation

### Overview

Project is designed with Object-Oriented Programming, and it is open for code extendable in the future. <br>
Considered that files will be taken from `data/storage/` directory, so in this way is more dynamic to be used if you have many files to calculate. <br>
Files should be of type csv and should have a structure like shown below: <br><br>

Name | Date of Birth | Contract Start Date | Special Contract
--- | --- | --- | --- 
[string,required] | [string,date(dd.mm.yyyy),required] | [string,date(dd.mm.yyyy),required] | [numeric]

<br><br>
I've also included a test file `employeeList.csv` under storage directory. <br>
Each ERROR or WARNING is logged into `data/logs/ottivo.log` file, so the end-user will not be able to see any error.

### What is used ?

- PHP 8
- PHPUnit

### Technologies (Packages)

- [League CSV](https://csv.thephpleague.com/). CSV data manipulation made easy in PHP.
  Please check documentation.
- [Garden CLI](https://github.com/vanilla/garden-cli). PHP command line interface library meant to provide a full set of functionality.
  Please check documentation.

### Setup Instructions

- composer install

### Commands

- Run this command for script usage and arguments <br>
<code>php calculateVacations.php --help</code> <br>
Example: <br>
<code>php calculateVacations.php --year=2007 --filename=employeeList.csv</code>
- Run the PHPUnit tests by using this command: <br>
<code>./vendor/bin/phpunit</code>

