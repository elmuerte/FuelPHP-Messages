<?php
/**
 * FuelPHP Messages
 * "MIT License"
 * Copyright 2013 Michiel Hendriks <elmuerte@drunksnipers.com>
 */

Autoloader::add_core_namespace('Messages');

Autoloader::add_classes(array(
'Messages\\Messages' => __DIR__ . '/classes/messages.php',
'Messages\\MessageEntry' => __DIR__ . '/classes/messageentry.php',
));
