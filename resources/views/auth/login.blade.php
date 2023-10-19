@extends('layouts.app')
@section('content')
<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="page">
	<div class="page-single">
		<div class="container">
			<div class="row">
				<div class="col mx-auto">
					<div class="text-center mb-6">
						<img src="{{asset('mootek/images/home.jpg')}}" class="desktop-lgo" alt="Clont logo" style="max-width: 165px;">
					</div>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<div class="card-group mb-0">
								<div class="card p-4">
									<div class="card-body">
										<h1>Welcome to Mootek!</h1>
										<p class="text-muted">Please sign-in to your account</p>
										<form method="POST" action="{{ route('login') }}">
										@csrf
											<div class="input-group mb-3">
												<span class="input-group-addon"><i class="fa fa-user"></i></span>
												<input id="email" type="text" placeholder="User Name" value="" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
												@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
											<div class="input-group mb-3">
												<span class="input-group-addon"><i class="fa fa-lock"></i></span>
												<input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
			 									<span class="input-group-text togglePassword " >
												 <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
												@error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>


											<div class="input-group mb-3">
												<div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
												@if ($errors->has('g-recaptcha-response'))
													<span class="invalid-feedback" style="display:block" role="alert">
														<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
													</span>
												@endif
											</div>


											<div class="input-group mb-4">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

													<label class="form-check-label" for="remember">
														{{ __('Remember Me') }}
													</label>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<button type="submit" class="btn btn-block logo">
													{{ __('Login') }}
													</button>
												</div>

												<div class="col-12">
													<a href="{{ route('forgot.password.get') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Forgot Your Password?') }}</a>
												</div>

											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php ?>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).on('click', '.togglePassword', function() {


var input = $("#password");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
if(input.attr('type') === 'password'){
	$('.togglePassword>i').removeClass("fa fa-eye");
	$('.togglePassword>i').addClass("fa fa-eye-slash");

}else{
	$('.togglePassword>i').removeClass("fa fa-eye-slash");
	$('.togglePassword>i').addClass("fa fa-eye");

}
});


</script>
