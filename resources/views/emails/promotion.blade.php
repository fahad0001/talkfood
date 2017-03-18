<div style="background:#fff;text-align:center;"><img style="width:100px;" src="{{URL::to('img/logo.png')}}" /></div>
Hi <?php echo $name; ?>,
<br><br>
You can use this promo code <?php echo $code; ?> in your checkout to get free delivery.
<br><br>
You can use it <?php echo $usage ? 'once' : 'many times'; ?> till it expiry date <?php echo $expiry; ?>
<br><br>
Thanks<br/>
website: <a href="{{URL::to('/')}}">{{URL::to('/')}}</a>