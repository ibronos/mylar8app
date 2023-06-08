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
			            <h1 class="h3 mb-0 text-gray-800">Suppliers</h1>
			            <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Supplier
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
	    					<form  method="GET" action="{{ route('supplier.search') }}" class="mb-0">
								  <div class="form-group row">
								    <div class="col-10">
								      <input type="text" name="word" class="form-control form-control-sm" value="{{ $word ?? '' }}">
								    </div>
								    <div class="col-2">
			      					    <div class="btn-group  btn-group-sm" role="group">
									      <button class="btn btn-success btn-sm" type="submit">
									        <i class="fa fa-search"></i> Search
									      </button>
									      <a href="{{ route('supplier.index') }}" type="button" class="btn btn-secondary btn-sm">Clear</a>
								    	</div>
								    </div>
								  </div>
							</form>
					  </div>
					</div>

			           <table class="table table-bordered table-sm" id="tabel-data">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">Name</th>
						      <th scope="col">Item</th>
						      <th scope="col">Contact Name</th>
						      <th scope="col">Phone</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <td>{{ $row->name }}</td>
						      <td>{{ $row->item_name }}</td>
						      <td>{{ $row->contact_name }}</td>
  						      <td>{{ $row->telephone }}</td>
						      <td>
							  	<form method="post" action="{{ route('supplier.destroy', $row->id) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
									<input type="button" data-toggle="modal" data-target="#modal-{{$row->id}}" value="Show" class="btn btn-info btn-sm btn-show" data-id="{{ $row->id }}">
									<a href="{{ route('supplier.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
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
			        <h5 class="modal-title" id="exampleModalLongTitle">{{ $dt->name }}</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label font-weight-bold">Email</label>
						    <div class="col-sm-10">
						      <label class="col-form-label">{{ $dt->email }}</label>
						      
						    </div>
						  </div>
	                      <div class="form-group row">
                             <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">Item</label>
                            <div class="col-sm-10">
                            	<label class="col-form-label">{{ $dt->item_name }}</label>
                            </div>
                        </div>
						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label font-weight-bold">Address</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label">{{ $dt->address }}</label>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label font-weight-bold">Contact Person</label>
						    <div class="col-sm-10">
						    	<table class="table table-sm table-bordered">
						    		<tr>
						    			<th style="width:20%">Name</th>
						    			<td>{{ $dt->contact_name }}</td>
						    		</tr>
						    		<tr>
						    			<th>Phone</th>
						    			<td>{{ $dt->telephone }}</td>
						    		</tr>
						    	</table>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label font-weight-bold">Bank</label>
						    <div class="col-sm-10">
						    	<table class="table table-sm table-bordered">
						    		<tr>
						    			<th  style="width:20%">Bank Name</th>
						    			<td>{{ $dt->bank_name }}</td>
						    		</tr>
						    		<tr>
						    			<th>Account Name</th>
						    			<td>{{ $dt->bank_account_name }}</td>
						    		</tr>
						    		<tr>
						    			<th>Account Number</th>
						    			<td>{{ $dt->bank_number }}</td>
						    		</tr>
						    	</table>
						    </div>
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