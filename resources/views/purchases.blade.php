@extends('layouts.app')
@section('title')
List Of Purchases Made
@endsection
@section('content')
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2>List Of Purchases Made</h2>
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
					<th>Quantity Purchased</th>
					<th>Normal Price($)</th>
					<th>Unit Price($)</th>
					<th>Amount Paid($)</th>
					<th>Profit($)</th>
				</tr>
			</thead>
			<tbody id="data_container">
				@foreach($purchases as $purchases)
				<tr>
				<td>{{$purchases->item->item_name}}</td>
				<td>{{number_format($purchases->quantity)}}</td>
				<td>{{number_format($purchases->item->normal_price)}}</td>
				<td>{{number_format($purchases->item->unit_price)}}</td>
				<td>{{number_format($purchases->total_price)}}</td>
                <td><strong>
                    @if($purchases->profit > 0)<span class="text-success">{{$purchases->profit}}</span>
                @else <span class="text-danger">{{$purchases->profit}}</span>
                @endif
                </strong>
                </td>
				</tr>
				@endforeach
			</tbody>
		</table>
</div>
@endsection