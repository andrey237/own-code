<!doctype html>
<html>
  <head>
    <meta charset="<?php echo $charset ?>">
    <title><?php echo CMS::$siteName ?> - <?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo CMS::$root ?>css/style.css">
  </head>

  <body>

    <header class="hor-menu">
      <a href="<?php echo CMS::$root ?>goods/read" class="button">Goods</a>
      <a href="<?php echo CMS::$root ?>cart/read" class="button">Cart</a>

      <?php if (isset($_SESSION['admin']) && $_SESSION['admin']){?>
        
        <a href="<?php echo CMS::$root ?>admin/logout" class="button">Log out</a>

      <?php } else {?>
        
        <form action="<?php echo CMS::$root ?>admin/login" method="post">
          <input type="text" name="admin" placeholder="Admin" required="required">
          <input type="text" name="password" placeholder="Password" required="required">
          <input class="button" type="submit" name="login" value="Log in">
        </form>

      <?php }?>

    </header>

    <main>
      <?php Template::renderComponent() ?>
    </main>

  </body>
</html>