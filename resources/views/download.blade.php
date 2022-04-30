<!DOCTYPE html>
<html>
<head>
    <title>Stoneacre-Test-Charika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
  
<body>

<div class="container">
   
  <div class="panel panel-primary">
    <div class="panel-heading"><h2>Download File</h2></div>
    <div class="panel-body">

      <form action="{{route('file.download')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">

              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Make</span>
                <input id="make" type="text" name="make" class="form-control">
              </div>
 
              <div class="col-md-6">
                  <button type="submit" class="btn btn-success">Upload</button>
              </div>
 
          </div>
      </form>

    </div>
  </div>
</div>


</body>
</html>