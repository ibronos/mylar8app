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

      		<form method="post" action="{{ route('order.update', $data->id) }}" enctype="multipart/form-data">
      			@csrf
      			@method('PATCH')
				<div class="card">				
				    <div class="card-header">Edit Order</div>
				  	<div class="card-body">
					  <div class="form-group row">
					    <label for="name" class="col-sm-2 col-form-label">Order Code</label>
					    <div class="col-sm-10">
					      <input type="text" class="form-control" name="code" id="code" value="{{ $data->code }}" required>
					    </div>
					  </div>
  					  <div class="form-group row">
					    <label for="name" class="col-sm-2 col-form-label">Style</label>
					    <div class="col-sm-10">
							<div class="overflow-auto">
							  	@foreach ($style ?? ''  as $row)
								<div class="form-check">
								  <input class="form-check-input" type="checkbox" name="style[]" value="{{ $row->id }}" id="style-{{ $row->id }}" @if($row->checked == 'y') checked @endif>
								  <label class="form-check-label" for="style-{{ $row->id }}">
								    {{ $row->name }}
								  </label>
								</div>
							    @endforeach
							 </div>
					    </div>
					  </div>
					</div>  
					  <div class="card-footer text-right">
				            <a href="{{ route('order.index') }}" class="btn btn-sm btn-primary">
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