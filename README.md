FuelPHP-Messages
================

Messages package for FuelPHP. Allows you to easily log and report messages.

     Messages::info('This is my message.');
     Messages::info('Hello', 'This is my message.');     
     Messages::error('Printer on fire!', 'Unable to determine why the printer is not responding.');
     
It is inspired by the [Message package by dbpolito](https://github.com/dbpolito/Fuel-Message). There are however a few key differences:

* Deferred rendering. The `Messages::get` method returns an array of View instances rather than a string.
* JSON and XML rendering of messages.
* Messages are rendered in the order they are logged irrelevant of the message type (e.g. info or error).
* An optional title can be passed to the message methods. `Messages::error('title', 'full message')`
* Support for block or thin Bootstrap alerts.

Just like dbpolito's Message package the generated HTML makes use of [Bootstrap](http://twitter.github.com/bootstrap) CSS classes

Usage
=====

Registering messages
====================

By defaul four types of messages can be registered:

    Messages::info('this is an information message');
    Messages::warning('something is not right');
    Messages::error('something is really wrong';
    Messages::success('what you just did worked');

You can provide an option message title by passing two arguments:

    Messages::warning('Invalid email address', 'The email address <em>foo@bar</em> is not a valid email address.');

Rendering messages
==================

The `Messages::get()` method returns an array of View instances. You can use it in the following way in your FuelPHP controller:

    public function action_index() {
        // ...
        
        $view = \View::forge('myview');
        $view->messages = Messages::get();
        
        // ...
        return \Response::forge($view);
    }

And in you `myview.php` template:

    <?php foreach ($messages as $msg) { echo $msg; } ?>

The `Messages::get()` method accepts an argument to just return messages of a given tyoe:

    Messages::get('info');
    
An option second argument can be used override the default behavior of clearing the returned messages:

    // does not remove the message entries
    Messages::get('info', false); 
    
    // this will remove the message entries
    Messages::get('error', true);
    
Besides the HTML views you can also get views that produce JSON or XML for each message entry using the methods `Messages::get_json()` and `Messages::get_xml()` respectivly. The accept the same arguments as the normal get method.

The JSON response has the following format:

     {
          'type' : 'info',
          'timestamp' : 'seconds since UNIX epoch',
          'title' : 'the optional title',
          'message' : 'the message'
     }

The XML response as the following format:

     <message type="type" timestamp="seconds since UNIX epoch">
          <title><[CDATA[optional title]]></title>
          <text><[CDATA[the actual message content]]></text>
     </message>

Configuration
=============
*TODO*

Other methods
=============

Clearing all messages
---------------------

`Messages::clear()`


Getting the raw messages entries
----------------------------

`Messages::getEntries($type="")`

