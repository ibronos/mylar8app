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

      		<form method="post" action="{{ route('order.store_style') }}" enctype="multipart/form-data">
      			@csrf
      			
      			<input type="hidden" value="{{$data->id}}" name="id_order">
				<div class="card">				
				    <div class="card-header">Add Style for Order : <strong>{{ $data->code }}</strong></div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Code</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" name="style_code" id="style_code" required>
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Image <br><small class="text-danger">(Max 2 Images)</small></label>
						    <div class="col-sm-10">
						    	<!-- <input type="file" id="image" name="image[]" multiple accept="image/*"><br> -->
						    	<input type="file" id="image1" name="image1" accept="image/*"><br><br>
						    	<input type="file" id="image2" name="image2" accept="image/*"><br>
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
											      </tbody>
											    </table>
											  </div>
									  </div>
									</div>
							  	</div>
						  </div>
					</div>  

					  <div class="card-footer text-right">
				            <a href="{{ route('order.list_style', $data->id) }}" class="btn btn-sm btn-primary">
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
        var row_num = 0;
	    $("#add_size").click(function() {
	        row_num++;
	        var num_col = '<td>'+row_num+'</td>';
	        var size_col = '<td> <input class="form-control" type="number" name="sizequan['+row_num+'][size]" required> </td>';
	        var quan_col = '<td> <input class="form-control" type="number" name="sizequan['+row_num+'][quantity]" required> </td>';
	        var del_row = '<td> <input type="button" class="del_row_size btn btn-danger btn-sm" data-numsize="'+ row_num +'" value="delete" > </td>';

	        var row = '<tr id="row_size_'+row_num+'" >'+ size_col + quan_col + del_row + '</tr>';
	        $(".table-size table tbody").append(row);
	    });

		$(".table-size table tbody").on("click",".del_row_size",function(e) {
		  	var num = $(this).attr("data-numsize");
		    $("#row_size_" + num).remove();
		});


		//component table
        var row_num_c = 0;
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


		$("#image").on("change", function(e) {
		    if ($("#image")[0].files.length > 2) {
		       alert("You can select only 2 images, only two image will be inserted!");
		    }
		});

    });
</script>

      


@endsection