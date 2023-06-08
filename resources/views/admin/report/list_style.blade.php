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
			            <h1 class="h3 mb-0 text-gray-800">List Style For Order : <strong>{{ $data->code }}</strong> </h1>
			          </div>
				  </div>
				  <div class="card-body">
			           <table class="table table-bordered table-sm">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Style Code</th>
						      <!-- <th scope="col">Image</th> -->
						      <th scope="col">Details</th>
						    </tr>
						  </thead>
						  <tbody>
							@foreach($data_style as $row)
						    <tr>
						      <th scope="row"> {{ $loop->index+1 }} </th>
						      <td>{{ $row->style_code }}</td>
<!-- 						      <td>
	             	 				<ul class="list-group list-group-horizontal-sm border-0">
									  	@foreach($row->image as $img)
										<li class="list-group-item">
									      <img class="img-thumbnail" width="100" height="100" src='{{ asset("storage/images/$img->image") }}' alt="{{ $img->image }}">
										</li>
									    @endforeach
									</ul>
						      </td> -->
						      <td> <a href="{{ route('report.show_style', $row->id) }}"> Show Details </a> </td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
				  </div>
				  <div class="card-footer">
				  	<div class="d-flex justify-content-between">
				  		<span>{!! $data_style->links() !!}</span>		
				  		<span>	            
				  			<a href="{{ route('report.index') }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
				        </span>
				  	</div>
				  </div>
				</div>
          	</div>




          </div>
@endsection