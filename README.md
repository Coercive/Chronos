Coercive Chronos Log Utility
============================

The Chronos utility.

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
