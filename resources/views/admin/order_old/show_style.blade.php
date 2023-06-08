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

      			<input type="hidden" name="id_order" value="{{ $data->id_order }}">
      			<input type="hidden" name="id_order_style" value="{{ $data->id }}">
				<div class="card">				
				    <div class="card-header">Data Style  : <strong>{{ $data->style_code }}</strong></div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Code</label>
						    <div class="col-sm-10">
						    	<label class="col-sm-2 col-form-label"> <strong>{{ $data->style_code }}</strong> </label>
						      
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Image <br><small class="text-danger">(Max 2 Images)</small></label>
						    <div class="col-sm-10">
						    	<ul style="list-style: none;">

							    	<li>
							    		@if( !empty($data_image[0]->image) )
								    		@php
			    								$image1 = $data_image[0]->image;
											@endphp
								    		<img src='{{ asset("storage/images/$image1") }}' id="img_src1" class="img-thumbnail" width="100" height="100" />
							    		@endif

		             	 			</li>
		             	 			<li>
							    		@if( !empty($data_image[1]->image) )
								    		@php
			    								$image2 = $data_image[1]->image;
											@endphp
								    		<img src='{{ asset("storage/images/$image2") }}' id="img_src2" class="img-thumbnail" width="100" height="100" />
							    		@endif
		             	 			</li>
             	 				</ul>
						    </div>
						  </div>
	  					  <div class="form-group row">
						    	<label for="name" class="col-sm-2 col-form-label">Size Run</label>
						    	<div class="col-sm-10">
						    		<p>
									  <a class="btn btn-info btn-sm" data-toggle="collapse" href="#collapseSize" role="button" aria-expanded="false" aria-controls="collapseExample">
									    Show List Size Run
									  </a>
									</p>
									<div class="collapse" id="collapseSize">
									  <div class="card card-body">
		    							  	  <br>
											  <div class="table-size table-responsive">
											    <table class="table table-bordered table-style-order">
											      <thead>
											        <tr>
											          <th>Size</th>
											          <th>Quantity</th>
											        </tr>
											      </thead>
											      <tbody>
											      	@foreach( $data_size_run as $row )
											      		<tr id="row_size_{{ $loop->index+1 }}"> 
											      			<td> 
											      				{{ $row->size }}
											      			</td>
											      			<td> 
											      				{{ $row->quantity }}
											      			</td>
											      		</tr>
											      	@endforeach
											      </tbody>
											    </table>
											  </div>
									  </div>
									</div>
							  	</div>
						  </div>

						  <div class="form-group row">
						    	<label for="name" class="col-sm-2 col-form-label">Components</label>
						    	<div class="col-sm-10">
						    		<p>
									  <a class="btn btn-info btn-sm" data-toggle="collapse" href="#collapseComp" role="button" aria-expanded="false" aria-controls="collapseExample">
									    Show Components
									  </a>
									</p>
									<div class="collapse" id="collapseComp">
									  <div class="card card-body">
		    							  	  <br>
											  <div class="table-comp table-responsive">
											    <table class="table table-bordered table-style-order">
											      <thead>
											        <tr>
											          <th>Component</th>
											         
											        </tr>
											      </thead>
											      <tbody>
											      	@foreach( $data_component as $row )
											      	<tr id="row_comp_{{ $loop->index+1 }}">
											      		<td> {{ $row->component }} </td>
											      	</tr>
											      	@endforeach
											      </tbody>
											    </table>
											  </div>
									  </div>
									</div>
							  	</div>
						  </div>



					</div>  

					  <div class="card-footer text-right">
				            <a href="{{ route('order.list_style', $data->id_order ) }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
					  </div>
				</div>		

      	</div>
      </div>



@endsection