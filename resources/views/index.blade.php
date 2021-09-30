@extends('layouts.app')
@section('title')
List of items in the store
@endsection
@section('content')
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2>List of items in the store</h2>
				</div>
				<div class="col-sm-6">
					<a href="{{route('item.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> 
						<span>New Product</span></a>
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Item name</th>
					<th>Category</th>
					<th>Available unit</th>
					<th>Unit price($)</th>
					<th>Normal price($)</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody id="data_container">
				
			</tbody>
		</table>
</div>
	<!-- Edit Modal HTML -->
	<div id="UpdateUnitPriceModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="update_unit_price">
						<div class="modal-header">						
							<h4 class="modal-title">Update Unit Price of <strong><span id="item_name"></span><strong></strong></h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">					
							<div class="form-group">
								<label>Unit Price</label>
								<span id="unit_price_err" class="text-danger"></span>
								<input type="text" class="form-control" id="unit_price">
								<input type="hidden" class="form-control" value="" id="item_id">
							</div>					
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-success" value="Save changes">
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Edit Modal HTML -->
@endsection
@section('extra-js')
<script type="text/javascript">
	///////Consuming the API using AJAX and JQuery
	 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
			});
	 $.get("{{route('item.list')}}",
                function(response)
                {
                    if(response){
                    	if (response.data.length>0){
                    		var records = '';
                    	 for (var i = response.data.length - 1; i >= 0; i--){
	                      		records+='<tr>';
			                        records+='<td>'+response.data[i]['item_name']+'</td>';
			                        records+='<td>'+response.data[i]['category']+'</td>';
									records+='<td>'+response.data[i]['available_unit']+'</td>';
			                        records+='<td>'+response.data[i]['unit_price']+' <a data-toggle="modal" href="#UpdateUnitPriceModal" class="edit" onclick="edit_price_unit('+response.data[i]['id']+')"><i class="fa fa-edit" title="Edit"></i></a></td>';
			                        records+='<td>'+response.data[i]['normal_price']+'</td>';
			                        records+='<td>';
										records+='<a href="/item/cart/'+response.data[i]['id']+'" class="text-info"><i class="fa fa-shopping-cart" title="Add to cart"></i></a>';
										records+='<a href="#" id="deleteItem" class="delete" onclick="remove_item('+response.data[i]['id']+')"><i class="fa fa-trash-o" title="Delete"></i></a>';
			                        	records+='<form action="" method="POST" id="del_item_'+response.data[i]['id']+'" style="display:none;">@csrf @method('DELETE')</form>';
			                        records+='</td>';
		                    	records+='</tr>';
                   		}
                   		$('#data_container').html(records);
                    }
                    else{
                        alert('NO ITEMS FOUND')
                    }
                }
            });
function remove_item(id){
	swal({
            title: "Remove Item",
            text: "Are you sure that you want to remove this item",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax(
		        {
		            url: "/item/"+id,
		            type: 'DELETE',
		            dataType: "JSON",
		            data: {
		                "id": id,
		                "_method": 'DELETE',
		            },
		            success: function (response)
		            {
		                alert(response.message);
		                window.location ='';
		            }
		        });
            } 
            });
}
function edit_price_unit(id){
	if(id.length !== 0){
		$.ajax(
		        {
		            url: "/item/"+id+"/edit",
		            type: 'GET',
		            dataType: "JSON",
		            data: {
		                "id": id
		            },
		            success: function (response)
		            {
		                $('#item_name').html(response.data.item_name);
		                $('#unit_price').val(response.data.unit_price);
		                $('#item_id').val(response.data.id);
		            }
		        });
	}
}
$('#update_unit_price').on('submit', function(e){
	e.preventDefault();
	var unit_price = $('#unit_price').val();
	unit_price = unit_price.replace(/^\s+/,'');
	if(unit_price.length == 0){
			$('#unit_price_err').html('Unit price is required!');
		}
		else if(Math.floor(unit_price) != unit_price || $.isNumeric(unit_price) == false){
			// 
			$('#unit_price_err').html('Unit Price must be a valid integer!');
		}
		else{
			var id = $('#item_id').val();
			$.ajax(
		        {
		            url: "/item/"+id,
		            type: 'POST',
		            dataType: "JSON",
		            data: {
		                "id": id,
						'unit_price':unit_price,
						"_method": 'PUT'
		            },
		            success: function (response)
		            {
		                if(response.message){
							alert(response.message);
		                	window.location ='';
						}
		            }
		        });
		}
});
</script>
@endsection