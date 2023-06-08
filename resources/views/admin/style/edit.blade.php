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

      		<form method="post" action="{{ route('style.update', $data->id ) }}" enctype="multipart/form-data">
      			@csrf
      			@method('PATCH')
				<div class="card">				
				    <div class="card-header">Edit Style</div>
				  	<div class="card-body">
						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Style Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control form-control-sm" value="{{ $data->name }}" name="name" id="name" required>
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
  												      	@foreach( $data_component as $row )
  												      		<tr id="row_comp_{{ $row['id'] }}">
  												      			<input type="hidden" name="component[{{ $row['id'] }}][id]" value="{{ $row['id']}}">
  												      			<td>
  												      				<input type="button" 
  												      				class="del_row_comp btn btn-danger btn-sm" 
  												      				data-numcomp="{{ $row['id'] }}" 
  												      				data-delcomp="{{ $row['id'] }}"
  												      				value="x" > 
  												      			</td>
  												      			<td>
  												      				<input class="form-control form-control-sm" type="text" placeholder="component name" name="component[{{$row['id']}}][name]" value="{{$row['name']}}" required>
  												      			</td>
  												      			<td id="col_comp_{{ $row['id'] }}">
  												      				<input type="button" value="Add Material" 
  												      				class="btn-add-mat-up btn btn-warning btn-sm btn-block"
  												      				id="btn-add-mat-up-{{$row['id']}}" 
  												      				data-com-row-num="{{$row['id']}}"
  												      				data-com-total=
  												      				"@php if( isset($row['material']) ) { echo count($row['material']); } @endphp"
  												      				> <br>
  												      				@if( isset($row['material']) )
  												      					@foreach( $row['material'] as $row_mat )
  												      						<input type="hidden" 
  												      						name="component[{{$row['id']}}][material][{{$row_mat['id_mat']}}][mat_id]" 
  												      						value="{{$row_mat['id_mat']}}">

  												      						<div class="form-group form-group-sm row" id="mat-row-num-{{$row_mat['id_mat']}}">
  												      							<div class="col-sm-5">
  												      								<input type="text" placeholder="name" class="form-control form-control-sm" 
  												      								name="component[{{$row['id']}}][material][{{$row_mat['id_mat']}}][mat_name]" 
  												      								value="{{ $row_mat['name_mat'] }}" required>
  												      							</div>
  												      							<div class="col-sm-5">
  												      								<input type="number" class="form-control form-control-sm" 
  												      								name="component[{{$row['id']}}][material][{{$row_mat['id_mat']}}][mat_calc]" 
  												      								placeholder="calculation" 
  												      								value="{{ $row_mat['calculation_mat'] }}" 
  												      								step="any"
  												      								required>
  												      							</div>
  												      							<div class="col-sm-2">
  												      								<input type="button" 
  												      								class="btn btn-sm btn-danger btn-del-mat" 
  												      								data-com-row-num="{{$row['id']}}" 
  												      								data-mat-row-num="{{$row_mat['id_mat']}}"
  												      								data-del-mat="{{$row_mat['id_mat']}}"
  												      								value="x">
  												      							</div>
  												      						</div>
  												      					@endforeach
  												      				@endif
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


	function addMaterialUp(row_num_c, mat_total) {
			com_total_plus = parseInt(mat_total)+1;
			var input_material =
			'<div class="form-group form-group-sm row" id="mat-row-num-'+com_total_plus+'">'+
			    '<div class="col-sm-5">' +
			    	'<input type="text" placeholder="name" class="form-control form-control-sm" name="component['+row_num_c+'][material]['+com_total_plus+'][mat_name]" required>' +
			    '</div>'+
			    '<div class="col-sm-5">' +
			      '<input type="number" class="form-control form-control-sm" name="component['+row_num_c+'][material]['+com_total_plus+'][mat_calc]" step="any" placeholder="calculation" required>' +
			    '</div>'+
				'<div class="col-sm-2">'+
					'<input type="button" class="btn btn-sm btn-danger btn-del-mat" data-com-row-num="'+row_num_c+'" data-mat-row-num="'+com_total_plus+'" value="x">' +
				'</div>'+
			  '</div>';
			  $("td#col_comp_"+row_num_c).append(input_material);
			  $('#btn-add-mat-up-'+row_num_c).attr('data-com-total', com_total_plus);
	}


    $(document).ready(function() {
    	///////////////
		//COMPONENT///
		/////////////
        var row_num_c = parseInt('@php echo count($data_component); @endphp');
	    $("#add_component").click(function() {
	        row_num_c = row_num_c+9999;
	        var com_col = '<td> <input class="form-control form-control-sm" type="text" placeholder="component name" name="component['+row_num_c+'][name]" required> </td>';
	        var del_row = '<td> <input type="button" class="del_row_comp btn btn-danger btn-sm" data-numcomp="'+ row_num_c +'" value="x" > </td>';

            var btnAdd = '<input type="button" value="Add Material" class="btn-add-mat btn btn-warning btn-sm btn-block" data-com-row-num="'+row_num_c+'" > <br>';
  	        var col_materials = '<td id="col_comp_'+row_num_c+'">' + btnAdd + '</td>';

	        var row = '<tr id="row_comp_'+row_num_c+'" >'+ del_row  + com_col + col_materials +'</tr>';
	        $(".table-comp table tbody").append(row);
	    });

		$(".table-comp table tbody").on("click",".del_row_comp",function(e) {
		    var del_id = $(this).attr('data-delcomp');
			if (typeof del_id !== typeof undefined && del_id !== false) {
			    var deletedRow = '<input type="hidden" name="component[deleted_component][]" value="'+del_id+'">';
			    $(".table-comp table tbody").append(deletedRow);
			}

		  	var num = $(this).attr("data-numcomp");
		    $("#row_comp_" + num).remove();

		});



		///////////////////
		//MATERIALS///////
		/////////////////

		//add row materials
		$(".table-comp table tbody").on("click",".btn-add-mat",function(e) {
		  	var row_num = $(this).attr("data-com-row-num");
		  	var mat_row_num = parseInt( $(this).attr("data-btn-mat-row-num") ) + 1; 

		  	addMaterial(row_num);
		});

		// delete row material
		$(".table-comp table tbody").on("click",".btn-del-mat",function(e) {
		  	var row_num = $(this).attr("data-com-row-num");
		  	var comp_num = $(this).attr("data-mat-row-num");
		    $("#row_comp_"+ row_num +" #mat-row-num-" + comp_num).remove();

		    var del_id = $(this).attr('data-del-mat');
			if (typeof del_id !== typeof undefined && del_id !== false) {
			    var deletedMat = '<input type="hidden" name="component[deleted_material][]" value="'+del_id+'">';
		    	$(".table-comp").append(deletedMat);
			}
		});

		//add row materials up
		$(".table-comp table tbody").on("click",".btn-add-mat-up",function(e) {
		  	var row_num = $(this).attr("data-com-row-num");
		  	var com_total = $(this).attr("data-com-total");
		  	addMaterialUp(row_num, com_total);
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