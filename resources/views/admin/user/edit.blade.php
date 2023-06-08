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

      		<form method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
      			@csrf
                @method('PATCH')
				<div class="card">				
					  <div class="card-header">Edit User</div>
					  <div class="card-body">
			                        <div class="form-group row">
			                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

			                            <div class="col-md-6">
			                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

			                            <div class="col-md-6">
			                            	<select class="form-control" name="role">
			                            		@foreach($role as $row)
											  		<option value="{{ $row->slug }}" @if($row->slug == $user->role) selected @endif >
											  			{{ $row->name }}
											  		</option>
											  	@endforeach
											</select>
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

			                            <div class="col-md-6">
			                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

			                                @error('email')
			                                    <span class="invalid-feedback" role="alert">
			                                        <strong>{{ $message }}</strong>
			                                    </span>
			                                @enderror
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

			                            <div class="col-md-6">
			                                <a href="{{ route('user.admin_edit_pass', $user->id) }}" type="button" class="btn btn-success btn-sm">Change Password</a>
			                            </div>
			                        </div>
					  </div>
					  <div class="card-footer text-right">
				            <a href="{{ route('user.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i>
				            	Back
				            </a>
				            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
				            	<i class="fas fa-save fa-sm text-white-50"></i> 
				            	Save
				            </button>
					  </div>
				</div>		
			</form>		

      	</div>
      </div>
@endsection