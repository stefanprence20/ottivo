<?php

namespace App\Services;

use App\Helpers\CSV;
use App\Helpers\Log;
use App\Models\Employee;
use Exception;
use Iterator;

class EmployeesService
{
    protected Iterator $records;

    /**
     * @param string $csvFilename
     * @throws Exception
     */
    public function __construct(string $csvFilename)
    {
        $this->records = CSV::getRecords($csvFilename);
    }

    /**
     * @param int $specifiedYear
     * @throws Exception
     */
    public function getEmployeesVacationByYear(int $specifiedYear)
    {
        foreach ($this->records as $record) {
            try {
                $employee = new Employee($record, $specifiedYear);
                $employee->checkContractStartDateIsValid();
                $employee->checkIfSpecialContract();
                $employee->checkIfOlderThan30Years();
                $employee->checkSpecifiedYearEqualToContractYear();
                echo $employee->getName() . " has " . $employee->getVacationDays() . " vacation days.\n";
            } catch (Exception $ex) {
                if ($ex->getCode() === 512) {
                    Log::warning($ex->getMessage(), $ex->getCode(), $ex->getTrace());
                    continue;
                } else {
                    throw new Exception($ex->getMessage(), $ex->getCode());
                }
            }
        }
    }

    /**
     * @return Iterator
     */
    public function getRecords(): Iterator
    {
        return $this->records;
    }
}