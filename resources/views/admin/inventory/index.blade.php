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
			            <h1 class="h3 mb-0 text-gray-800">Inventory</h1>
			            <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Inventory
			            </a>
			          </div>
				  </div>
				  <div class="card-body">

				  	<p>
					  <button class="btn btn-warning btn-sm" type="button" data-toggle="collapse" data-target="#searchCollapse" aria-expanded="false" aria-controls="collapseExample">
					    Advanced Search
					  </button>
					</p>
					<div class="collapse mb-2" id="searchCollapse">
					  <div class="card card-body">
	    					<form  method="GET" action="{{ route('inventory.search') }}" class="mb-0">
								  <div class="form-group row">
								    <div class="col-10">
								      <input type="text" name="word" class="form-control form-control-sm" value="{{ $word ?? '' }}">
								    </div>
								    <div class="col-2">
			      					    <div class="btn-group  btn-group-sm" role="group">
									      <button class="btn btn-success btn-sm" type="submit">
									        <i class="fa fa-search"></i> Search
									      </button>
									      <a href="{{ route('inventory.index') }}" type="button" class="btn btn-secondary btn-sm">Clear</a>
								    	</div>
								    </div>
								  </div>
							</form>
					  </div>
					</div>

			           <table class="table table-bordered table-sm" id="tabel-data">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Name</th>
						      <th scope="col">Type</th>
						      <th scope="col">Code</th>
						      <th scope="col">Specs</th>
						      <th scope="col">Unit</th>
						      <th scope="col">Resi</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <th scope="row"> {{ $loop->index+1 }} </th>
						      <td>{{ $row->material_name }}</td>
						      <td>{{ $row->type }}</td>
						      <td>{{ $row->code }}</td>
						      <td>{{ $row->specs }}</td>
						      <td>{{ $row->unit }}</td>
						      <td>{{ $row->resi }}</td>
						      <td>
							  	<form method="post" action="{{ route('inventory.destroy', $row->id) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
									<input type="button" data-toggle="modal" data-target="#modal-{{$row->id}}" value="Show" class="btn btn-info btn-sm btn-show" data-id="{{ $row->id }}">
									<a href="{{ route('inventory.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
									<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it?');">Delete</button>
									</div>
								</form>				      	
						      </td>
						    </tr>
						    @endforeach
						</tbody>
						</table>
						
				  </div>
				  <div class="card-footer">{{-- {!! $data->links() !!} --}}</div>
				</div>
          	</div>



          	<!-- Modal -->
          	@foreach($data as $dt)
			<div class="modal fade" id="modal-{{$dt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			  <div class="modal-dialog modal-xl" role="document">
			    <div class="modal-content">
			      <div class="modal-header bg-info text-white">
			        <h5 class="modal-title" id="exampleModalLongTitle">{{ $dt->material_name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label font-weight-bold">Type</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->type }}</label>
						  </div>  

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label font-weight-bold">Code</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->code }}</label>
						  </div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label font-weight-bold">Quantity</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->quantity }}</label>
						</div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label font-weight-bold">Specs</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->specs }}</label>
						</div>

	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label font-weight-bold">Unit</label>
						    <label class="col-sm-10 col-form-label"> @if($dt->unit != 'null')  {{ $dt->unit }} @endif</label>
						</div>

	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label font-weight-bold">Color</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->color }}</label>
						</div>

	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label font-weight-bold">AWB/Resi</label>
						    <label class="col-sm-10 col-form-label">{{ $dt->awb }}</label>
						</div>

	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label font-weight-bold">Origin</label>
						     <label class="col-sm-10 col-form-label">{{ $dt->origin }}</label>
						</div>

			      </div>
			      <div class="modal-footer bg-info">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
			@endforeach




          </div>


		<script>
		    $(document).ready(function(){
		        $('#tabel-data').DataTable();
		    });
		</script>
@endsection