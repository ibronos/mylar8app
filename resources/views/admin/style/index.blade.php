@extends('admin.layout.main')
@section('content')
<style type="text/css">
	.modal-body {
    position: relative;
    overflow-y: auto;
    max-height: 400px;
    padding: 15px;
}
</style>

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
	              	  	 <h1 class="h3 mb-0 text-gray-800">Style</h1>
			            <a href="{{ route('style.create') }}" class="btn btn-sm btn-primary shadow-sm">
			            	<i class="fas fa-plus fa-sm text-white-50"></i> 
			            	Add Style
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
	    					<form  method="GET" action="{{ route('style.search') }}" class="mb-0">
								  <div class="form-group row">
								    <div class="col-10">
								      <input type="text" name="word" class="form-control form-control-sm" value="{{ $word ?? '' }}">
								    </div>
								    <div class="col-2">
			      					    <div class="btn-group  btn-group-sm" role="group">
									      <button class="btn btn-success btn-sm" type="submit">
									        <i class="fa fa-search"></i> Search
									      </button>
									      <a href="{{ route('style.index') }}" type="button" class="btn btn-secondary btn-sm">Clear</a>
								    	</div>
								    </div>
								  </div>
							</form>
					  </div>
					</div>

			           <table class="table table-bstyleed table-sm table-bordered" id="tabel-data">
						  <thead class="thead-light">
						    <tr>						      
						      <th scope="col">Style Code</th>
						      <th scope="col">Image</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
							@foreach($data as $row)
						    <tr>
						      <td>{{ $row->name }}</td>
						      <td scope="row">
  							    	<ul class="list-group list-group-horizontal-sm border-0">
									  	@foreach($row->modal_image as $img)
										<li class="list-group-item border-0" >
										  <a href="#" data-toggle="modal" data-target="#imgMod-{{$img->id}}">
										      <img class="img-thumbnail" src='{{ asset("storage/images/$img->image") }}' 
										      alt="{{ $img->image }}"
										      style="float: left; width:  50px; height: 50px; object-fit: cover;" 
										      >
									      </a>
										</li>
									    @endforeach
									</ul>
						      </td>
						      <td>
							  	<form method="post" action="{{ route( 'style.destroy', $row->id  ) }}" enctype="multipart/form-data">
								  @csrf
						    	  @method('delete')
									<div class="btn-group">
									<input type="button" data-toggle="modal" data-target="#modal-{{$row->id}}" value="Show" class="btn btn-info btn-sm btn-show" data-id="{{ $row->id }}">
									<a href="{{ route('style.edit', $row->id) }}" class="btn btn-success btn-sm">Edit</a>
									<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it?');">Delete</button>
									</div>
								</form>				      	
						      </td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
				  </div>
				  <div class="card-footer">
				  	<div class="d-flex justify-content-between">
				  		<span>{{-- {!! $data->links() !!} --}}</span>		
				  		<span>	            
				  			<a href="{{ route('style.index') }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
				        </span>
				  	</div>
				  </div>
				</div>
          	</div>



          	<!-- Modal -->
          	@foreach($data as $dt)

				<!-- Modal Image-->
				@foreach($dt->modal_image as $img)
				<div class="modal fade" id="imgMod-{{$img->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
			          <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <img class="" src='{{ asset("storage/images/$img->image") }}' 
					      alt="{{ $img->image }}"
					      
					      >
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
				@endforeach

				<!-- Modal Show-->
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
						    <label for="name" class="col-form-label"><strong>Images</strong></label>
						    <div class="">
						    	<ul class="list-group list-group-horizontal-sm border-0">
									  	@foreach($dt->modal_image as $img)
										<li class="list-group-item border-0">
									      <img class="img-thumbnail" src='{{ asset("storage/images/$img->image") }}' 
									      alt="{{ $img->image }}"
									      style="float: left; width:  100px; height: 100px; object-fit: cover;" 
									      >
										</li>
									    @endforeach
								</ul>
						    </div>
						    <hr>
						    <label for="name" class="col-form-label"><strong>Usage</strong></label>
								  <div id="component">
								   	<table class="table table-bordered">
									  <thead>
									    <tr>
									      <th scope="col">Component</th>
									      <th scope="col">Material</th>
									      <th scope="col">Usage</th>
									      <th scope="col">Total Usage</th>
									    </tr>
									  </thead>
									  <tbody>
									  	@foreach( $dt->modal_component as $row )
									    <tr>
									      <td>{{ $row->name }}</td>
									      <td>
									      	<ul>
									      		@foreach( $row->material as $mat )
									      		<li>{{ $mat->name }}</li>
									      		@endforeach
									      	</ul>
									      </td>
									      <td>
									      	<ul>
									      		@foreach( $row->material as $mat )
									      		<li>{{ $mat->usage }}</li>
									      		@endforeach
									      	</ul>
									      </td>
									      <td>
									      	{{ $row->total_usage }}
									      </td>
									    </tr>
									    @endforeach
									  </tbody>
									</table>
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