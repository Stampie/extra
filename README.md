# Stampie

[![Build Status](https://secure.travis-ci.org/stof/StampieExtra.png)](http://travis-ci.org/stof/StampieExtra)

StampieExtra provides an event-based extension point for [Stampie](https://github.com/henrikbjorn/Stampie).
It uses the Symfony2 EventDispatcher component.

## Usage

The StampieExtra mailer wraps your Stampie mailer to provides extension points
in the sendign process.

``` php
<?php

// include the Composr autoloading
require 'vendor/autoload.php';

$adapter = new Stampie\Adapter\Buzz(new Buzz\Browser());
$innerMailer = new Stampie\Mailer\SendGrid($adapter, 'username:password');

$dispatcher = new Symfony\Component\EventDispatcher\EventDispatcher();
$mailer = new Stampie\Extra\Mailer($innerMailer, $dispatcher);

$message = // Create your Stampie message

$mailer->send($message);
```

The mailer will then dispatch the `stampie.pre_send` event before sending
the message, allowing you to apply some changes.

## Built-in listeners

### ImpersonateListener

The ImpersonateListener allows you to replace the recipient of the mail during
development to send all messages to a single email address. It will add a
`X-Stampie-To` header containing the original recipient.


``` php
<?php
$dispatcher->addEventSubscriber(new Stampie\Extra\EventListener\ImpersonateListener('stof@notk.org'));
```

## SpoolMailer

StampieExtra also provides a SpoolMailer storing the messages in memory and
sending them when flushing the queue.

```php
<?php

$mailer = // Create your mailer...
$spoolMailer = new Stampie\Extra\SpoolMailer($mailer);

$message = // Create your Stampie message...
$spoolMailer->send($message);

// Do some logic, for instance flushing the response to the user

// Flush the queue, sending the message with the inner mailer
$spoolMailer->flushQueue();
```

## Testing

StampieExtra is [Continuous Integration](http://en.wikipedia.org/wiki/Continuous_integration)
tested with [Travis](http://travis-ci.org) and aims for a high coverage percentage.
