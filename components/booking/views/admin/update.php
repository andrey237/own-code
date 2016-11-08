<?php if (!self::$data['item']){?>

  <h1>There is no product!</h1>

<?php } else {?>

  <h1><?php echo self::$title;?></h1>

  <?php HTML::beginForm('booking-admin/update/id/' . self::$data['item']['id'], 'container', 'file');?>

    <div class="col col2">
      <h2><?php echo self::$data['item']['id'] . ': ' . self::$data['item']['title'];?></h2>

      <div class="image-wrap">
        <?php HTML::image('images/products/' . self::$data['item']['id'], $item['title']);?>
      </div>

      <input type="text" name="title" value="<?php echo HTML::htmlEscapeStr(self::$data['item']['title']);?>" required="required">

      <input type="text" name="price" value="<?php echo HTML::htmlEscapeStr(self::$data['item']['price']);?>" required="required">

      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
      <input type="file" name="image">

      <?php HTML::submit('Edit the product', 'button', 'update');?>
    </div>

    <div class="col col2">
      <textarea name="description"><?php echo HTML::htmlEscapeStr(self::$data['item']['description']);?></textarea>
      <?php HTML::link('booking-admin/delete/id/' . self::$data['item']['id'], 'X', 'button delete');?>
    </div>

  <?php HTML::endForm();

}?>