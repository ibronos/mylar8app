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
				    <div class="card-header">Data Style</div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Name</label>
						    <label for="name" class="col-sm-10 col-form-label">:  <strong>{{ $data->name }}</strong></label>
						  </div>
  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Images</label>
						    <div class="col-sm-10">
						    	<ul class="list-group list-group-horizontal-sm border-0">
									  	@foreach($data_image as $img)
										<li class="list-group-item border-0">
									      <img class="img-thumbnail" src='{{ asset("storage/images/$img->image") }}' 
									      alt="{{ $img->image }}"
									      style="float: left; width:  100px; height: 100px; object-fit: cover;" 
									      >
										</li>
									    @endforeach
									</ul>
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Total Quantity</label>
						    <label for="name" class="col-sm-10 col-form-label">: {{ $total_quantity->total }}</label>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Usage</label>
						    <div class="col-sm-10">
						    	  :	
						    	  <a href="" data-toggle="collapse" data-target="#component"> Show Usage</a>
								  <div id="component" class="collapse">
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
									  	@foreach( $component as $row )
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
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Progress</label>
						    <div class="col-sm-10 pt-2">
						    	<span class="progress">
					    		 		@php
					    		 			$prog = 0;
					    		 			foreach($data_size_run as $row) {
					    		 				$quantity = $row->quantity;
								    			$x = $row->cutting / $quantity + $row->stitching / $quantity + $row->buffing / $quantity + $row->lasting / $quantity + $row->finishing / $quantity;
								    			$percent = $x/5 * 100;
								    			$round = round($percent, 1);
								    			$prog = $prog + $round;
							    			}
							    			$div = !empty(count($data_size_run)) ? count($data_size_run) : 1;
							    			$progress = $prog / $div;
							    			$progress = round($progress, 1);
								    	@endphp

									  <div class="progress-bar" role="progressbar" 
										  style="width: {{ $progress }}%;" 
										  aria-valuenow="{{ $progress }}" 
										  aria-valuemin="0" 
										  aria-valuemax="100">
										{{ $progress }}%
									  </div>
								</span>

						    </div>
						  </div>

  						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Notes</label>
				      
						    <div class="col-sm-10">
			    	    		<form method="post" action="{{ route('report.update_notes', $notes->note_id ) }}" enctype="multipart/form-data">
						      		@csrf
									<textarea id="note" class="form-control" name="note" rows="10" cols="30">
										{{ $notes->note }}
									</textarea>
									<br>
									<input type="submit" value="Save Notes" class="btn btn-sm btn-info">
								  </form>	
						    </div>
							  					    
						  </div>

						  <div class="table-size table-responsive">
						    <table class="table table-bordered" style="display: none;">
						      <thead>
						        <tr>
						          <th>Size</th>
						          <th>Quantity</th>
						          <th>Process</th>
						          <th>Status</th>
						          <th>Action</th>
						        </tr>
						      </thead>
						      <tbody>
						      	@foreach( $data_size_run as $row )
						      		<tr> 
						      			<td> 
						      				{{ $row->size }} 
						      			</td>
						      			<td> 
						      				{{ $row->quantity }}
						      			</td>
						      			<td>
	  										  <div class="form-group row mb-0">
											    <label for="name" class="col-sm-6 col-form-label">
											    	<strong> Cutting </strong>
											    </label>
											    <label for="name" class="col-sm-6 col-form-label"> 
											    	: {{ $row->cutting }} / {{ $row->quantity }}
											    </label>											    
											  </div>

  	  										  <div class="form-group row mb-0">
											    <label for="name" class="col-sm-6 col-form-label">
											    	<strong> Stitching </strong>
											    </label>
											    <label for="name" class="col-sm-6 col-form-label"> 
											    	: {{ $row->stitching }} / {{ $row->quantity }}
											    </label>
											  </div>

	  										  <div class="form-group row mb-0">
											    <label for="name" class="col-sm-6 col-form-label">
											    	<strong> Buffing </strong>
											    </label>
											    <label for="name" class="col-sm-6 col-form-label"> 
											    	: {{ $row->buffing }} / {{ $row->quantity }}
											    </label>
											  </div>

  	  										  <div class="form-group row mb-0">
											    <label for="name" class="col-sm-6 col-form-label">
											    	<strong> Lasting </strong>
											    </label>
											    <label for="name" class="col-sm-6 col-form-label"> 
											    	: {{ $row->lasting }} / {{ $row->quantity }}
											    </label>
											  </div>

	  										  <div class="form-group row mb-0">
											    <label for="name" class="col-sm-6 col-form-label">
											    	<strong> Finishing </strong>
											    </label>
											    <label for="name" class="col-sm-6 col-form-label"> 
											    	: {{ $row->finishing }} / {{ $row->quantity }}
											    </label>
											  </div>
						      			</td>
						      			<td>
									    	<span class="badge badge-info">
									    		@php
									    			$x = $row->cutting + $row->stitching + $row->buffing + $row->lasting + $row->finishing;
									    			$y = $row->quantity*5;
									    			$percent = $x / $y * 100;
									    			echo round($percent, 1);
									    		@endphp
									    		%
									    	</span>
						      			</td>
						      			<td>
						      				<input type="button" class="btn btn-success btn-sm btn-update" 
						      				data-idsizerun="{{ $row->id_style_sizerun }}"
						      				data-size="{{ $row->size }}"
						      				data-quantity="{{ $row->quantity }}"
						      				data-cutting="{{ $row->cutting }}"
						      				data-stitching="{{ $row->stitching }}"
						      				data-buffing="{{ $row->buffing }}"
						      				data-lasting="{{ $row->lasting }}"
						      				data-finishing="{{ $row->finishing }}"
						      				value="Update Process">
						      			</td>
						      		</tr>
						      	@endforeach
						      </tbody>
						    </table>




						    <table class="table table-bordered table-sm table-striped" style="width: 100%">
							  <tr>
							  	 <!-- <th rowspan="2" class="bg-secondary text-white"><strong>{{ $data->name }}</strong></th> -->
							  	 <th class="bg-secondary text-white" style="width: 10% !important;">Size</th>
							    @foreach( $data_size_run as $row )
							    <td 
							    class="btn-update bg-secondary text-white text-center w-auto" 
			      				data-idsizerun="{{ $row->id_style_sizerun }}"
			      				data-size="{{ $row->size }}"
			      				data-quantity="{{ $row->quantity }}"
			      				data-cutting="{{ $row->cutting }}"
			      				data-stitching="{{ $row->stitching }}"
			      				data-buffing="{{ $row->buffing }}"
			      				data-lasting="{{ $row->lasting }}"
			      				data-finishing="{{ $row->finishing }}" 
							    >
							    {{ $row->size }} 
								</td>
							    @endforeach
							  </tr>
  							  <tr>
  							  	<th class="bg-secondary text-white">Quantity</th>
							    @foreach( $data_size_run as $row )
							    <td
							    class="btn-update bg-secondary text-white text-center" 
			      				data-idsizerun="{{ $row->id_style_sizerun }}"
			      				data-size="{{ $row->size }}"
			      				data-quantity="{{ $row->quantity }}"
			      				data-cutting="{{ $row->cutting }}"
			      				data-stitching="{{ $row->stitching }}"
			      				data-buffing="{{ $row->buffing }}"
			      				data-lasting="{{ $row->lasting }}"
			      				data-finishing="{{ $row->finishing }}" 
							    >
							    	{{ $row->quantity }} 
							    </td>
							    @endforeach
							  </tr>
							  <tr>
							    <td class="bg-secondary text-white font-italic">Cutting</td>
							     @foreach( $data_size_run as $row )
							    <td class="text-center">{{ $row->cutting }} </td>
							    @endforeach
							  </tr>
							  <tr>
							    <td class="bg-secondary text-white font-italic">Stitching</td>
							     @foreach( $data_size_run as $row )
							    <td class="text-center">{{ $row->stitching }} </td>
							    @endforeach
							  </tr>
  							  <tr>
							    <td class="bg-secondary text-white font-italic">Buffing</td>
							     @foreach( $data_size_run as $row )
							    <td class="text-center">{{ $row->buffing }} </td>
							    @endforeach
							  </tr>
							  <tr>
							    <td class="bg-secondary text-white font-italic">Lasting</td>
							     @foreach( $data_size_run as $row )
							    <td class="text-center">{{ $row->lasting }} </td>
							    @endforeach
							  </tr>
  							  <tr>
							    <td class="bg-secondary text-white font-italic">Finishing</td>
							     @foreach( $data_size_run as $row )
							    <td class="text-center">{{ $row->finishing }} </td>
							    @endforeach
							  </tr>
							</table>

						  </div>

					</div>  

					  <div class="card-footer text-right">
				            <a href="{{ route('order.show', $data->id_order ) }}" class="btn btn-sm btn-primary">
				            	<i class="fas fa-angle-left fa-sm text-white-50"></i> 
				            	Back
				            </a>
					  </div>
				</div>		


				<!-- Modal -->
				<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Update Process for Size : <strong id="modal-size"></strong></h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <form method="post" id="modal-form" action="{{ route('report.update_process', $data->id ) }}" enctype="multipart/form-data">
				      		@csrf
				      		<input type="hidden" name="id_style_sizerun" id="modal-id">
				      		<input type="hidden" name="quantity" id="modal-quantity">
					        <div class="modal-body">
								<div class="form-group row">
								    <label for="name" class="col-sm-6 col-form-label">
								    	<strong>Cutting</strong>
								    </label>
								    <div class="col-sm-6">
								    	<input type="number"  class="form-control" name="cutting" id="modal-cutting">
								    </div>
								</div>
								<div class="form-group row">
								    <label for="name" class="col-sm-6 col-form-label">
								    	<strong>Stitching</strong>
								    </label>
								    <div class="col-sm-6">
								    	<input type="number"  class="form-control" name="stitching" id="modal-stitching">
								    </div>
								</div>
								<div class="form-group row">
								    <label for="name" class="col-sm-6 col-form-label">
								    	<strong>Buffing</strong>
								    </label>
								    <div class="col-sm-6">
								    	<input type="number"  class="form-control" name="buffing" id="modal-buffing">
								    </div>
								</div>
								<div class="form-group row">
								    <label for="name" class="col-sm-6 col-form-label">
								    	<strong>Lasting</strong>
								    </label>
								    <div class="col-sm-6">
								    	<input type="number"  class="form-control" name="lasting" id="modal-lasting">
								    </div>
								</div>
							  <div class="form-group row">
							    <label for="name" class="col-sm-6 col-form-label">
							    	<strong> Finishing </strong>
							    </label>
								    <div class="col-sm-6">
								    	<input type="number"  class="form-control" name="finishing" id="modal-finishing">
								    </div>
							  </div>
					      </div>
					      </form>

					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" type="submit" class="btn btn-primary" id="modal-submit">Save changes</button>
					      </div>
				    </div>
				  </div>
				</div>

      	</div>
      </div>

