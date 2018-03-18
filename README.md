## Example

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use CodeTimer\CodeTimer;
// start global timer
$codeTimer = new CodeTimer();
//... code ...
// start first block
$codeTimer->runBlock('first block');
//... code ...
// stop first block
$codeTimer->stopBlock('first block');
//... code ...
// global checkpoint (start global timer)
print_r($codeTimer->checkPoint());
//... code ...
// start second block
$codeTimer->runBlock('second block');
//... code ...
// global checkpoint (start global timer)
print_r($codeTimer->checkPoint());
//... code ...
// stop second block
$codeTimer->stopBlock('second block');
//... code ...
print_r($codeTimer->blockInfo('first block'));
print_r($codeTimer->blockInfo('second block'));

// output to the browser console
$codeTimer->blockToBrowser('first block');
$codeTimer->checkPointToBrowser();
```