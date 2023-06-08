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
			
      		<form method="post" action="{{ route('supplier.update', $data->id) }}" enctype="multipart/form-data">
      			@csrf
                @method('PATCH')
				<div class="card">				
					  <div class="card-header">Edit Supplier</div>
					  <div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Email</label>
						    <div class="col-sm-10">
						      <input type="email" class="form-control" name="email" id="email" value="{{ $data->email }}">
						    </div>
						  </div>
	                      <div class="form-group row">
                             <label for="inputPassword" class="col-sm-2 col-form-label">Item</label>
                            <div class="col-sm-10">
                            	<select class="form-control" name="id_item">
                            		@foreach($item as $row)
								  		<option value="{{ $row->id }}" @if($row->id == $data->id_item) selected @endif > 
								  			{{ $row->name }}
								  		</option>
								  	@endforeach
								</select>
                            </div>
                        </div>
						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Address</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" value="{{ $data->address }}" name="address" id="address">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="telephone" class="col-sm-2 col-form-label">Contact Person</label>
						    <div class="col-sm-5">
						      <input type="text" class="form-control" name="contact_name" id="telephone" placeholder="Contact Name" value="{{ $data->contact_name }}">
						    </div>
						    <div class="col-sm-5">
						      <input type="text" class="form-control" name="telephone" id="telephone" placeholder="telephone" value="{{ $data->telephone }}">
						    </div>
						</div>
	 				    <div class="form-group row">
						    <label for="bank_number" class="col-sm-2 col-form-label">Bank</label>
						    <div class="col-sm-2">
						    	<input type="text" class="form-control" name="bank_name" id="bank_name"  value="{{ $data->bank_name }}" placeholder="Bank Name">
						    </div>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" name="bank_account_name" id="bank_name" value="{{ $data->bank_account_name }}" placeholder="Account Name">
						    </div>
						    <div class="col-sm-4">
						      <input type="text" class="form-control" name="bank_number" id="bank_number"  value="{{ $data->bank_number }}" placeholder="Bank Number">
						    </div>
						</div>
					  </div>
					  <div class="card-footer text-right">
				            <a href="{{ route('supplier.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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