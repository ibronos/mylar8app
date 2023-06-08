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
			
      		<form method="post" action="{{ route('role.update', $data->id) }}" enctype="multipart/form-data">
      			@csrf
                @method('PATCH')
				<div class="card">				
					  <div class="card-header">Edit Role</div>
					  <div class="card-body">
						<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name">
						    </div>
						</div>
						<div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->slug }}" name="slug" id="slug">
						    </div>
						</div>
					  </div>
					  <div class="card-footer text-right">
				            <a href="{{ route('role.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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