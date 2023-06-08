@extends('admin.layout.main')
@section('content')
      <div class="row">
      	<div class="col-md-12">
      		@if ($errors->any())
			    <div class="alert alert-danger alert-dismissible fade show" role="alert">
				  	<ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif

      		@if(session('success'))
			    <div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <strong>{{session('success')}}</strong>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif
			
				<div class="card">				
					  <div class="card-header">User Profile</div>
					  <div class="card-body">
			                        <div class="form-group row">
			                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

			                            <div class="col-md-6">
			                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" disabled autofocus>
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

			                            <div class="col-md-6">
			                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" disabled>

			                                @error('email')
			                                    <span class="invalid-feedback" role="alert">
			                                        <strong>{{ $message }}</strong>
			                                    </span>
			                                @enderror
			                            </div>
			                        </div>

                              		<form method="post" action="{{ route('user.update_password', Auth::user()->id) }}" enctype="multipart/form-data">
						      			@csrf
						                
				                        <div class="form-group row">
				                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Change Password') }}</label>

				                            <div class="col-md-6">
				                            	<input type="password" name="old_password" class="form-control mb-1" placeholder="Old Password">
				                            	<input type="password" name="new_password" class="form-control mb-1" placeholder="New Password">
				                            	<input type="password" name="new_confirm_password" class="form-control mb-1" placeholder="Repeat New Password">
				                                <input type="submit" value="Change Password" class="btn btn-success btn-sm">
				                            </div>
				                        </div>
			                        </form>		
					  </div>

				</div>		
			

      	</div>
      </div>
@endsection