<script type="text/javascript">
    $(document).ready(function() {
    	$('.btn-update').click(function(){
    		$("#modal-id").val( $(this).attr('data-idsizerun') );
    		$("#modal-quantity").val( $(this).attr('data-quantity') );
    		$("#modal-size").text( $(this).attr('data-size') );
    		$("#modal-cutting").val( $(this).attr('data-cutting') );
		  	$("#modal-cutting").attr({
		       "max" : $(this).attr('data-quantity'),
		       "min" : 0
		    });
    		$("#modal-stitching").val( $(this).attr('data-stitching') );
		  	$("#modal-stitching").attr({
		       "max" : $(this).attr('data-quantity'),
		       "min" : 0
		    });
    		$("#modal-buffing").val( $(this).attr('data-buffing') );
		  	$("#modal-buffing").attr({
		       "max" : $(this).attr('data-quantity'),
		       "min" : 0
		    });
    		$("#modal-lasting").val( $(this).attr('data-lasting') );
		  	$("#modal-lasting").attr({
		       "max" : $(this).attr('data-quantity'),
		       "min" : 0
		    });
    		$("#modal-finishing").val( $(this).attr('data-finishing') );
		  	$("#modal-finishing").attr({
		       "max" : $(this).attr('data-quantity'),
		       "min" : 0
		    });
    		$('#updateModal').modal('show');

    		$('#modal-submit').click(function(){
    			$('#modal-form').submit();
    		});
    	});
    });
</script>


<script>
var konten = document.getElementById("note");
  CKEDITOR.replace(konten,{
  language:'en-gb'
});
CKEDITOR.config.allowedContent = true;
</script>


@endsection