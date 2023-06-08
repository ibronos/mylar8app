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

      		<form method="post" action="{{ route('purchasing.store') }}" enctype="multipart/form-data">
      			@csrf
				<div class="card">				
					  <div class="card-header">Add Purchasing</div>
					  <div class="card-body">

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Date</label>
						    <div class="col-sm-10">
						      <div class="input-group date" data-provide="datepicker">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
						        </div>
						        <input type="text" class="form-control" name="date" id="date" required>
						      </div>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">PO No</label>
						    <div class="col-sm-10">
							 	<input type="text" class="form-control" name="po_no" id="po_no" required>
						    </div>
						  </div>


  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Order</label>
						    <div class="col-sm-10">
							 	<select class="form-control" name="id_order">
							 		@foreach( $order as $row )
							 		<option value="{{ $row->id }}"> {{ $row->code }}</option>
							 		@endforeach
							 	</select>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style</label>
						    <div class="col-sm-10">
							 	<select class="form-control" name="id_style">
							 		@foreach( $style as $row )
							 		<option value="{{ $row->id }}"> {{ $row->name }}</option>
							 		@endforeach
							 	</select>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Supplier</label>
						    <div class="col-sm-10">
							 	<select class="form-control" name="id_supplier">
							 		@foreach( $supplier as $row )
							 		<option value="{{ $row->id }}"> {{ $row->name }}</option>
							 		@endforeach
							 	</select>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Description</label>
						    <div class="col-sm-10">
								<textarea class="form-control" name="description" rows="3" required=""></textarea>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Payment Terms</label>
						    <div class="col-sm-10">
								<textarea class="form-control" name="payment_terms" rows="3" required=""></textarea>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Status</label>
						    <div class="col-sm-10">
							 	<select class="form-control" name="status">
							 		<option value="CANCEL"> CANCEL </option>
							 		<option value="PAID"> PAID </option>
							 		<option value="PAID50%"> PAID 50% </option>
							 		<option value="UNPAID"> UNPAID </option>
							 	</select>
						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Arrive</label>
						    <div class="col-sm-10">
							 	<select class="form-control" name="arrival_status">
							 		<option value="y"> Yes </option>
							 		<option value="n"> No </option>
							 	</select>
						    </div>
						  </div>

						  <input type="hidden" name="type" value="local">  

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Material Name</label>
						    <div class="col-sm-10">
							 	<input type="text" class="form-control" name="material_name" id="material_name" required>
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
				            <a href="{{ route('purchasing.index') }}" class="btn btn-sm btn-primary">
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

      <script type="text/javascript">
      	$("#date").datepicker("setDate", new Date());
      </script>
@endsection