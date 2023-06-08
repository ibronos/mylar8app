@extends('admin.layout.main')
@section('content')

          <div class="row">
          	<div class="col-md-12">
          		@if(session('success'))
				    <div class="alert alert-warning alert-dismissible fade show" role="alert">
					  <strong>{{session('success')}}</strong>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@endif
				
	          	<div class="card">
				  <div class="card-header">
	              	  <div class="d-sm-flex align-items-center justify-content-between">
			            <h1 class="h3 mb-0 text-gray-800">Roles</h1>
			            <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Role
			            </a>
			          </div>
				  </div>
				  <div class="card-body">
			           <table class="table table-bordered table-sm">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Role Name</th>
						      <th scope="col">Slug</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <th scope="row"> {{ $loop->index+1 }} </th>
						      <td>{{ $row->name }}</td>
						       <td>{{ $row->slug }}</td>
						      <td>
							  	<form method="post" action="{{ route('role.destroy', $row->id) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
									<a href="{{ route('role.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
									<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it?');">Delete</button>
									</div>
								</form>				      	
						      </td>
						    </tr>
						    @endforeach
						</tbody>
						</table>
						
				  </div>
				  <div class="card-footer">
				  	{!! $data->links() !!}
				  </div>
				</div>
          	</div>




          </div>
@endsection