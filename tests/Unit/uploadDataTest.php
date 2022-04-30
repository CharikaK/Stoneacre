<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

use App\Http\Controllers\DataFilesController;
use App\Mail\SendReports;

class uploadDataTest extends TestCase
{

    use RefreshDatabase;

    public $importedData = array(
        0 =>[
            0 => "NF18LDB",
            1 => "Ford",
            2 => "Kuga",
            3 => "ST-Line",
            4 => "1.5 TDCi ST-Line 5dr Auto 2WD",
            5 => "7,015.29",
            6 => "YELLOW",
            7 => "81382",
            8 => "CAR",
            9 => "2020-08-31",
            10 => "https://stoneacre.test/images/NF18LDB_1.jpg,https://stoneacre.test/images/NF18LDB_2.jpg,https://stoneacre.test/images/NF18LDB_3.jpg,"
        ],
        1 => [
            0 => "NQ08IQK",
            1 => "BMW",
            2 => "1-Series",
            3 => "Sport",
            4 => "116d Sport 5dr [Nav]",
            5 => "1,653.93",
            6 => "SILVER",
            7 => "107773",
            8 => "CAR",
            9 => "2020-06-01",
            10 => "https://stoneacre.test/images/NQ08IQK_1.jpg,https://stoneacre.test/images/NQ08IQK_2.jpg,https://stoneacre.test/images/NQ08IQK_3.jpg,"
        ]
        );

    public $headers = array(  
        0 => "REG",
        1 => "MAKE",
        2 => "RANGE",
        3 => "MODEL",
        4 => "DERIVATIVE",
        5 => "PRICE_INC_VAT",
        6 => "COLOUR",
        7 => "MILEAGE",
        8 => "VEHICLE_TYPE",
        9 => "DATE_ON_FORECOURT",
        10 => "IMAGES"
    );
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testvalidateData()
    {
         
        $validatedData = (new DataFilesController())->validateData($this->headers,$this->importedData);
        foreach($validatedData as $row){
            $this->assertArrayHasKey("REG",$row);
            $this->assertArrayHasKey("IMAGES",$row);
        }

    }

    public function testNumberOfImages(){

        $a = 
            [
                0 => "NQ08IQP",
                1 => "BMW",
                2 => "1-Series",
                3 => "Sport",
                4 => "116d Sport 6dr [Nav]",
                5 => "1,653.93",
                6 => "SILVER",
                7 => "107774",
                8 => "CAR",
                9 => "2020-06-01",
                10 => "https://stoneacre.test/images/NQ08IQK_1.jpg,https://stoneacre.test/images/NQ08IQK_2.jpg"
            ];
        array_push($this->importedData,$a);
        $validatedData = (new DataFilesController())->validateData($this->headers,$this->importedData);
        dd($validatedData);
    }
}
