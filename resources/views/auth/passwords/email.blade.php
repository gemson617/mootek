@extends('layouts.app')

@section('content')
<div class="page">
	<div class="page-single">
		<div class="container">
			<div class="row">
                <div class="card-body">
                    @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message')}}
                    </div>
                   @endif
				<div class="col mx-auto">
					<div class="text-center mb-5">
						<img width="133px" src="{{ asset('teamwork/images/512 x512.png') }}" class="desktop-lgo" alt="Clont logo">
					</div>
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header ">{{ __('Reset Password') }}</div>



									<form method="POST" action="{{ route('forgot.password.post')}}">

										@csrf

										<div class="row p-5 ">
											<label for="email" class="col-md-4  pl-3">{{ __('Email Address') }}</label>

											<div class="col-md-6  ">
												<input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

												@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>

										<div class="row mb-2 ml-1">
											<div class="col-md-6 offset-md-4">
												<button type="submit" class="btn btn-primary">
													{{ __('Send Password Reset Link') }}
												</button>
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
<script>
     setTimeout(function() {
        $(".alert-danger").slideUp(500);
        $(".alert-success").slideUp(500);
    }, 2000);
</script>
@endsection
