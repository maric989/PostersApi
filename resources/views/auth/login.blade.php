@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <input id="client_id" type="hidden" class="form-control" name="client_id" value="{{ env('client_id') }}">
                    <input id="client_secret" type="hidden" class="form-control" name="client_secret" value="{{ env('client_secret') }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                            <div class="col-md-8 col-md-offset-4">
                                <button id="subbmit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function() {
            $('#subbmit').on('click', function () {
                var username = $('#email').val();
                var password = $('#password').val();
                var client_id = $('#client_id').val();
                var client_secret = $('#client_secret').val();
                var type = 'password';

                $.ajax({
                    url:"/oauth/token",
                    method: "POST",
                    data: {
                        username: username,
                        password: password,
                        grant_type: type,
                        client_id : client_id,
                        client_secret: client_secret
                    },
                    contentType: " application/x-www-form-urlencoded",
                    dataType: "json",
                    success: function(data) {
//                        console.log(data);
                        sessionStorage.setItem("token",data.access_token);
                        var token = "Bearer "+ sessionStorage.getItem("token");
                        $.ajax({
                           url: "/api/user",
                           method: "GET",
                            headers: {
                                "Authorization": token
                            },
                            success: function (data) {
                                sessionStorage.setItem("userID",data.id);
                                window.location.href = 'http://localhost:8000/';
                            }
                        });
                    },
                    error: function(ts) {
                        alert(ts.responseText) }

                });

            });
        });
    </script>
@endsection
