<?php if (!count(self::$data['items'])){?>

  <h1>Нет товаров!</h1>

<?php } else {?>

  <h1><?php echo self::$title ?></h1>

  <div class="container">

    <?php foreach (self::$data['items'] as $i => $item){?>

      <div class="col">
        <h2><?php echo $item['id'] . ': ' . $item['title'] ?></h2>

        <div class="image-wrap">
          <?php HTML::image('images/shop/thumbs/' . $item['id'], $item['title']) ?>
        </div>

        <b>Price: <span><?php echo $item['price'];?></span></b>

        <?php if (User::isAdmin())
        {
          HTML::link('shop-admin/update/id/' . $item['id'], 'edit', 'button');
        }
        else
        {
          HTML::link('shop-product/default/id/' . $item['id'], 'more', 'button');
        }

        HTML::link('shop-cart/add/id/' . $item['id'], 'add to cart', 'button');

        if (User::isAdmin())
        {
          HTML::link('shop-admin/delete/id/' . $item['id'], 'X', 'button delete');
        }?>

      </div>

    <?php }?>

  </div>

<?php }?>

<?php if (User::isAdmin()){

  HTML::beginForm('shop-admin/create/', false, 'file');?>

    <div class="row">
      <input type="text" name="title" placeholder="Title" required="required">
    </div>

    <div class="row">
      <input type="text" name="price" placeholder="Price" required="required">
    </div>

    <div class="row">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
      <input type="file" name="image">
    </div>

    <div class="row">
      <textarea name="description" placeholder="Description"></textarea>
    </div>

    <div class="row">
      <?php HTML::submit('Add the product', 'button', 'create');?>
    </div>

  <?php HTML::endForm();

}?>