@extends('layouts.app')
@section('title')
List of Purchases Made, Profit & Loss
@endsection
@section('content')
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2>
                        List of Purchases Made, Profit & Loss
                        </h2>
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
					<th>Category</th>
					<th>Amount Paid($)</th>
					<th>Profit($)</th>
				</tr>
			</thead>
			<tbody id="data_container">
				@foreach($purchases as $purchases)
				<tr>
				<td>{{$purchases->category}}</td>
				<td>{{number_format($purchases->amount_paid}}</td>
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