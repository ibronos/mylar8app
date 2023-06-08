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

      
				<div class="card">				
				    <div class="card-header">Detail of Order : {{$data->code}} </div>
				  	<div class="card-body">

						<table class="table table-sm">
						  <thead>
						    <tr>
						      <th scope="col">Style</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach ($data_style  as $row)
						    <tr>
						      <td>{{ $row->name }}</td>
						      <td>
						      	<div class="btn-group" role="group" aria-label="Basic example">
									<a class="btn btn-info btn-sm" href="{{ route('order.edit_style', $row->id_ols) }}">Edit Size Run</a>
									<a class="btn btn-danger btn-sm" href="{{ route('report.show', $row->id_ols) }}">Report</a>
								</div>
						      </td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>


					</div>  
					  <div class="card-footer text-right">
				            <a href="{{ route('order.index') }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
					  </div>
				</div>		
			
      	</div>
      </div>

      


@endsection