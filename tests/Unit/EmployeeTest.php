<?php

namespace Tests\Unit;

use App\Models\Employee;
use Exception;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * @dataProvider validateRecordCases
     */
    public function testEmployeeValidation(array $record, $specifiedYear)
    {
        $this->expectException(Exception::class);
        new Employee($record, $specifiedYear);
    }

    /**
     * @throws Exception
     */
    public function testCheckContractStartDateIsValid()
    {
        $record = [
            'Name' => 'Hans Müller',
            'Date of Birth' => '30.12.1950',
            'Contract Start Date' => '01.01.2001',
            'Special Contract' => ''
        ];
        $specifiedYear = "2000";
        $employee = new Employee($record, $specifiedYear);
        $this->expectException(Exception::class);
        $employee->checkContractStartDateIsValid();
    }

    /**
     * @throws Exception
     */
    public function testCheckIfSpecialContract()
    {
        $record = [
            'Name' => 'Hans Müller',
            'Date of Birth' => '30.12.1950',
            'Contract Start Date' => '01.01.2001',
            'Special Contract' => ''
        ];
        $specifiedYear = 2011;
        $employee = new Employee($record, $specifiedYear);
        $employee->checkIfSpecialContract();
        $this->assertEquals(Employee::MIN_VACATION_DAYS, $employee->getVacationDays());
    }

    /**
     * @throws Exception
     */
    public function testCheckSpecifiedYearEqualToContractYear()
    {
        $record = [
            'Name' => 'Peter Klever',
            'Date of Birth' => '12.07.1991',
            'Contract Start Date' => '15.05.2016',
            'Special Contract' => '27'
        ];
        $specifiedYear = 2016;
        $employee = new Employee($record, $specifiedYear);
        $employee->checkIfSpecialContract();
        $employee->checkSpecifiedYearEqualToContractYear();
        $this->assertEquals(16 , $employee->getVacationDays());
    }

    /**
     * @throws Exception
     */
    public function testCheckIfOlderThan30Years()
    {
        $record = [
            'Name' => 'Hans Müller',
            'Date of Birth' => '30.12.1950',
            'Contract Start Date' => '01.01.2001',
            'Special Contract' => ''
        ];
        $specifiedYear = 2016;
        $employee = new Employee($record, $specifiedYear);
        $employee->checkIfSpecialContract();
        $employee->checkIfOlderThan30Years();
        $this->assertEquals(29 , $employee->getVacationDays());
    }

    /**
     * @return string[][]
     */
    public function validateRecordCases(): array
    {
        return [
            [
                [
                    'Name' => 'Hans Müller',
                    'Date of Birth' => '3000.12.1950',
                    'Contract Start Date' => '01.01.2001',
                    'Special Contract' => ''
                ],
                2011
            ],
            [
                [
                    'Name' => 'Hans Müller',
                    'Date of Birth' => '30.12.1950',
                    'Contract Start Date' => '011.01.2001',
                    'Special Contract' => ''
                ],
                2011
            ],
            [
                [
                    'Name' => 'Hans Müller',
                    'Date of Birth' => '30.12.1950',
                    'Contract Start Date' => '01.01.2001',
                    'Special Contract' => 'int'
                ],
                2011
            ],
            [
                [
                    'Name' => '',
                    'Date of Birth' => '30.12.1950',
                    'Contract Start Date' => '01.01.2001',
                    'Special Contract' => ''
                ],
                2011
            ]
        ];
    }
}
