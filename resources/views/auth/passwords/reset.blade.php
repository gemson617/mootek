@extends('layouts.app')

@section('content')
<div class="page">
    <div class="container text-center">
        @if (session('msg'))
        <div class="alert alert-success" role="alert">
            {{ session('msg') }}
        </div>
        @endif
        @if(count($errors) > 0)
                                @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                                @endforeach
                                @endif
    </div>

	<div class="page-single">
		<div class="container">
			<div class="row">
				<div class="col mx-auto">
					<div class="text-center mb-6">
						<img width="133px" src="{{ asset('teamwork/images/512 x512.png') }}" class="desktop-lgo" alt="Clont logo">
					</div>
					<div class="row justify-content-center">
						<div class="col-md-8">
							<div class="card">
								<div class="card-header">{{ __('Reset Password') }}</div>

								<div class="card-body">
									<form method="get" action="{{ route('reset.password.post')}}">
										@csrf

                                        @if (Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('fail')}}
                                        </div>
                                        @endif

                                        @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success')}}
                                        </div>
                                    @endif

                                    <input type="hidden" name="_token" value="{{ $token}}">



                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror " name="email" value="{{ $email ?? $request->input('email')}}" required  >
                                        </div>
                                        @error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" value="{{ old('email') }}" required  >
                                        </div>
                                        @error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end  @error('password') is-invalid @enderror"
                                        name="password_confirmation" value="" required>Confirm Password</label>

                                        <div class="col-md-6">

                                            <input id="password_confirmation" type="password" class="form-control " name="password_confirmation" value="{{ old('email') }}" required  autofocus>
                                            <span class="text-danger">@error('password_confirmation'){{ $message}}@enderror</span>
                                        </div>

                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
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
@endsection
