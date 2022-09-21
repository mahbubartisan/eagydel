<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="auth-layout-wrap" style="background-image: url({{ asset('backend/assets/images/photo-wide-4.jpg') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{ asset('backend/assets/images/logo.png') }}" alt="">
                            </div>
                            <h1 class="mb-3 text-18">Sign In</h1>
                            <form method="POST" action="{{ isset($guard) ? url($guard.'/login') : route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-rounded">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-rounded">
                                </div>
                                <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>

                            </form>

                            <div class="mt-3 text-center">
                                <a href="{{ route('password.request') }}" class="text-muted"><u>Forgot Password?</u></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center" style="background-size: cover;background-image: url(assets/images/photo-long-3.jpg)">
                        <div class="pr-3 auth-right">
                            <a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="signup.html">
                                <i class="i-Mail-with-At-Sign"></i> Sign up with Email
                            </a>
                            <a class="btn btn-rounded btn-outline-primary btn-outline-google btn-block btn-icon-text">
                                <i class="i-Google-Plus"></i> Sign up with Google
                            </a>
                            <a class="btn btn-rounded btn-outline-primary btn-block btn-icon-text btn-outline-facebook">
                                <i class="i-Facebook-2"></i> Sign up with Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="{{ asset('backend/assets/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/es5/script.min.js') }}"></script>
</body>
</html>