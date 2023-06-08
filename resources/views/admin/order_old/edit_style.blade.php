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

      		<form method="post" action="{{ route('order.update_style', $data->id ) }}" enctype="multipart/form-data">
      			@csrf
      			
      			<input type="hidden" name="id_order" value="{{ $data->id_order }}">
      			<input type="hidden" name="id_order_style" value="{{ $data->id }}">
				<div class="card">				
				    <div class="card-header">Edit Data Style  : <strong>{{ $data->style_code }}</strong></div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Code</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="style_code" id="style_code" value="{{ $data->style_code }}" required>
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
											<input type="hidden" name="id_image1" value="{{ $data_image[0]->id }}">
								    		<img src='{{ asset("storage/images/$image1") }}' id="img_src1" class="img-thumbnail" width="100" height="100" />
								    		<input type="button" id="del_img1" value="Delete" class="btn btn-danger btn-sm">
								    		<input type="hidden" name="hidden_image1" value="{{ $image1 }}" />
							    		@endif
						    	        <input  type="file" id="image1" name="image1"  accept="image/*" onchange="document.getElementById('img_src1').src = window.URL.createObjectURL(this.files[0])">

		             	 			</li>
		             	 			<li>
							    		@if( !empty($data_image[1]->image) )
								    		@php
			    								$image2 = $data_image[1]->image;
											@endphp
											<input type="hidden" name="id_image2" value="{{ $data_image[1]->id }}">
								    		<img src='{{ asset("storage/images/$image2") }}' id="img_src2" class="img-thumbnail" width="100" height="100" />
								    		<input type="button" id="del_img2" value="Delete" class="btn btn-danger btn-sm">
								    		<input type="hidden" name="hidden_image2" value="{{ $image2 }}" />
							    		@endif
						    	        <input  type="file" name="image2"  accept="image/*" onchange="document.getElementById('img_src2').src = window.URL.createObjectURL(this.files[0])">
		             	 				
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
		    							  	<input type="button" id="add_size" class="btn btn-success btn-sm" value="Add Size Run">
		    							  	  <br>
											  <div class="table-size table-responsive">
											    <table class="table table-bordered table-style-order">
											      <thead>
											        <tr>
											          <th>Size</th>
											          <th>Quantity</th>
											          <th>Action</th>
											        </tr>
											      </thead>
											      <tbody>
											      	@foreach( $data_size_run as $row )
											      		<tr id="row_size_{{ $loop->index+1 }}"> 
											      			<input type="hidden" name="sizequan[{{ $loop->index+1 }}][id]" value="{{ $row->id }}">
											      			<td> 
											      				<input class="form-control" value="{{ $row->size }}" type="number" name="sizequan[{{ $loop->index+1 }}][size]" required>
											      			</td>
											      			<td> 
											      				<input class="form-control" value="{{ $row->quantity }}" type="number" name="sizequan[{{ $loop->index+1 }}][quantity]" required> 
											      			</td>
											      			<td> 
											      				<input type="button" class="del_row_size btn btn-danger btn-sm" data-numsize="{{ $loop->index+1 }}" data-id_delete_sizequan="{{ $row->id }}" value="delete" > 
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
		    							  	<input type="button" id="add_component" class="btn btn-success btn-sm" value="Add Component">
		    							  	  <br>
											  <div class="table-comp table-responsive">
											    <table class="table table-bordered table-style-order">
											      <thead>
											        <tr>
											          <th>Component</th>
											          <th>Action</th>
											        </tr>
											      </thead>
											      <tbody>
											      	@foreach( $data_component as $row )
											      	<tr id="row_comp_{{ $loop->index+1 }}">
											      		<td> <input class="form-control" type="text" name="component[]" value="{{ $row->component }}" required> </td>
											      		<td> <input type="button" class="del_row_comp btn btn-danger btn-sm" data-numcomp="{{ $loop->index+1 }}" value="delete" > </td>

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
				            <a href="{{ route('order.list_style', $data->id_order) }}" class="btn btn-sm btn-primary">
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
    $(document).ready(function() {

    	// size quantity table
        var row_num = '@php  echo count($data_size_run); @endphp' ;
	    $("#add_size").click(function() {
	        row_num++;
	        var size_col = '<td> <input class="form-control" type="number" name="sizequan['+row_num+'][size]" required> </td>';
	        var quan_col = '<td> <input class="form-control" type="number" name="sizequan['+row_num+'][quantity]" required> </td>';
	        var del_row = '<td> <input type="button" class="del_row_size btn btn-danger btn-sm" data-numsize="'+ row_num +'" value="delete" > </td>';

	        var row = '<tr id="row_size_'+row_num+'" >'+ size_col + quan_col + del_row + '</tr>';
	        $(".table-size table tbody").append(row);
	    });

		$(".table-size table tbody").on("click",".del_row_size",function(e) {
		    //add value to array deleted_sizequan
		    var attr = $(this).attr('data-id_delete_sizequan');
			if (typeof attr !== typeof undefined && attr !== false) {
			    var val = '<input type="hidden" name="deleted_sizequan[]" value="'+attr+'">';
		        $(".table-size table tbody").append(val);
			}

		  	var num = $(this).attr("data-numsize");
		    $("#row_size_" + num).remove();
		});


		//component table
        var row_num_c = '@php  echo count($data_component); @endphp';
	    $("#add_component").click(function() {
	        row_num_c++;
	        var com_col = '<td> <input class="form-control" type="text" name="component[]" required> </td>';
	        var del_row = '<td> <input type="button" class="del_row_comp btn btn-danger btn-sm" data-numcomp="'+ row_num_c +'" value="delete" > </td>';

	        var row = '<tr id="row_comp_'+row_num_c+'" >'+ com_col + del_row + '</tr>';
	        $(".table-comp table tbody").append(row);
	    });

		$(".table-comp table tbody").on("click",".del_row_comp",function(e) {
		  	var num = $(this).attr("data-numcomp");
		    $("#row_comp_" + num).remove();
		});


		//image
		$('#del_img1').click(function() {
	 		$('#img_src1').attr('src', '{{ asset("storage/images/noimage.png") }}');
	 		$('#image1').val('')
	    });
		$('#del_img2').click(function() {
	 		$('#img_src2').attr('src', '{{ asset("storage/images/noimage.png") }}');
	 		$('#image2').val('');
	    });



    });
</script>

      


@endsection