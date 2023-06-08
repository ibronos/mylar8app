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

      		<form method="post" action="{{ route('inventory.update', $data->id) }}" enctype="multipart/form-data">
      			@csrf
                @method('PATCH')
				<div class="card">				
					  <div class="card-header">Edit Import</div>
						  <div class="card-body">

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Type</label>
						    <div class="col-sm-10">
	 						      <select class="form-control" name="type">
									  <option value="import" @if($data->unit == 'import') selected @endif >Import</option>
									  <option value="local" @if($data->unit == 'local') selected @endif >Local</option>
								  </select>
						    </div>
						  </div>  

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Material Name</label>
						    <div class="col-sm-10">
							 	<input type="text" class="form-control" value="{{ $data->material_name }}" name="material_name" id="material_name">
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Code</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->code }}" name="code" id="code">
						      <small>(Kode) / (No WH) / (No Rak) / (Material Name) / (Material Kind) / (Color)</small>
						    </div>
						  </div>



						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Quantity</label>
						    <div class="col-sm-10">
						      <input type="number" class="form-control" value="{{ $data->quantity }}" name="quantity" id="quantity">
						    </div>
						</div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Specs</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->specs }}" name="specs" id="specs">
						    </div>
						</div>

	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label">Unit</label>
						    <div class="col-sm-10">
						      <select class="form-control" name="unit">
						      	  <option value="null" @if($data->unit == 'null') selected @endif >-- Choose Option --</option>
								  <option value="sqf" @if($data->unit == 'sqf') selected @endif >SQF</option>
								  <option value="m" @if($data->unit == 'm') selected @endif >M</option>
								  <option value="pcs" @if($data->unit == 'pcs') selected @endif >PCS</option>
								  <option value="pair" @if($data->unit == 'pair') selected @endif >PAIR</option>
								  <option value="mm" @if($data->unit == 'mm') selected @endif >MM</option>
								  <option value="sheet" @if($data->unit == 'sheet') selected @endif >SHEET</option>
								  <option value="yard" @if($data->unit == 'yard') selected @endif >YARD</option>
								  <option value="box" @if($data->unit == 'box') selected @endif >BOX</option>
								  <option value="pack" @if($data->unit == 'pack') selected @endif >PACK</option>
							  </select>
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Color</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->color }}" name="color" id="color">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">AWB/Resi</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->awb }}" name="awb" id="awb">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Origin</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->origin }}" name="origin" id="origin">
						    </div>
						</div>
					  </div>

					  <div class="card-footer text-right">
				            <a href="{{ route('inventory.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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