<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Max Delivery Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" >
    
    <div class="container" >
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <h1 style="color: whitesmoke"><div class="panel-heading">Register</div></h1>
                    <div class="panel-body" >
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}
    
                            {{-- <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                                <label style="color: whitesmoke" for="name" class="col-md-4 control-label">FullName</label>

                                
                                <div class="col-md-6">
                                    <input  id="fullname" type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" required autofocus>
    
                                    @if ($errors->has('fullname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fullname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> --}}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label style="color: whitesmoke" for="username" class="col-md-4 control-label">Username</label>
    
                                <div class="col-md-6">
                                    <input  id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
    
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <label style="color: whitesmoke" for="name" class="col-md-4 control-label">Name</label>
                            
                            <div class="col-md-6">
                                <input  id="name" type="text" class="form-control" name="name" required autofocus>
                            </div>



                            {{-- <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label  style="color: whitesmoke"  for="email" class="col-md-4 control-label">E-Mail Address</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> --}}
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label  style="color: whitesmoke"  for="password" class="col-md-4 control-label">Password</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
    
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label style="color: whitesmoke" for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" style="color: whitesmoke" for="user_type">Role</label>
                                <div class="col-md-6">
                                <select class="form-control" id="user_type" name="user_type">
                                  <option>Admin</option>
                                  <option>Employee</option>
                                  <option>Driver</option>
                                  <option>Shop</option>
                                </select>
                                </div>
                              </div>


                              <div class="form-group">
                                <label style="color: whitesmoke" for="phone_number" class="col-md-4 control-label">Phone number</label>
    
                                <div class="col-md-6">
                                    <input id="phone_number" type="text" class="form-control" name="phone_number">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src= {{URL::to ("js/sb-admin-2.min.js")}}></script>

</body>

</html>