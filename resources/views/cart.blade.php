@extends('layouts.app')
@section('title')
Add item to the store
@endsection
@section('extra-styles')
<style>
*{
  box-sizing: border-box;
}
.shopping-cart{
  width: 50%;
  height: auto;
  margin: 5em auto;
  background: #FFF;
  box-shadow: 1px 2px 3px 0px rgba(0,0,0,0.10);
  border-radius: 0.5em;
  
  display: flex;
  flex-direction: column;
}

/* item styling */
.title{
  height: 3.75em;
  border-bottom: 1px solid #E1E8EE;
  padding: 1.25em 1.75em;
  color: #5E6977;
  font-size: 1.125em;
  font-weight:bold;
}
.item{
  padding: 1.25em 1.75em;
  height: 7.5em;
  display: flex;
}
.buttons{
  position: relative;
  padding-top: 1.75em;
  margin-right: 3.5em;
}
.is-active{
  animation-name: animate;
  animation-duration: .8s;
  animation-iteration-count: 1;
  animation-timing-function: steps(28);
  animation-fill-mode: forwards;
}

.description{
  padding-top: 10px;
  margin-right: 60px;
  width: 115px;
}
.description span{
  display: block;
  font-size: 1em;
  color: #43484D;
  font-weight: 400;
}
.description span:first-child{
  margin-bottom: 5px;
}
.description span:last-child{
  font-weight: 300;
  margin-top: 8px;
  color: #86939E;
}

.quantity{
  padding-top: 20px;
  margin-right: 60px;
}
.quantity input{
  -webkit-appearance: none;
  border: none;
  text-align: center;
  width: 32px;
  font-size: 1em;
  color: #43484D;
  font-weight: 300;
}
button[class*=btn] {
  width: 30px;
  height: 30px;
  background-color: #E1E8EE;
  border-radius: 6px;
  border: none;
  cursor: pointer;
}
.minus-btn img{
  margin-bottom: 3px;
}
.plus-btn img{
  margin-top: 2px;
}

button:focus,
input:focus{
  outline: 0;
}
.total-price{
  width: 83px;
  padding-top: 27px;
  text-align: center;
  font-size: 1em;
  color: #43484D;
  font-weight: 300;
}
/* media queries */
@media (max-width: 800px) {
  .shopping-cart{
    width: 100%;
    height: auto;
    overflow: hidden;
  }
  .item {
    height: auto;
    flex-wrap: wrap;
    justify-content: center;
  }
  .image img{
    width: 50%;
  }
  .image,
  .quantity,
  .description{
    width: 100%;
    text-align: center;
    margin: 6px 0;
  }
  .buttons{
    margin-right: 20px;
  }
 
}
input[type="radio"]{
      width: 20% !important;
  }
  label{
      float: left;
      padding-top: 12px;
      padding-right: 12px;
  }
  button[class*="btn"]{
      width: auto;
  }
  form{
      padding-bottom: 100px;
  }
  .btn-primary{
      background-color: #286090 !important;
  }
