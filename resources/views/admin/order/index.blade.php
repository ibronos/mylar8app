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
			            <h1 class="h3 mb-0 text-gray-800">Orders</h1>
			            @can('access-production')
			            <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Order
			            </a>
			            @endcan
			          </div>
				  </div>
				  <div class="card-body">

					<form  method="GET" action="{{ route('order.search') }}">
						  
						  <div class="form-row">
						    <div class="col-10">
						      <input type="text" name="word" class="form-control" value="{{ $word ?? '' }}">
						    </div>
						    <div class="col-2">
	      					    <div class="input-group-btn">
							      <button class="btn btn-success" type="submit">
							        <i class="fa fa-search"></i> Search
							      </button>
							      <a href="{{ route('order.index') }}" type="button" class="btn btn-secondary">Clear</a>
						    	</div>
						    </div>
						  </div>
					</form>

			           <table class="table table-bordered table-sm">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Order Code</th>
						      <th scope="col">Details</th>
						      @can('access-production')
						      <th scope="col">Action</th>
						      @endcan
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <th scope="row"> {{ $loop->index+1 }} </th>
						      <td>{{ $row->code }}</td>
						      <td> 
						      	@if ($row->style_exist)
						      	<a href="{{ route('order.show', $row->id) }}"> Show Details </a>
						      	@else
						      	<p>No Style Added </p>
						      	@endif 
						      </td>
						      @can('access-production')
						      <td>
							  	<form method="post" action="{{ route('order.destroy', $row->id) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
									<a href="{{ route('order.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
									<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it?');">Delete</button>
									</div>
								</form>				      	
						      </td>
						      @endcan
						    </tr>
						    @endforeach
						</tbody>
						</table>
						
				  </div>
				  <div class="card-footer">{!! $data->links() !!}</div>
				</div>
          	</div>




          </div>
@endsection