@extends('layouts.app')
@section('title')
List of items in the store
@endsection
@section('content')
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2>{{$category}} Category</h2>
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
				@foreach($items as $item)
				<tr>
				<td>{{$item->item_name}}</td>
				<td>{{$item->category}}</td>
				<td>{{$item->available_unit}}</td>
				<td>{{$item->unit_price}}</td>
				<td>{{$item->normal_price}}</td>
				<td>
					<a href="" class="edit"><i class="fa fa-edit" title="Edit"></i></a>';
					<a href="#" id="deleteItem" class="delete" onclick="remove_item()"><i class="fa fa-trash-o" title="Delete"></i></a>
				<form action="" method="POST" id="del_item_{{$item->id}}" style="display:none;">@csrf @method('DELETE')</form>';
				</td>
				</tr>
				@endforeach
			</tbody>
		</table>
</div>
@endsection
@section('extra-js')
<script type="text/javascript">
	///////Consuming the API using AJAX and JQuery
	 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
		            url: "/api/v1/item/"+id,
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
</script>
@endsection