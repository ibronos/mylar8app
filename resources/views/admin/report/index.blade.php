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
			            <h1 class="h3 mb-0 text-gray-800">Reports</h1>
			          </div>
				  </div>
				  <div class="card-body">

					<form  method="GET" action="{{ route('report.search') }}">
						  
						  <div class="form-row">
						    <div class="col-10">
						      <input type="text" name="word" class="form-control" value="{{ $word ?? '' }}">
						    </div>
						    <div class="col-2">
	      					    <div class="input-group-btn">
							      <button class="btn btn-success" type="submit">
							        <i class="fa fa-search"></i> Search
							      </button>
							      <a href="{{ route('report.index') }}" type="button" class="btn btn-secondary">Clear</a>
						    	</div>
						    </div>
						  </div>
					</form>

			           <table class="table table-bordered table-sm">
						  <thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Order Code</th>
						      <th scope="col">List Style</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $row)
						    <tr>
						      <th scope="row"> {{ $loop->index+1 }} </th>
						      <td>{{ $row->code }}</td>
						      <td> <a href="{{ route('report.list_style', $row->id) }}"> See List Style </a> </td>
						    </tr>
						    @endforeach
						</tbody>
						</table>
						
				  </div>
				  <div class="card-footer">{!! $data->links() !!}</div>
				</div>
          	</div>




          </div>
@endsection