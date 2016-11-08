<?php if (!count(self::$data['items'])){?>

  <h1>Cart is empty!</h1>

<?php } else {?>

  <h1><?php echo self::$title;?></h1>

  <?php HTML::beginForm('shop-cart/change/', 'post', 'cart');?>

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
            Price: <span><?php echo $values['price'];?></span> X

            <input type="number" name="cart[<?php echo $id;?>]" value="<?php echo $values['count'];?>"> =

            <?php echo $values['total_price'];?>
          </div>

          <?php HTML::link('shop-cart/delete/id/' . $id, 'X', 'button delete');?>

        <?php }?>

      </div>

    <?php }?>

    <div class="row total-price">
      Total price: <?php echo self::$data['total_price'];?>
    </div>

    <div class="row hor-menu">
      <?php HTML::submit('Recalculate', 'button', 'send');?>
      <?php HTML::link('shop-cart/order/', 'Order', 'button');?>
    </div>

  <?php HTML::endForm();?>

<?php }?>