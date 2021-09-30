@extends('layouts.app')
@section('title')
Add item to the store
@endsection
@section('content')
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Add item to the store</h2>
					</div>
                <a class="btn btn-success pull-right" href="{{route('index')}}">Visit Store</a>
                </div>
            </div>
            <form method="POST" id="new_item" action="#">
                @csrf
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Name</label>
                        <span class="item_name_err text-danger"></span>
                        <input id="item_name" name="item_name" type="text" class="form-control" placeholder="Item name">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <span class="category_err text-danger"></span>							
                        <input type="text" class="form-control" id="category" name="category" placeholder="Category">
                    </div>
                    <div class="form-group">
                        <label>Available unit</label>
                        <span class="available_unit_err text-danger"></span>							                        
                        <input type="text" id="available_unit" name="available_unit" class="form-control" placeholder="Available Unit">
                    </div>
                    <div class="form-group">
                        <label>Unit price</label>
                        <span class="unit_price_err text-danger"></span>							                        
                        <input type="text" id="unit_price" name="unit_price" class="form-control" placeholder="Unit Price">
                    </div>
                    <div class="form-group">
                        <label>Normal price</label>
                        <span class="normal_price_err text-danger"></span>							                        
                        <input type="text" id="normal_price" name="normal_price" class="form-control" placeholder="Normal Price">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add" placeholder="Normal Price">
                </div>
            </form>
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
        ////Listening to the SUBMIT event of the item registration form
        $('#new_item').on('submit', function(e){
            e.preventDefault();
            var item_name = $('#item_name').val();
            var category = $('#category').val();
            var available_unit = $('#available_unit').val();
            var unit_price = $('#unit_price').val();
            var normal_price = $('#normal_price').val();
            
            ////Stripping spaces to ensure that the user didn't only submit an input that contains only spaces
            item_name = item_name.replace(/^\s+/,'');
            category = category.replace(/^\s+/,'');
            available_unit = available_unit.replace(/^\s+/,'');
            unit_price = unit_price.replace(/^\s+/,'');
            normal_price = normal_price.replace(/^\s+/,'');
    
            ///////Clear the error displayed
            $('.item_name_err').html('')
            $('.category_err').html('')
            $('.available_unit_err').html('')
            $('.unit_price_err').html('')
            $('.normal_price_err').html('')
            ///Input validation
            if(item_name.length == 0){
                $('.item_name_err').html('Item name is required!');
            }
            else if(category.length == 0){
                $('.category_err').html('Category is required!');
            }
            else if(available_unit.length == 0){
                $('.available_unit_err').html('Available unit is required!');
            }
            else if(Math.floor(available_unit) != available_unit || $.isNumeric(available_unit) == false){
                // 
                $('.available_unit_err').html('Available unit must be a valid integer!');
            }
            else if(unit_price.length == 0){
                $('.unit_price_err').html('Unit price is required!');
            }
            else if(Math.floor(unit_price) != unit_price || $.isNumeric(unit_price) == false){
                // 
                $('.unit_price_err').html('Unit Price must be a valid integer!');
            }
            else if(normal_price.length == 0){
                $('.normal_price_err').html('Normal price is required!');
            }
            else if(Math.floor(normal_price) != normal_price || $.isNumeric(normal_price) == false){
                // 
                $('.normal_price_err').html('Normal Price must be a valid integer!');
            }
            /////AJAX Call to Laravel API to create a new Item
            var formData = $(this).serialize();
            // console.log(formData)
            $.ajax(
            {
                url: "{{route('item.store')}}",
                type: 'POST',
                dataType: "JSON",
                data: formData,
                success: function(response)
                {
                    if(response.status_message){
                    swal({
                    title: "New Item",
                    text: 'New Item Successfully Added!',
                    icon: 'success',
                    closeOnClickOutside: false,
                    });
                    }
                    else{
                    swal({
                    title: "New Item",
                    text: 'New Item Was Not Successfully Added!',
                    icon: 'error',
                    closeOnClickOutside: false,
                    });
                }
                }
               
            });
        });
</script>
@endsection