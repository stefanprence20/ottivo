<?php

use App\Controllers\EmployeeController;
use App\Helpers\CSV;
use App\Helpers\Log;
use Garden\Cli\Cli;

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/src/Services/EmployeesService.php';
require __DIR__.'/src/Models/Employee.php';
require __DIR__.'/src/Helpers/CSV.php';

try {
    $cli = new Cli();
    $cli->description('Outputs the employees names with the respective number of vacation days by year.')
        ->opt('year', 'Specify year for employee vacations.', true, 'integer')
        ->opt('filename', 'Set custom csv file to do calculations.');

    // Parse and return cli args.
    $args = $cli->parse($argv, true);
    $year = $args->getOpt('year');
    $filename = $args->getOpt('filename', CSV::DEFAULT_FILENAME);;

    $employeeController = new EmployeeController($year, $filename);
    $employeeController->calculateVacationDays();
} catch (Exception $ex) {
    Log::error($ex->getMessage(), $ex->getCode(), $ex->getTrace());
}
