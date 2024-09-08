@extends('layouts.main')

@section('title')
  Sign Up
@endsection

@section('content')
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
	<div class="modal-content rounded-4 shadow">
	  <div class="modal-header p-5 pb-4 border-bottom-0">
		<h1 class="fw-bold mb-0 fs-2">Sign up for free</h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>

	  <div class="modal-body p-5 pt-0">
			<form action="/signup" method="POST">
				@csrf
				<div class="form-floating mb-3">
					<input type="input" class="form-control rounded-3" name="user_name" value="{{ old('user_name') }}" placeholder="name" required>
					<label for="floatingName">Your Name</label>
					@if (!empty($name_errors))
						@foreach ($name_errors as $error)
							<div class="alert alert-danger" role="alert">
								{{ $error }}
							</div>
						@endforeach
					@endif				
				</div>
				<div class="form-floating mb-3">
					<input type="email" class="form-control rounded-3" name="email" value="{{ $email ?? old('email') }}" placeholder="name@example.com">
					<label for="floatingInput">Email address</label>
					@if (!empty($email_errors))
						@foreach ($email_errors as $error)
							<div class="alert alert-danger" role="alert">
								{{ $error }}
							</div>
						@endforeach
					@endif
				</div>
				<button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign up</button>
				<small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
				<hr class="my-4">
			</form>
	  </div>
	</div>
  </div>
</div>
@endsection