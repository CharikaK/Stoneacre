<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

  <?php // A sample work ?>

  <div class="container">
    <div class="row">


      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Imported amount of data rows
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {{ $email_body->importedData }}
            </div>
          </div>
        </div>
      </div>
      {{-- Passed data --}}
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Details of Valid data
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table-auto">
                <thead>
                  <tr>
                    <th>Registration number</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($email_body->passedData as $row)
                  
                  <tr>
                    <td>{{ $row["REG"] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>    

            </div>
          </div>
        </div>
      </div>

      {{-- Failed data --}}
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Details of failed data
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              
              <table class="table-auto border-separate">
                <thead>
                  <tr>
                    <th>Registration number</th>
                    <th>Failed Reason</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($email_body->failedData as $row)                  
                  <tr>
                    <td>{{ $row["REG"] }}</td>
                    <td>{{ $row["REASON"] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>    
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>    
  
  
</body>
</html>