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

      		<form method="post" action="{{ route('style.store') }}" enctype="multipart/form-data">
      			@csrf
				<div class="card">				
				    <div class="card-header">Add Style</div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control form-control-sm" name="name" id="name" required>
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Image <br><small class="text-danger">(Max 2 Images)</small></label>
						    <div class="col-sm-10">
						    	<input type="file" id="image1" name="image1" accept="image/*"><br><br>
						    	<input type="file" id="image2" name="image2" accept="image/*"><br>
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
											    <table class="table table-bordered table-sm table-style-order">
											      <thead>
											        <tr>
										        	 <th>Delete</th>
											         <th>Component</th>
											         <th>Materials</th>											         
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
				            <a href="{{ route('style.index') }}" class="btn btn-sm btn-primary">
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

	// row_num_c = row number component 
	// mat_row_num = material row number

	var mat_row_num = 0;
	function addMaterial(row_num_c) {
			mat_row_num++;
			var input_material =
			'<div class="form-group form-group-sm row" id="mat-row-num-'+mat_row_num+'">'+
			    '<div class="col-sm-5">' +
			    	'<input type="text" placeholder="name" class="form-control form-control-sm" name="component['+row_num_c+'][material]['+mat_row_num+'][mat_name]" required>' +
			    '</div>'+
			    '<div class="col-sm-5">' +
			      '<input type="number" class="form-control form-control-sm" name="component['+row_num_c+'][material]['+mat_row_num+'][mat_calc]" step="any" placeholder="calculation" required>' +
			    '</div>'+
				'<div class="col-sm-2">'+
					'<input type="button" class="btn btn-sm btn-danger btn-del-mat" data-com-row-num="'+row_num_c+'" data-mat-row-num="'+mat_row_num+'" value="x">' +
				'</div>'+
			  '</div>';
			  $("td#col_comp_"+row_num_c).append(input_material);
	}


    $(document).ready(function() {

		//component table
        var row_num_c = 0;
	    $("#add_component").click(function() {
	        row_num_c++;
	        var com_col = '<td> <input class="form-control form-control-sm" type="text" placeholder="component name" name="component['+row_num_c+'][name]" required> </td>';
	        var del_row = '<td> <input type="button" class="del_row_comp btn btn-danger btn-sm" data-numcomp="'+ row_num_c +'" value="x" > </td>';

            var btnAdd = '<input type="button" value="Add Material" class="btn-add-mat btn btn-warning btn-sm btn-block" data-com-row-num="'+row_num_c+'" > <br>';
  	        var col_materials = '<td id="col_comp_'+row_num_c+'">' + btnAdd + '</td>';

	        var row = '<tr id="row_comp_'+row_num_c+'" >'+ del_row  + com_col + col_materials +'</tr>';
	        $(".table-comp table tbody").append(row);
	    });

		$(".table-comp table tbody").on("click",".del_row_comp",function(e) {
		  	var num = $(this).attr("data-numcomp");
		    $("#row_comp_" + num).remove();
		});



		//add row materials
		$(".table-comp table tbody").on("click",".btn-add-mat",function(e) {
		  	var row_num = $(this).attr("data-com-row-num");
		  	var mat_row_num = parseInt( $(this).attr("data-btn-mat-row-num") ) + 1; 
		  	// var mat_row_num = parseInt(mat_row_num) + 1;

		  	addMaterial(row_num);
		});

		// delete row material
		$(".table-comp table tbody").on("click",".btn-del-mat",function(e) {
		  	var row_num = $(this).attr("data-com-row-num");
		  	var comp_num = $(this).attr("data-mat-row-num");
		  	console.log(row_num + comp_num);
		    $("#row_comp_"+ row_num +" #mat-row-num-" + comp_num).remove();
		});

    });
</script>

      


@endsection