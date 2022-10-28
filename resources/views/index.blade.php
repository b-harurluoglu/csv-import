<!doctype html>
<html lang="tr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Mivento Assessment</title>

    <style>
      .container {
        margin-top: 2rem !important;
      }
      table {
        font-size: 0.9rem !important;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="alert alert-danger d-none"></div>
          <div class="alert alert-success d-none"></div>
          <form action="javascript:void(0)" class="needs-validation import-form" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="mb-3">
              <label for="campaign-name" class="form-label">Kampanya Adı</label>
              <input type="text" class="form-control" id="campaign-name" name="name" required />
            </div>
            <div class="mb-3">
              <select class="form-select" name="date" required>
                <option selected disabled value="">Tarih Seçin</option>
                <option value="2022-07">Temmuz 2022</option>
                <option value="2022-08">Ağustos 2022</option>
                <option value="2022-09">Eylül 2022</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="campaign-file" class="form-label">Dosya Yükleyin</label>
              <input class="form-control" type="file" id="campaign-file" name="file" required />
            </div>
            <div class="d-grid">
              <button class="btn btn-primary btn-block" type="submit" id="submit" >Yükle</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row justify-content-center info-message d-none ">
        <div class="alert alert-success mt-5 col-8" role="alert">
          <h4 class="alert-heading">Well done!</h4>
          <p>Added and non-added records are listed below.</p>
        </div>
      </div>

      <div class="d-flex align-items-start mt-5 result d-none">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active" id="v-pills-success-tab" data-bs-toggle="pill" data-bs-target="#v-pills-success" type="button" role="tab" aria-controls="v-pills-success" aria-selected="true">
            Importend
            <span class="badge bg-success rounded-pill"></span>
          </button>
          <button class="nav-link" id="v-pills-errors-tab" data-bs-toggle="pill" data-bs-target="#v-pills-errors" type="button" role="tab" aria-controls="v-pills-errors" aria-selected="false">
            Not Importent
            <span class="badge bg-danger rounded-pill"></span>
          </button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-success" role="tabpanel" aria-labelledby="v-pills-success-tab" tabindex="0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Csv Row Id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Surname</th>
                  <th scope="col">Email</th>
                  <th scope="col">Employee Id</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Point</th>
                </tr>
              </thead>
              <tbody class="success-body">
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="v-pills-errors" role="tabpanel" aria-labelledby="v-pills-errors-tab" tabindex="0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Csv Row Id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Surname</th>
                  <th scope="col">Email</th>
                  <th scope="col">Employee Id</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Point</th>
                  <th scope="col" style="width:15%;">Errors</th>
                </tr>
              </thead>
              <tbody class="errors-body">
              </tbody>
            </table>
          </div>
            
        </div>
      </div>
    </div>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

    <!-- Ajax JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Example starter JavaScript for disabling form submissions if there are invalid fields -->
    <script>
      (function () {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        const btn = document.querySelector('button');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
              if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
              } else {
                
                const formData = new FormData(this);

                $(".success-body").empty();
                $(".errors-body").empty();
                $(".info-message").addClass('d-none');
                $(".result").addClass('d-none');
           
                $.ajax({
                  url: "{{ route('campaigns.store') }}" ,
                  headers: {
                    'X-CSRF-CONTENT': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: "POST",
                  enctype: 'multipart/form-data',
                  dataType: 'json',
                  processData: false,
                  contentType: false,
                  data: formData,
                  cache: false,
                  success: function( response ) {

                    let importend = response.importend;
                    let notImportend = response.notImportend;

                    
                    $.each( importend, function( key, value ) {
                      let rowId = '<th scope="row">' + value.data.row_id + '</th>';
                      let name = '<td>' + value.data.name + '</td>';
                      let sureName = '<td>' + value.data.surname + '</td>';
                      let email = '<td>' + value.data.email + '</td>';
                      let employeeId = '<td>' + value.data.employee_id + '</td>';
                      let phone = '<td>' + value.data.phone + '</td>';
                      let point = '<td>' + value.data.point + '</td>';
                      $(".success-body").append('<tr class="table-success">' + rowId+name+sureName+email+employeeId+phone+point + '</tr>');  
                    });

                    
                    $.each( notImportend, function( key, value ) {
                        let rowId = '<th scope="row">' + value.data.row_id + '</th>';
                        let name = '<td>' + value.data.name + '</td>';
                        let sureName = '<td>' + value.data.surname + '</td>';
                        let email = '<td class="w-25">' + value.data.email + '</td>';
                        let employeeId = '<td>' + value.data.employee_id + '</td>';
                        let phone = '<td>' + value.data.phone + '</td>';
                        let point = '<td>' + value.data.point + '</td>';
                        let validErrors;
                        $.each( value.errors, function( key, value ) {
                          validErrors += '<td>' + value[0] + '</td>';
                        });
                        
                        $(".errors-body").append('<tr class="table-danger">' + rowId+name+sureName+email+employeeId+phone+point+validErrors + '</tr>');  
                    });

                    $('.import-form')[0].reset();
                    $(".import-form").removeClass('was-validated');
                    $(".alert-danger").empty();
                    $(".alert-danger").addClass('d-none');
                    $(".result").removeClass('d-none');
                    $(".info-message").removeClass('d-none');
                    
                    $(".bg-success.rounded-pill").html(response.importend.length);
                    $(".bg-danger.rounded-pill").html(response.notImportend.length);
             
                  },
                  error: function( jqXHR, textStatus, errorThrown ) {
                    let response = jqXHR.responseJSON;
                    let errors = response.errors;

                    $(".alert-danger").removeClass('d-none');
                    $(".alert-danger").empty();
                    $.each( errors, function( key, value ) {
                        $(".alert-danger").append('<li>' + value[0] + '</li>');  
                    });
                  }

                });
              }

              form.classList.add('was-validated');
            }, false);
          });
      })();
    </script>

  </body>
</html>

