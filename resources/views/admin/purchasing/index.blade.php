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
			            <h1 class="h3 mb-0 text-gray-800">Purchasing</h1>
			            <a href="{{ route('purchasing.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Purchasing
			            </a>
			          </div>
				  </div>
				  <div class="card-body">

	<!-- 				<form  method="GET" action="{{ route('purchasing.search') }}">
						  
						  <div class="form-row">
						    <div class="col-10">
						      <input type="text" name="word" class="form-control" value="{{ $word ?? '' }}">
						    </div>
						    <div class="col-2">
	      					    <div class="input-group-btn">
							      <button class="btn btn-success" type="submit">
							        <i class="fa fa-search"></i> Search
							      </button>
							      <a href="{{ route('purchasing.index') }}" type="button" class="btn btn-secondary">Clear</a>
						    	</div>
						    </div>
						  </div>
					</form> -->


				  	<p>
					  <button class="btn btn-warning btn-sm" type="button" data-toggle="collapse" data-target="#searchCollapse" aria-expanded="false" aria-controls="collapseExample">
					    Advanced Search
					  </button>
					</p>
					<div class="collapse mb-2" id="searchCollapse">
					  <div class="card card-body">
	    					<form  method="GET" action="{{ route('purchasing.search') }}" class="mb-0">
								  <div class="form-group row">
								    <div class="col-10">
								      <input type="text" name="word" class="form-control form-control-sm" value="{{ $word ?? '' }}">
								    </div>
								    <div class="col-2">
			      					    <div class="btn-group  btn-group-sm" role="group">
									      <button class="btn btn-success btn-sm" type="submit">
									        <i class="fa fa-search"></i> Search
									      </button>
									      <a href="{{ route('purchasing.index') }}" type="button" class="btn btn-secondary btn-sm">Clear</a>
								    	</div>
								    </div>
								  </div>
							</form>
					  </div>
					</div>


			           <table class="table table-bordered table-sm" id="tabel-data">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">Date</th>
						      <th scope="col">No PO</th>
						      <th scope="col">Month</th>
						      <th scope="col">Order</th>
						      <th scope="col">Description</th>
						      <th scope="col">Supplier Name</th>
						      <th scope="col">Paid</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <td>{{ $row->date }}</td>
						      <td>{{ $row->po_no }}</td>
						      <td>{{ $row->month }}</td>
						      <td>{{ $row->order_code }}</td>
						      <td>{{ $row->description }}</td>
						      <td>{{ $row->supplier_name }}</td>
						      <td>{{ $row->status }}</td>

						      <td>
							  	<form method="post" action="{{ route('purchasing.destroy', $row->id) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
										<input type="button" data-toggle="modal" data-target="#modal-{{$row->id}}" value="Show" class="btn btn-info btn-sm btn-show" data-id="{{ $row->id }}">
										<a href="{{ route('purchasing.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
										<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it?');">Delete</button>
									</div>
								</form>				      	
						      </td>
						    </tr>
						    @endforeach
						</tbody>
						</table>
						
				  </div>
				  <div class="card-footer">{{-- {!! $data->links() !!} --}} </div>
				</div>
          	</div>


          	<!-- Modal -->
          	@foreach($data as $dt)
				<div class="modal fade" id="modal-{{$dt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
				  <div class="modal-dialog modal-xl" role="document">
				    <div class="modal-content">
				      <div class="modal-header bg-info text-white">
				        <h5 class="modal-title" id="exampleModalLongTitle">{{ $dt->po_no }}</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">


						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Date</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label">{{ $dt->date }}</label>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">PO No</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label">{{ $dt->po_no }}</label>
						    </div>
						  </div>


  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Order</label>
						    <div class="col-sm-10">
								<label class="col-form-label">{{ $dt->order_code }}</label>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label">{{ $dt->style_name }}</label>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Supplier</label>
						    <div class="col-sm-10">
							 	<label class="col-form-label">{{ $dt->supplier_name }}</label>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Description</label>
						    <div class="col-sm-10">
								<label class="col-form-label">{{ $dt->description }}</label>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Payment Terms</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label">{{ $dt->payment_terms }}</label>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Status</label>
						    <div class="col-sm-10">
								<label class="col-form-label">{{ $dt->status }}</label>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Arrive</label>
						    <div class="col-sm-10">
								<label class="col-form-label">{{ $dt->purchase_arrival_status = 'y' ? 'Yes' : No }}</label>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Material Name</label>
						    <div class="col-sm-10">
							 	<label class="col-form-label"> {{ $dt->material_name }} </label>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Code</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label"> {{ $dt->code }} </label>
						    </div>
						  </div>



						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Quantity</label>
						    <div class="col-sm-10">
						      <label class="col-form-label"> {{ $dt->quantity }} </label>
						    </div>
						</div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Specs</label>
						    <div class="col-sm-10">
						      <label class="col-form-label"> {{ $dt->specs }} </label>
						    </div>
						</div>

	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label">Unit</label>
						    <div class="col-sm-10">
						    	<label class="col-form-label"> {{ $dt->unit }} </label>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Color</label>
						    <div class="col-sm-10">
						      <label class="col-form-label"> {{ $dt->color }} </label>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">AWB/Resi</label>
						    <div class="col-sm-10">
						      <label class="col-form-label"> {{ $dt->awb }} </label>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Origin</label>
						    <div class="col-sm-10">
						      <label class="col-form-label"> {{ $dt->origin }} </label>
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