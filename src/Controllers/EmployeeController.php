<?php

namespace App\Controllers;

use App\Helpers\Log;
use App\Services\EmployeesService;
use Exception;

class EmployeeController
{
    private string $specifiedYear;
    private string $csvFilename;

    /**
     * EmployeeController Constructor
     * @param int $specifiedYear
     * @param string $csvFilename
     */
    public function __construct(int $specifiedYear, string $csvFilename)
    {
        $this->specifiedYear = $specifiedYear;
        $this->csvFilename = $csvFilename;
    }

    /**
     * Outputs the employees names with the respective number of vacation days.
     */
    public function calculateVacationDays()
    {
        try {
            $employeesService = new EmployeesService($this->csvFilename);
            $employeesService->getEmployeesVacationByYear($this->specifiedYear);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), $ex->getCode(), $ex->getTrace());
        }
    }

}