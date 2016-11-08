<?php

return array(
	'application_path' => CMS_APPLICATION_PATH,
	'name' => 'Internet Shop',
  'root_dir' => '/cms.test/',

  'defaults' => array(
  	// 'controller' => 'shop-goods',
    'controller' => 'booking-rooms',
    'action' => 'default',
    'template' => 'default'
  ),

	'db' => array(
    'prefix' => 'rs',
		'connection_string' => 'mysqli://root:@localhost/shop?charset=utf8'
	),

  'admin' => array(
    'path' => 'admin',
    'default_controller' => 'system-login'
  )
);