</style>
@endsection
@section('content')
                <div class="shopping-cart">
                <div class="title">
                <span id="title">Pay By Card</span>
                <span class="pull-right">Total Price: $<span id="total_price_text">{{number_format($item->normal_price)}}</span></span>
                </div>
                <div class="item">
                <div class="description col-md-4">
                   <strong>{{$item->item_name}}</strong>
                </div>

                <div class="quantity col-md-4">
                    <button class="minus-btn" type="button" name="button" id="minus">
                            <i class="fa fa-minus"></i>
                    </button>
                    <input type="text" name="name" value="1" id="quantity_text">
                    <button class="plus-btn" type="button" name="button" id="plus">
                            <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="total-price col-md-4">
                    <strong>${{number_format($item->normal_price)}}</strong></div>
                </div>
                <div class="col-md-12">
                    <form id="checkout_form">
                        @csrf
                    <div class="form-group col-md-6"> 
                    <input type="text" class="form-control" placeholder="Full name" id="buyer_name" name="buyer_name">
                    <input type="hidden" value="{{$item->normal_price}}" id="unit_price" name="unit_price">
                    <input type="hidden" value="1" id="quantity" name="quantity">
                    <input type="hidden" value="{{$item->normal_price}}" id="total_price" name="total_price">
                    <input type="hidden" value="{{$item->normal_price}}" id="default_price">
                    </div>
                    <div class="form-group col-md-3">  
                    <label>Card</label>
                    <input type="radio" class="form-control" name="payment_type" value="card" checked> 
                    </div>
                    <div class="form-group col-md-3">                    
                    <label>Token</label>    
                    <input type="radio" name="payment_type" class="form-control" value="token">
                    </div> 
                    <div class="form-group col-md-6"> 
                        <input type="text" class="form-control" id="payment_number" placeholder="Enter Your Card Number">
                    </div> 
                    <button type="submit" name="pay_now" class="btn btn-primary pull-right">Pay</button>
                    </form>              
                </div>
                </div>
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
    $('#plus').on('click', function (e) {
        var quantity_text = parseInt($('#quantity_text').val()) + 1;
        var total_price = parseInt($('#total_price').val());
        total_price = $('#default_price').val() * quantity_text;
        $('#quantity_text').val(quantity_text);
        $('#quantity').val(quantity_text);
        $('#total_price').val(total_price);
        $('#total_price_text').html(total_price.toLocaleString());
      });
      $('#minus').on('click', function (e) {
        var quantity_text = parseInt($('#quantity_text').val()) - 1;
        var total_price = parseInt($('#total_price').val());
        if(quantity_text <= 0){
            quantity_text = 1;
        }
        $('#quantity_text').val(quantity_text);
        $('#quantity').val(quantity_text); 
        if(quantity_text == 0){
            quantity_text = 1;
        } 
        total_price = $('#default_price').val() * quantity_text;
        $('#total_price').val(total_price);
        $('#total_price_text').html(total_price.toLocaleString());      
      });
    $('input[name="payment_type"]').on('change', function(){
       var payment_type = $(this).val();
       if(payment_type == 'card'){
        $('#payment_number').attr("placeholder", "Enter Your Card Details Here");
        $('#title').html('Pay By Card');
       }
       else{
        $('#payment_number').attr("placeholder", "Enter Your Token Here");
        $('#title').html('Pay By Token');        
       }
    })
    //   
    $('#checkout_form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var unit_price = $('#unit_price').val(); 
        var quantity = $('#quantity').val();   
        var total_price = $('#total_price').val();   
        var default_price = $('#default_price').val();   
        var payment_type = $('input[name="payment_type"]:checked').val(); 
        var payment_number = $('#payment_number').val(); 
        var buyer_name = $('#buyer_name').val(); 
        payment_number = payment_number.replace(/^\s+/,'');
        buyer_name = buyer_name.replace(/^\s+/,'');
        if(payment_type == 'card'){
            var digits_limit = 16;
            if(payment_number.length != digits_limit){
                alert('Inavlid card number. The card number should be 16 digits but you have '+payment_number.length+' digits');
            return
            }
        }  
        else{
            var digits_limit = 8;
            if(payment_number.length != digits_limit){
                alert('Inavlid Token. The token should be 8 digits but you have '+payment_number.length+' digits');
                return            
            }
        }
        if(buyer_name.length == 0){
            alert('Buyer name is required');
            return            
        }
        else{
            $.ajax(
            {
                url: "{{route('item.buy',$item->id)}}",
                type: 'POST',
                dataType: "JSON",
                data: formData,
                success: function(response)
                {
                    // console.log(response)
                    if(response.status_message){
                    swal({
                    title: "New Purchase",
                    text: 'New Purchase Successfully Added!',
                    icon: 'success',
                    closeOnClickOutside: false,
                    });
                    }
                    else{
                    swal({
                    title: "New Purchase",
                    text: 'New Item Was Not Successfully Added!',
                    icon: 'error',
                    closeOnClickOutside: false,
                    });
                }
                }
               
            });
        }

      });
</script>
@endsection