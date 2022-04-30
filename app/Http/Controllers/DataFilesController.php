<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;

use App\Mail\SendReports;
use App\Models\vehicle;
use App\Models\vehicle_category;
use App\Models\images;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DataFilesController extends Controller
{
    private $faliedData=[];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    // TASK 01
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileExt = $file->getClientOriginalExtension();
       
        // validations
        // check file extension
        // check file size

        $location = "uploadedData";
        $file->move($location,$fileName);

        $filePath = public_path($location.'/'.$fileName);

        $file = fopen($filePath,"r");
        if($file){
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE){
                $importedData[]=$data;
            }  
            // ** We should have created an array with headers
            // loop through headers and each row data should go to headers
            $headers = array_shift($importedData);            
            // removing the headers          
            $importedData = array_slice($importedData,0);            
        }

        fclose($file);

        // Validating and inserting data should be in the queues

        // preparing the data after tidying up.
        $validatedData = $this->validateData($headers, $importedData);
        $count=0;
        // create images array to insert into database
        // create vehicles 
        // create categories

        // insert 
        // loop through each array, check each row details are already in the db, in not insert. 
        foreach($validatedData->passedData as $record){
            $count  ++;
            $cat = new vehicle_category();
            $cat_id = $cat->addNewCategory($record);

            $vehicle = new vehicle();
            $row = $vehicle->addNewVehicle($cat_id,$record);

            $images =vehicle::find($row->id)->images();
            if(!empty($images)){

                $images = explode(",",rtrim($record["IMAGES"],","));

                $new_images = new images();
                $new_images->addImages($record["REG"],$images);
            }
            if($count==3){break;}
        }

        return view('emailReport',['email_body'=>$validatedData]);
        $this->sendReport($importedData,$validatedData);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function downloadDataForm()
    {
        return view('download');
    }

    public function download(Request $request)
    {
        // file name
        $filename = "download.csv";
        
        // create headers
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        // columns
        $titles = array('Registration','Car Title','Price','VAT','Image');

        // gather data
        $make=$request->get('make');

        /*SELECT 
        vehicles.reg as 'Registration',
        CONCAT(vehicle_categories.make," ",vehicle_categories.model," ",vehicle_categories.derivative) as "Car Title",
        vehicles.price as "Price",
        vehicles.vat as "VAT",
        vehicles."Image"
        FROM `vehicles`
        INNER JOIN `vehicle_categories` ON vehicles.cat_id=vehicle_categories.id
        INNER JOIN `images` ON vehicles.reg=images.reg_number
        */

        $data = vehicle::select(
            'vehicles.reg AS Registration',
            DB::raw('CONCAT(vehicle_categories.make," ",vehicle_categories.model," ",vehicle_categories.derivative) AS CarTitle'),
            'vehicles.price AS Price',
            'vehicles.vat AS VAT',
            'images.img_1 AS Image')
            ->join('vehicle_categories','vehicles.cat_id','=','vehicle_categories.id')
            ->join('images','vehicles.reg','=','images.reg_number')
            ->where('vehicle_categories.make','=',$make)
            ->get();

        // Fill rows
        
        $filenameWithPath =  public_path("files/download.csv");
        $file = fopen($filenameWithPath, 'w');
        fputcsv($file, $titles);
            
        foreach ($data as $datarow) {
            $row['Registration']  = $datarow->Registration;
            $row['Car Title']    = $datarow->CarTitle;
            $row['Price']    = $datarow->Price;
            $row['VAT']  = $datarow->VAT;
            $row['Image']  = $datarow->Image;

            fputcsv($file, array($row['Registration'], $row['Car Title'], $row['Price'], $row['VAT'], $row['Image']));
        }

        fclose($file);
        
        //get filename without extension
        $filename = pathinfo($filenameWithPath , PATHINFO_FILENAME);
        $extension = pathinfo($filenameWithPath , PATHINFO_EXTENSION);
        $fileNameToStore = $filename."-".Carbon::now().".".$extension;

        //Upload File to external server
        // NOTE : Set up your ftp credentials in .env file
        //Storage::disk('ftp')->put($fileNameToStore, fopen($filenameWithPath, 'r+'));

        return Response::download($filenameWithPath, "download.csv", $headers);
    }



    
    /**
     *  // validate field values in each row
     *    A Vehicle must have a Registration
     *    A Vehicle must have at least 3 images
     *    A Vehicle must have a price greater than zero 
     */
    public function validateData($headers, $importedData){
        //print_r($headers);
        $prepareToValidate=[];
        $passedData=[];
        $failedData=[];

        foreach($importedData as $row){
            // prepare each record with header and value
            foreach( $row as $rowKey => $rowValue){
                $prepareToValidate[$headers[$rowKey]] = $rowValue;
            }
           
           
            $registration = $images = $price ='';

            if($prepareToValidate["REG"] && $prepareToValidate["PRICE_INC_VAT"] && $prepareToValidate["IMAGES"] ){
                
                $images = explode(",",rtrim($prepareToValidate["IMAGES"],","));
                if(count($images)>=3){
                    $prepareToValidate["REASON"]="";
                    $passedData[]=$prepareToValidate;
                }else{
                    $prepareToValidate["REASON"]="Either Vehicle Registration number OR Price Or Images less than 3";
                    $failedData[] = $prepareToValidate;
                }
            }
            else{
                if(!$prepareToValidate["REG"]){
                    $prepareToValidate["REASON"]="Missing REG number";
                }
                if(!$prepareToValidate["PRICE_INC_VAT"]){
                    $prepareToValidate["REASON"]="Missing price";
                }
                if(!$prepareToValidate["IMAGES"]){
                    $prepareToValidate["REASON"]="No Images";
                }                
                $failedData[] = $prepareToValidate;
            }
        }
      
        $validatedData = new \stdClass();
        $validatedData->importedData = count($importedData);
        $validatedData->passedData = $passedData;
        $validatedData->failedData = $failedData;
        
        return $validatedData;
    }

    public function sendReport($importedData,$validatedData){

        $emailData = array(
            'email'=>'recepient@x.com',
            'name'=>'recepient',
            'subject'=>'Latest data upload report',
            'imported'=>$importedData,
            'inserted'=>$validatedData->passedData,
            'failed'=>$validatedData->failedData
        );

        /* Email */

        // Going further we can pass the instance of a class 
        // which deals with data to the Mailable constructor

        $sendReport = new SendReports(); 
        $sendReport->go($sendReport,$emailData);
    }

    public function test()
    {
        return view('emailReport');
    }
}
