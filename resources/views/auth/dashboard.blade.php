


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <a class="navbar-brand" href="{{ URL('/') }}"> Login Register</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                @else    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            >Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                        </ul>
                    </li>
                @endguest
            </ul>
          </div>
        </div>
    </nav>    

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="pdf">Upload PDF:</label>
                                <input type="file" class="form-control-file" id="pdf" name="pdf">
                            </div>
                            <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
                        </form>
                    </div>
    
                    <div class="card-body">
                        <h2>PDF Files</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Original Name</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($Files as $File)
                                    <tr>
                                        <td>{{$File->file_name}}</td>
                                         <td>
                                            <a href="{{url('download/'.$File->id)}}" class="btn btn-primary">dounload</a>
                                        
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        No PDF Found
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                    @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <script>
        $(document).ready(function(){
            $('#uploadBtn').click(function(){
                uploadPdf();
            });

        
            function uploadPdf(){
                var formData = new FormData();
                var fileInput = document.getElementById('pdf');
                var file = fileInput.files[0];
                formData.append('pdf', file);
                formData.append('_token', '{{ csrf_token() }}');
        
               
                $.ajax({
                    url: "{{ url('/uploadpdf') }}", 
                    type: "POST", 
                    data: formData, 
                    contentType: false, 
                    processData: false, 
                    success: function(response){ 

                        alert(response.message); // Show success message
                        window.location.reload();
                    },
                    error: function(xhr, status, error){ // Function to handle error response
                        console.error(xhr.responseText); // Log error message to console
                    }
                });
            }
        });
        </script>

       
  </body>
</html>