Hi <?php echo $name; ?>,
<br><br>
You have requested reset password link. You can use this <a href="<?php echo URL::to('/resetPassword/' . $token) ?>">link</a> to reset your password.
<br><br>
It'll expire if you don't use it in 24 hours period of time.
<br><br>
Thanks