@extends('customer.layout.master')
@section('style')
<style>

    .navbar-default .nav>li>a, .navbar-default .nav>li>a {
        color: #222 !important;
    }
    body {
        background-color: #f5f5f5 !important;
    }
    b, strong {
        font-weight: 500 !important;
    }

    .rest {
        color:#222;
    }
    
    


.clabel {
  position: relative;
  color: #8798AB;
  display: block;
  margin-top: 30px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column-reverse;
}

.clabel > span {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  font-weight: 300;
  line-height: 32px;
  color: #8798AB;
  border-bottom: 1px solid #586A82;
  transition: border-bottom-color 200ms ease-in-out;
  cursor: text;
}

.clabel > span span {
  position: absolute;
  top: 0;
  left: 0;
  transform-origin: 0% 50%;
  transition: transform 200ms ease-in-out;
  cursor: text;
}

.clabel .field.is-focused + span,
.clabel .field:not(.is-empty) + span {
  pointer-events: none;
}

.clabel .field.is-focused + span span,
.clabel .field:not(.is-empty) + span span {
  transform: scale(0.68) translateY(-36px);
  cursor: default;
}

.clabel .field.is-focused + span {
  border-bottom-color: #34D08C;
}

.field {
  background: transparent;
  font-weight: 300;
  border: 0;
  color: black;
  outline: none;
  cursor: text;
  display: block;
  width: 100%;
  line-height: 32px;
  padding-bottom: 3px;
  transition: opacity 200ms ease-in-out;
}

