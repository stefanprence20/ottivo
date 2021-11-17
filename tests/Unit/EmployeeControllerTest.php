<?php

namespace Tests\Unit;

use App\Controllers\EmployeeController;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

class EmployeeControllerTest extends TestCase
{
    /**
     * @dataProvider yearAndFilenameCases
     */
    public function testEmployeeControllerInitialization($year, $filename)
    {
        $this->expectException(TypeError::class);
        $employeeController = new EmployeeController($year, $filename);
    }

    public function yearAndFilenameCases(): array
    {
        return [
            [
                "201zero",
                "employeeList.csv"
            ],
            [
                2010,
                ["employeeList.csv"]
            ]
        ];
    }
}
