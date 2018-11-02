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

# Monitor a sleep
Chronos::start('sleep');
sleep(2);
Chronos::stop('sleep');

# Monitor some code process
Chronos::start('sha1');
$datas = [];
foreach (range(0,1000000) as $i) {
	$datas[] = sha1($i);
}
Chronos::stop('sha1');

# Monitor an other code process
Chronos::start('concat');
foreach($datas as &$data) {
	$data .= '_add_datas_' . rand(0,1000);
}
Chronos::stop('concat');

# Monitor an other code process
Chronos::start('rand_waits');
foreach (range(0,5) as $secondes) {
	sleep($secondes);
	Chronos::lap('sleeps', 'Waiting ' . $secondes . ' secondes');
}
Chronos::stop('rand_waits');

# And now : retrieve monitoring datas !

# Full diff of all process
error_log(print_r(Chronos::diff(), true));

# Diff of sha1 process
error_log(print_r(Chronos::diff('sha1'), true));

# Diff of concat process
error_log(print_r(Chronos::diff('concat'), true));

# Retrieve full datas as array
error_log(print_r(Chronos::get(), true));
```
