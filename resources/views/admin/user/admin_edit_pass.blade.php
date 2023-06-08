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
					  <div class="card-header">Edit Password for : <strong>{{ $user->name }}</strong></div>
					  <div class="card-body">
                              		<form method="post" action="{{ route('user.admin_update_pass', $user->id ) }}" enctype="multipart/form-data">
						      			@csrf
						                
				                        <div class="form-group row">
				                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Change Password') }}</label>

				                            <div class="col-md-6">
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