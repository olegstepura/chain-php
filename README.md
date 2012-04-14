Chain
=====
This was a test project to test the speed of native PHP arrays vs. a chain
implemented in pure PHP objects. Two classes are used: one as wrapper for a chain
itself and one as each chain element holder. It doesn't utilize arrays internally.

The results are: Iterating over `Chain` is 10 times slower than over native PHP
array implementation even that PHP's arrays are hashes by it's nature.
It's even about 6-8 times slower than PHP class wrapper of an array.
Random access is more than 200 times slower than in random access to elements
in raw PHP arrays.

You can test speed yourself - just uncomment `$measure = true;` in
`ChainTest::testSpeed()` in tests folder and run `phpunit`.

So probably you won't like to use this. If find this usefull for anything,
please let me know the use-case.


API
---

API is simple.

``` php
<?php
use Ost\Chain\Chain;

// create a chain with an element in it
$chain = new Chain('test');
// add some more
$chain->add('test1')
    ->add('test2')
    ->add('test3');

// or create an empty chain
$chain = new Chain();
// and add some element to it
$chain->add(new DateTime('now'))
    ->add(new DateTime('+1 week'))
    ->add(new DateTime('+1 month'));
```

License
-------
Copyright (c) 2012 Oleg Stepura

Work is licensed under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source code.
