<?php

$datetimepicker_path = CMS::$root . 'components/booking/datetimepicker-master/';

?>
<!doctype html>
<html>
  <head>
    <meta charset="<?php echo $charset ?>">
    <title><?php echo CMS::$site_name ?> - <?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo CMS::$root ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $datetimepicker_path ?>jquery.datetimepicker.css">
  </head>

  <body>

    <header>
      
      <div class="hor-menu">
        <a href="<?php echo CMS::$root ?>shop-goods" class="button">Shop</a>
        <a href="<?php echo CMS::$root ?>shop-cart" class="button">Cart</a>
        
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']){?>
          
          <a href="<?php echo CMS::$root ?>shop-admin/logout" class="button">Log out</a>
        
        <?php } else {?>
        
          <form action="<?php echo CMS::$root ?>shop-admin/login" method="post">
            <input type="text" name="admin" placeholder="Admin" required="required">
            <input type="text" name="password" placeholder="Password" required="required">
            <input class="button" type="submit" name="login" value="Log in">
          </form>
        
        <?php }?>
      </div>

      <br><br>

      <div class="hor-menu">
        <a href="<?php echo CMS::$root ?>booking-rooms" class="button">Booking</a>
        <a href="<?php echo CMS::$root ?>booking-cart" class="button">Cart</a>
        
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']){?>
          
          <a href="<?php echo CMS::$root ?>booking-admin/logout" class="button">Log out</a>
        
        <?php } else {?>
        
          <form action="<?php echo CMS::$root ?>booking-admin/login" method="post">
            <input type="text" name="admin" placeholder="Admin" required="required">
            <input type="text" name="password" placeholder="Password" required="required">
            <input class="button" type="submit" name="login" value="Log in">
          </form>
        
        <?php }?>
      </div>

    </header>

    <main>
      <?php Template::renderComponent() ?>
    </main>

  </body>
  <script src="<?php echo $datetimepicker_path ?>jquery.js"></script>
  <script src="<?php echo $datetimepicker_path ?>build/jquery.datetimepicker.full.js"></script>
  <script>
    $.datetimepicker.setLocale('en');

    var logic = function( currentDateTime ){
      if (currentDateTime && currentDateTime.getDay() == 6){
        this.setOptions({
          minTime:'11:00'
        });
      }else
        this.setOptions({
          minTime:'8:00'
        });
    };

    // $('#datetimepicker7').datetimepicker({
    //   onChangeDateTime:logic,
    //   onShow:logic
    // });

    $('.start-date').datetimepicker({
      onGenerate:function( ct ){
        $(this).find('.xdsoft_date')
          .toggleClass('xdsoft_disabled');
      },
      minDate:'-1970/01/2',
      maxDate:'+1970/01/2',
      timepicker:false
    });

    $('.end-date').datetimepicker({
      onGenerate:function( ct ){
        $(this).find('.xdsoft_date')
          .toggleClass('xdsoft_disabled');
      },
      minDate:'-1970/01/2',
      maxDate:'+1970/01/2',
      timepicker:false
    });

  </script>
</html>