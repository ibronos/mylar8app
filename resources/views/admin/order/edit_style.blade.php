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

      		<form method="post" action="{{ route('order.update_style', $data->id_ols) }}" enctype="multipart/form-data">
      			@csrf
      			<input type="hidden" name="id_order_list_style" value="{{$data->id_ols}}">
      			<input type="hidden" name="id_order" value="{{$data->id_order}}">
				<div class="card">				
				    <div class="card-header">Size Run for Order <strong></strong> {{ $data->code }} Style {{ $data->name }}</div>
				  	<div class="card-body">
						  <input type="button" id="add_size" class="btn btn-success btn-sm mb-2" value="Add Size Run">
					  	  
						  <div class="table-size table-responsive">
						    <table class="table table-bordered table-style-order table-sm">
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
						      			<input type="hidden" name="sizequan[{{ $loop->index+1 }}][id]" value="{{ $row->id_size_run }}">
						      			<td> 
						      				<input class="form-control form-control-sm" value="{{ $row->size }}" type="number" name="sizequan[{{ $loop->index+1 }}][size]" required>
						      			</td>
						      			<td> 
						      				<input class="form-control form-control-sm" value="{{ $row->quantity }}" type="number" name="sizequan[{{ $loop->index+1 }}][quantity]" min="1" required> 
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
					  <div class="card-footer text-right">
				            <a href="{{ route('order.show', $data->id_order) }}" class="btn btn-sm btn-primary">
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
	        var size_col = '<td> <input class="form-control form-control-sm" type="number" name="sizequan['+row_num+'][size]" required> </td>';
	        var quan_col = '<td> <input class="form-control form-control-sm" type="number" name="sizequan['+row_num+'][quantity]" min="1" required>  </td>';
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


    });
</script>


@endsection