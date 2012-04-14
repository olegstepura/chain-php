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

So probably you won't like to use this. If find this useful for anything,
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

Output of measurement results
-----------------------------

Measured 100 iterations on elements with 1000 items om a Linux Gentoo PC with
Intel Pentium 4 3.0 Ghz and 2 Gb of memory:

``` bash
string(25) "Iterating, raw PHP array:"
double(0.78241920471191)
string(17) "Iterating, Chain:"
double(8.0767850875854)
string(29) "Random access, raw PHP array:"
double(0.00027799606323242)
string(21) "Random access, Chain:"
double(0.11190104484558)
```

You can test speed yourself - just uncomment `$measure = true;` in
`ChainTest::testSpeed()` in tests folder and run `phpunit`.

License
-------
Copyright (c) 2012 Oleg Stepura

Work is licensed under the MIT license. For the full copyright and license
information, please view the LICENSE file that was distributed with this source code.
