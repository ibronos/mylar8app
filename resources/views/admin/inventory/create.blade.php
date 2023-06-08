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

      		<form method="post" action="{{ route('inventory.store') }}" enctype="multipart/form-data">
      			@csrf
				<div class="card">				
					  <div class="card-header">Add Inventory</div>
					  <div class="card-body">

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Type</label>
						    <div class="col-sm-10">
	 						      <select class="form-control" name="type">
									  <option value="import">Import</option>
									  <option value="local">Local</option>
								  </select>
						    </div>
						  </div>  

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Material Name</label>
						    <div class="col-sm-10">
							 	<input type="text" class="form-control" name="material_name" id="material_name">
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Code</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="code" id="code">
						      <small>(Code) / (No WH) / (No Rack) / (Material Name) / (Material Type) / (Color)</small>
						    </div>
						  </div>



						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Quantity</label>
						    <div class="col-sm-10">
						      <input type="number" class="form-control" name="quantity" id="quantity">
						    </div>
						</div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Specs</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="specs" id="specs">
						    </div>
						</div>

	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label">Unit</label>
						    <div class="col-sm-10">
						      <select class="form-control" name="unit">
						      	  <option value="null">-- Choose Option --</option>
								  <option value="sqf">SQF</option>
								  <option value="m">M</option>
								  <option value="pcs">PCS</option>
								  <option value="pair">PAIR</option>
								  <option value="mm">MM</option>
								  <option value="sheet">SHEET</option>
								  <option value="yard">YARD</option>
								  <option value="box">BOX</option>
								  <option value="pack">PACK</option>
							  </select>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Color</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="color" id="color">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">AWB/Resi</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="awb" id="awb">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Origin</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="origin" id="origin">
						    </div>
						</div>
					  </div>
					  
					  <div class="card-footer text-right">
				            <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
				            <button type="submit" class="btn btn-sm btn-primary">
				            	<i class="fas fa-save fa-sm text-white-50"></i> 
				            	Save
				            </button>
					  </div>
				</div>		
			</form>		
      	</div>
      </div>
@endsection