.field::-webkit-input-placeholder { color: #8898AA; }
.field::-moz-placeholder { color: #8898AA; }

.field.is-empty:not(.is-focused) {
  opacity: 0;
}

.cbutton {
  float: left;
  display: block;
  background: #34D08C;
  color: white;
  border-radius: 2px;
  border: 0;
  margin-top: 20px;
  font-size: 19px;
  font-weight: 400;
  width: 100%;
  height: 47px;
  line-height: 45px;
  outline: none;
}

.cbutton:focus {
  background: #24B47E;
}

.cbutton:active {
  background: #159570;
}

.outcome {
 
  width: 100%;
  padding-top: 8px;
  min-height: 20px;
  text-align: center;
}

.success, .error {
  display: none;
  font-size: 15px;
}

.success.visible, .error.visible {
  display: inline;
}

.error {
  color: #E4584C;
}

.success {
  color: #34D08C;
}

.success .token {
  font-weight: 500;
  font-size: 15px;
}
    

</style>
@endsection
@section('content')
@include('customer.layout.navigation2')

<section style="padding-top:70px;">

    <div class='container' >


        <div class='row'>
            <div class='col-sm-12' style='background-color: white; padding-top:10px;padding-bottom:10px;min-height:500px;'>
                <h2>Cart</h2>
                @if(Session::has('cart') )
                <div class="table-responsive">

                    <form action="{{URL::to('/updatecart')}}" method="POST" >
                        <table class="table table-bordered">
                            <thead>
                                <tr> <th></th> <th>Item Name</th> <th>Item Description</th> <th>Item Quantity</th> <th>Item Price</th> </tr>
                            </thead> 
                            <tbody>

                                {{csrf_field()}}
                                <?php $i = 1; ?>
                                @foreach($cart as $item) 
                                @if(!is_array($item))

                                @else
                                <tr> <th scope="row"><a href="{{URL::to('/cart/delete')}}/{{$item['key']}}"><i class='fa fa-2x fa-close' style="color:red;"></i></a></th>
                                    <td>{{ $item['food_name'] }}
                                        @if($item['submenu_status']==1)
                                        @foreach($item['subitem'] as $s)
                                        <p style='font-size:12px;'>
                                            {{$s['option']}} : {{$s['name']}}
                                        </p>
                                        @endforeach
                                        @endif

                                    </td> 
                                    <td>{{ $item['food_desc'] }}</td> 
                                    <td><input type='number' name="items[{{$item['key']}}]" value='{{ $item['quantity'] }}' /></td> 

                                    <td>$ 
                                        @if($item['submenu_status']==1) 
                                            <?php $totali=$item['food_price'];?>
                                            <?php $sub=0; ?>
                                            @foreach($item['subitem'] as $is)
                                                <?php $sub=$sub+$is['price']?>
                                            
                                            @endforeach
                                             {{ $totali+$sub }}
                                       
                                        @else {{$item['food_price']}}

                                        @endif </td>

                                </tr> 
                                @endif
                                @endforeach


                            </tbody>


                        </table>
                        <div class="col-sm-4"><input type="text" name="promo_code" class="form-control" value="@if(isset($cart['promo_code'])){{$cart['promo_code']}}@endif" placeholder="Put the promo code here and update cart" /></div>
                        <button class="btn btn-primary" type="submit" >Update Cart</button>
                        <a class="btn btn-primary" href="{{URL::to('/')}}/rest/{{Session::get('currentrest')}}"> Continue Shopping </a>
                    </form>
                </div>
                <form action="{{ URL::to('/cart/checkout')}}" id="ad" method="POST">
                    <div class="col-md-8 "> 
                        {{csrf_field()}}
                        <h3><b>Is Delivery Address Same as Home Address?</b> <input type="checkbox" name="addresstype" id="delivery_check"></h3> 
                        <div id="delivery_tab" >        
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="street">Street</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control" id="street" name="street" placeholder=" Street" data-parsley-required>
                                </div>
                                <label class="control-label col-sm-2" for="city">City</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control" name="city" placeholder=" City" data-parsley-required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="state">State/Province</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control" name="state" placeholder=" State/Province" data-parsley-required>
                                </div>
                                <label class="control-label col-sm-2" for="country">Country</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control" name="country" placeholder=" Country" data-parsley-required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="zip">Zip/Postal Code</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control" name="zip" placeholder=" Zip/Postal Code" data-parsley-required>
                                </div>
                                <label class="control-label col-sm-2" for="phone">Phone Number</label>
                                <div class="col-sm-4" style="margin-bottom:20px;">
                                    <input type="text" class="form-control " name="phone" placeholder=" Phone Number" data-parsley-required>
                                </div>
                            </div>
                        </div>






                    </div>

                    <div class='col-md-4 '>
                        <h1><b>Cart Totals</b></h1>
                        <div class="table-responsive">
                            <table class="table table-bordered"> 

                                <tbody>
                                    <tr>
                                        <td> <h4><b>Subtotal </b> </h4></td> 
                                        <td style='    vertical-align: middle;'>

                                            ${{ $subtotal }} CAD
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td> <h4><b>Delivery Fee </b> </h4></td> <td style='    vertical-align: middle;'>${{$shipping}} CAD</td> 
                                    </tr>
                                    <tr>
                                        <td> <h4><b>Delivery Tax </b> </h4></td> <td style='    vertical-align: middle;'>${{$shippingtax}} CAD</td> 
                                    </tr>
                                    <tr>
                                        <td> <h4><b>Tax </b> </h4></td> <td style='    vertical-align: middle;'>${{$tax}} CAD</td> 
                                    </tr>
                                    <tr>
                                        <td> <h4><b>Driver Tip<span id="dtip">(2.5 $CAD)</span></b> </h4></td> <td style='vertical-align: middle;'>$<span id="dtipv">{{$drivertip}}</span> CAD <button id="tipchange" class="btn btn-primary" > Change</button> </td> 
                                    </tr>
                                    <tr>
                                        <td> <h4><b>Total </b> </h4></td> <td style='    vertical-align: middle;'>$<span id="tt">{{$total}}</span> CAD</td> 
                                    </tr>
                                </tbody> 


                            </table>
                            <div class="modal fade"  id="myModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Change Tip</h4>
                                        </div>
                                        <div class="modal-body" style="text-align:center;">

                                            <div class="btn-group" data-toggle="buttons" style="width:270px;">
                                                <label class="btn btn-primary active" >
                                                    <input type="radio" name="options" id="option1"  value="2.5" checked> 2.5$
                                                </label>
                                                <label class="btn btn-primary ">
                                                    <input type="radio" name="options" id="option2"   value="10" />10%(Recommended)
                                                </label>

                                            </div>

                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            
                            
                            
                               <div class="modal fade" id="checkout" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkout">Payment Information</h4>
      </div>
      <div class="modal-body text-center" >
          
          <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="paymentmethod" id="option3" autocomplete="off" value="cod" checked> Credit/debit on Delivery
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="paymentmethod" id="option4" autocomplete="off" value="cdc"> Credit/Debit Card
  </label>
  
</div>
                      <div id="checkoutform">
    <label class="clabel">
      <input name="cardholder-name" id="cardhname" class="field is-empty" placeholder="Jane Doe" />
      <span><span>Name</span></span>
    </label>
   
    <label class="clabel">
      <div id="card-element" class="field is-empty"></div>
      <span><span>Card</span></span>
    </label>
    <button type="submit">Pay $25</button>
    <div class="outcome">
      <div class="error"></div>
      <div class="success" style="overflow: hidden;">
        Success! Your Stripe token is <span class="token"></span>
      </div>
    </div>
  </div>
          <div id="codform">
          		<h3><b>NO CASH PAYMENT</b> </h3>
                 <button class="btn btn-danger" id="codsubmit" style='width:250px; margin:20px auto;'>Place Order<i class='fa fa-arrow-right'></i></button>
                     
          </div>
      </div>
     
    </div>
  </div>
</div>
                            
                            <!--<button class="btn btn-primary" type="submit" style='width:100%;'>Place Order<i class='fa fa-arrow-right'></i></button>-->
                         <button type="button" class="btn btn-primary btn-lg" id="checkoutm">
Place Order<i class='fa fa-arrow-right'></i>
</button>
                         
                        </div>





                </form>







            </div>
                    
                    
      
                    
                    
                 
                    

            @else 

            <H1>Cart is empty !</H1>

            @endif



        </div>

    </div>

</div>


</div>

<div class="overlay" style="position: fixed;display:none;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #666;
    background-image: url(http://test.talkfood.ca/img/loading.gif);
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;">


</div>
</section>



@endsection


@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function () {
         $("#checkoutform").hide();
        
        
          $("#tipchange").click(function(e){
              e.preventDefault();
              
              $("#myModal").modal('show');
          });
        
        $("#checkoutm").click(function(e){
               e.preventDefault();
            if ($("#delivery_tab").css('display') == "none") {
            
           $('#checkout').modal('toggle');
            }
            else {
                $('#ad').parsley().validate();
            }
        });
        
    @if (Session::has('cart'))
            var ttip = 2.5;
    $("#tt").text(({{$total}} + ttip).toFixed(2));
    @endif

            $('#ad').parsley();
    $("#delivery_check").click(function () {
    $("#delivery_tab").toggle();
    if ($("#delivery_tab").css('display') == "none") {

    $('#ad').parsley().destroy();
    }
    else {
    $('#ad').parsley();
    }
    });
    @if (Session::has('cart'))
            $("#option1").change(function(){
    // Do something interesting here
    var tip = 2.5;
    $("#dtipv").text((tip).toFixed(2));
    $("#dtip").text("(2.5 $CAD)");
    $("#myModal").modal('hide');
    $("#tt").text(({{$total}} + tip).toFixed(2));
    });
    $("#option2").change(function(){
    // Do something interesting here
    var tip = (10 / 100) * {{$subtotal}};
    $("#dtipv").text((tip).toFixed(2));
    $("#dtip").text("(10%)");
    $("#myModal").modal('hide');
    $("#tt").text(({{$total}} + tip).toFixed(2));
    });
    
    
     $("#option3").change(function(){
    // Do something interesting here
      $("#codform").show();
    $("#checkoutform").hide();
    });
    $("#option4").change(function(){
    // Do something interesting here
     $("#codform").hide();
   $("#checkoutform").show();
    });
    
    
    
    
    
    
    
    @endif




var stripe = Stripe('pk_live_TwD7bMEIBmwYykoxuUIOllC2');
var elements = stripe.elements();

var card = elements.create('card', {
  iconStyle: 'solid',
  style: {
    base: {
      iconColor: '#8898AA',
      color: 'black',
      lineHeight: '36px',
      fontWeight: 300,
      fontFamily: 'Helvetica Neue',
      fontSize: '19px',

      '::placeholder': {
        color: '#8898AA',
      },
    },
    invalid: {
      iconColor: '#e85746',
      color: '#e85746',
    }
  },
  classes: {
    focus: 'is-focused',
    empty: 'is-empty',
  },
  hidePostalCode:true,
});

card.mount('#card-element');
$("#checkoutform button").addClass("btn btn-primary");
$("#checkoutform button").html("Pay($ "+$("#tt").text()+")");
var inputs = Array.from(document.querySelectorAll('input.field'));
inputs.forEach(function(input) {
  input.addEventListener('focus', function() {
    input.classList.add('is-focused');
  });
  input.addEventListener('blur', function() {
    input.classList.remove('is-focused');
  });
  input.addEventListener('keyup', function() {
    if (input.value.length === 0) {
      input.classList.add('is-empty');
    } else {
      input.classList.remove('is-empty');
    }
  });
});

function setOutcome(result) {
 // var successElement = document.querySelector('.success');
  var errorElement = document.querySelector('.error');
 // successElement.classList.remove('visible');
  errorElement.classList.remove('visible');

  if (result.token) {
    // Use the token to create a charge or a customer
    // https://stripe.com/docs/charges
  //  successElement.querySelector('.token').textContent = result.token.id;
    $("#checkoutform").append($('<input type="hidden" name="Stripetoken" />').val(result.token.id));
   // alert("Asd");
   // successElement.classList.add('visible');
    $("#ad").submit();
  } else if (result.error) {
        $(".overlay").hide();
    errorElement.textContent = result.error.message;
    errorElement.classList.add('visible');
  }
}

card.on('change', function(event) {
  setOutcome(event);
});





$("#ad").on("submit", function(e){
    
    
      if($('#option4').is(':checked')) {  
    if($("#checkoutform").find('input[name=Stripetoken]').length) {
    
  //  alert("Asdasd");
    
  
  }
  
  else {
        //  alert("Test");
          $(".overlay").show();
  e.preventDefault();
  //var form = $("#checkoutform");
  var extraDetails = {
    name: $('#cardhname').val(),
  };
  console.log(extraDetails);
  stripe.createToken(card, extraDetails).then(setOutcome);
      
        }
    }
    else if($('#option3').is(':checked')){
         $(".overlay").show();
    }
});




    });

</script>
@endsection  