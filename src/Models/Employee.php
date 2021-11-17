<?php

namespace App\Models;

use DateTime;
use Exception;

class Employee
{
    const MIN_VACATION_DAYS = 26;
    private string $name;
    private string $dateOfBirth;
    private string $contractStartDate;
    private string $specialContract;
    private int $specifiedYear;

    /**
     * Total vocation days for a specified year
     * @var int $vocationDays
     */
    public int $vacationDays = 0;

    /**
     * Employee Constructor
     * @param array $record
     * @param int $specifiedYear
     * @throws Exception
     */
    public function __construct(array $record, int $specifiedYear)
    {
        $this->name = $record['Name'];
        $this->dateOfBirth = $record['Date of Birth'];
        $this->contractStartDate = $record['Contract Start Date'];
        $this->specialContract = $record['Special Contract'];
        $this->specifiedYear = $specifiedYear;
        $this->validate();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    /**
     * @return string
     */
    public function getContractStartDate(): string
    {
        return $this->contractStartDate;
    }

    /**
     * @return string
     */
    public function getSpecialContract(): string
    {
        return $this->specialContract;
    }

    /**
     * @return int
     */
    public function getVacationDays(): int
    {
        return (string)$this->vacationDays;
    }

    /**
     * Validate the employee model class params
     * @throws Exception
     */
    private function validate() {
        if (empty($this->name) || !is_string($this->name)) {
            throw new Exception('Name must be of type string and not empty.', 512);
        }
        if (empty($this->dateOfBirth) || !$this->validateDate($this->dateOfBirth)){
            throw new Exception('Date of Birth must be a valid date and not empty.', 512);
        }
        if (empty($this->contractStartDate) || !$this->validateDate($this->contractStartDate)){
            throw new Exception('Contract Start Date must be a valid date and not empty.', 512);
        }
        if (!empty($this->specialContract) && !is_numeric($this->specialContract)){
            throw new Exception('Special Contract must be of type numeric.', 512);
        }
        if (empty($this->specifiedYear) || !is_integer($this->specifiedYear)){
            throw new Exception('Specified Year must be of type numeric and not empty.', 404);
        }
    }


    /**
     * Validate if date is correct
     * @param $date
     * @return bool
     */
    private function validateDate($date): bool
    {
        $d = DateTime::createFromFormat('d.m.Y', $date);
        return $d && $d->format('d.m.Y') === $date;
    }

    /**
     * Check if contract start date is greater than specified year
     * @throws Exception
     */
    public function checkContractStartDateIsValid()
    {
        $contractStartDate = DateTime::createFromFormat('d.m.Y', $this->contractStartDate);

        if ($contractStartDate->format('Y') > $this->specifiedYear){
            throw new Exception('No contract found for this year.', 512);
        }
    }

    /**
     * Check if this employee has special contract.
     */
    public function checkIfSpecialContract()
    {
        if (empty($this->specialContract)) {
            $this->vacationDays = self::MIN_VACATION_DAYS;
        } else {
            $this->vacationDays = (int)$this->specialContract;
        }
    }

    /**
     * Check if specified year is same with contract start date and get total vacation days.
     */
    public function checkSpecifiedYearEqualToContractYear()
    {
        $contractStartDate = DateTime::createFromFormat('d.m.Y', $this->contractStartDate);
        if ($contractStartDate->format('Y') == $this->specifiedYear){
            $contractStartDateDay = $contractStartDate->format('d');
            switch ($contractStartDateDay) {
                case "01":
                    $months = 13 - (int)$contractStartDate->format('m');
                    $this->vacationDays = (int)round($months * $this->vacationDays / 12);
                    break;
                case "15":
                    $months = 12 - (int)$contractStartDate->format('m');
                    $this->vacationDays = (int)round($months * $this->vacationDays / 12);
                    break;
            }
        }
    }

    /**
     * Check if employee >= 30 years to get one additional vacation day every 5 year.
     */
    public function checkIfOlderThan30Years()
    {
        $dateOfBirth = DateTime::createFromFormat('d.m.Y', $this->dateOfBirth);
        $contractStartDate = DateTime::createFromFormat('d.m.Y', $this->contractStartDate);
        $age = $this->specifiedYear - $dateOfBirth->format('Y');
        $workYears = $this->specifiedYear - $contractStartDate->format('Y');
        if ($age >= 30 && $workYears > 5) {
            $vacationDaysAdded = (int)floor($workYears / 5);
            $this->vacationDays += $vacationDaysAdded;
        }
    }

}