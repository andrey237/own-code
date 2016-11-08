<?php if (!self::$data['item']){?>

  <h1>There is no product!</h1>

<?php } else {

  $description = !is_null(self::$data['item']['description']) ? self::$data['item']['description'] : 'There is no description.';
?>

  <h1><?php echo self::$title ?></h1>

  <div class="container">

    <div class="col col2">
      <h2><?php echo self::$data['item']['id'] . ': ' . self::$data['item']['title'];?></h2>

      <div class="image-wrap">
        <?php HTML::image('images/products/' . self::$data['item']['id'], self::$data['item']['title']) ?>
      </div>

      <b>Price: <span><?php echo self::$data['item']['price'] ?></span></b>

      <?php HTML::link('shop-goods/', 'back', 'button') ?>
      <?php HTML::link('shop-cart/add/id/' . self::$data['item']['id'], 'add to cart', 'button') ?>
    </div>

    <div class="col col2">
      <p><?php echo $description ?></p>
    </div>

  </div>

<?php }?>