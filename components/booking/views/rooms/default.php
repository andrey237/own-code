<?php if (!count(self::$data['items'])){?>

  <h1>Нет товаров!</h1>

<?php } else {?>

  <h1><?php echo self::$title ?></h1>

  <div class="container">

    <?php foreach (self::$data['items'] as $i => $item)
    {
      $room_title = 'Номер ' . $item['number'] . ' : ' . $item['type'];
      $link_params = 'hotel-id/' . self::$data['hotel']['id'] . '/number/' . $item['number'];
      ?>

      <div class="col">
        <h2><?php echo $room_title ?></h2>

        <div class="image-wrap">
          <?php HTML::image('images/booking/thumbs/' . $item['number'], self::$data['hotel']['title'] . '. ' . $room_title) ?>
        </div>

        <b>Цена: <span><?php echo $item['price'];?></span></b>

        <?php if (User::isAdmin())
        {
          HTML::link('booking-admin/update/' . $link_params, 'Редактировать', 'button');
        }
        else
        {
          HTML::link('booking-number/default/' . $link_params, 'Подробнее', 'button');
        }

        HTML::link('booking-cart/add/' . $link_params, 'Добавить в корзину', 'button');

        if (User::isAdmin())
        {
          HTML::link('booking-admin/delete/' . $link_params, 'X', 'button delete');
        }?>

      </div>

    <?php }?>

  </div>

<?php }?>

<?php if (User::isAdmin()){

  HTML::beginForm('booking-admin/create/', false, 'file');?>

    <div class="row">
      <input type="number" name="number" placeholder="Number" required="required">
    </div>

    <div class="row">
      <select name="type_id" required>
        
        <?php foreach (self::$data['types'] as $i => $type){?>
          
          <option value="<?php echo $type['id'] ?>">
            <?php echo $type['title'] ?> : <?php echo $type['price'] ?>
          </option>

        <?php }?>

      </select>
    </div>

    <div class="row">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
      <input type="file" name="image">
    </div>

    <div class="row">
      <?php HTML::submit('Добавить номер', 'button', 'create');?>
    </div>

  <?php HTML::endForm();

}?>