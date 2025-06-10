<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset("assets/js/plugin/webfont/webfont.min.js") }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});

	</script>
    <!-- CSS Background Image -->
<style>
	.bg-image {
		background-image: url('/assets/img/logocakdhi.png');
		background-size: cover;
		background-position: center;
	}
</style>
    <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{ asset("assets/css/atlantis.css")}}">
</head>
<body>
    <div class="login">
        <div class="wrapper wrapper-login wrapper-login-full p-0">
            <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-image">
                {{-- <h1 class="title fw-bold text-white mb-3">Join Our Comunity</h1>
                <p class="subtitle text-white op-7">Ayo bergabung dengan komunitas kami untuk masa depan yang lebih baik</p> --}}
            </div>

            <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-succes">
                <div class="container container-login container-transparent animated fadeIn">
                    <h3 class="text-center">Sign In To Admin</h3>
                    <form  method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="placeholder"><b>Username</b></label>
                            <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="placeholder"><b>Password</b></label>
                            <div class="position-relative">
                                <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                <div class="show-password">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-action-d-flex mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                            </div>
                            <button type="submit" class="btn btn-secondary col-md-5 float-right mt-3 mt-sm-0 fw-bold">{{ __('Login') }}</button>


                        </div>
                    </form>
                </div>

                <div class="container container-signup container-transparent animated fadeIn">
                    <h3 class="text-center">Sign Up</h3>
                    <div class="login-form">
                        <div class="form-group">
                            <label for="fullname" class="placeholder"><b>Fullname</b></label>
                            <input  id="fullname" name="fullname" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="placeholder"><b>Email</b></label>
                            <input  id="email" name="email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordsignin" class="placeholder"><b>Password</b></label>
                            <div class="position-relative">
                                <input  id="passwordsignin" name="passwordsignin" type="password" class="form-control" required>
                                <div class="show-password">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword" class="placeholder"><b>Confirm Password</b></label>
                            <div class="position-relative">
                                <input  id="confirmpassword" name="confirmpassword" type="password" class="form-control" required>
                                <div class="show-password">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row form-sub m-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                                <label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
                            </div>
                        </div>
                        <div class="row form-action">
                            <div class="col-md-6">
                                <a href="#" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancel</a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-secondary w-100 fw-bold">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("assets/js/core/jquery.3.2.1.min.js")}}"></script>
	<script src="{{ asset("assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/popper.min.js")}}"></script>
	<script src="{{ asset("assets/js/core/bootstrap.min.js")}}"></script>
	<script src="{{ asset("assets/js/atlantis.min.js")}}"></script>
</body>
</html>
