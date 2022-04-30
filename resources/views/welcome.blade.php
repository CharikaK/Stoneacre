<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <div class="md:container md:mx-auto mt-10">
        <div class="columns-1">
            <p> Use this interface to upload and download the data </p>
        </div>
        <div class="flex flex-row py-2 px-3 space-x-4">
            <div class="basis-1/4">
                <a href="/upload-data" class="cursor-pointer bg-green-700 rounded py-2 px-5 space-x-4 mr-4 text-white" >Upload Data</a> 
                <a href="/download-file" class="cursor-pointer bg-green-700 rounded py-2 px-5 space-x-4 mr-4 text-white" >Download Data</a>              
            </div>               
        </div>
    </div>

</body>
</html>