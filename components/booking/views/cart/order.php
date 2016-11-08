<?php if (!count(self::$data['items'])){?>

  <h1>Cart is empty!</h1>

<?php } else {?>

  <h1><?php echo self::$title;?></h1>

  <?php HTML::beginForm('booking-cart/exec-order/', 'post', 'cart');?>

    <?php foreach (self::$data['items'] as $id => $values){?>

      <div class="row">

        <?php if (isset($values['error'])){?>

          <h2 class="error"><?php echo $id . ': ' . $values['title'];?></h2>

        <?php }else{?>

          <h2 class="col"><?php echo $id . ': ' . $values['title'];?></h2>

          <div class="col image-wrap">
            <?php HTML::image('images/products/thumbs/' . $id, $item['title']);?>
          </div>

          <div class="col">
            Price: <span><?php echo $values['price'];?> X

            <?php echo $values['count'];?> =

            <?php echo $values['total_price'];?></span>
          </div>

        <?php }?>

      </div>
  
    <?php }?>

    <div class="row">
      Total price: <?php echo self::$data['total_price'];?>
    </div>

    <div class="row">
      <input type="text" name="fio" placeholder="FIO *" required="required">
    </div>

    <div class="row">
      <input type="phone" name="phone" placeholder="Phone *" required="required">
    </div>

    <div class="row">
      <input type="email" name="email" placeholder="E-mail *" required="required">
    </div>

    <div class="row">
      <textarea placeholder="comment"></textarea>
    </div>

    <div class="row hor-menu">
      <?php HTML::submit('Execute the order', 'button', 'send');?>
    </div>

  <?php HTML::endForm();?>

<?php }?>