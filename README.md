Coercive Chronos Log Utility
============================

The Chronos Log Utility allows you to accurately measure the execution time of a script, and that from the server startup.

Get
---
```
composer require coercive/chronos
```

Usage
-----
```php
use Coercive\Utility\Chronos

# INIT
Chronos::projectName('your project name');

# ONE SHOT
Chronos::single();

# INTERVAL
Chronos::interval();

/**
 * ...
 * Some code
 * ...
 */
 
 Chronos::interval();

```
