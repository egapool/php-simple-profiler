# SIMPLE PROFILER

ver 0.01

## Usage

```php
$sp = new SimpleProfiler(time());
$sp->start('hoge');
$sp->start('hoge2');
usleep(3000);
$sp->end('hoge2');
for ( $i=0;$i<4;$i++) {
	$sp->start('hoge3');
	usleep(300000);
	$sp->end('hoge3');
}
$sp->end('hoge');
```

output

```

----START------( 49772-04-11 03:22:36 )------
label  : S-E間のms / Initからのms (unixtimestamp)
[S] hoge : 0 / 0 (1508494126956)
[S]  hoge2 : 0 / 0 (1508494126956)
[E]  hoge2 : 3 / 3 (1508494126959)
[S]  hoge3 : 0 / 3 (1508494126959)
[E]  hoge3 : 302 / 305 (1508494127261)
[S]  hoge3 : 0 / 305 (1508494127261)
[E]  hoge3 : 305 / 610 (1508494127566)
[S]  hoge3 : 0 / 611 (1508494127567)
[E]  hoge3 : 304 / 915 (1508494127871)
[S]  hoge3 : 0 / 915 (1508494127871)
[E]  hoge3 : 303 / 1218 (1508494128174)
[E] hoge : 1219 / 1219 (1508494128175)
----END------( 2017-10-20 19:08:48 )------

hoge2 : 1回 / 合計 3ms 
hoge3 : 4回 / 合計 1214ms 
hoge : 1回 / 合計 1219ms 
```

## Todo

* Separate measurement and output into each class
* Enable to change log-format
* Enable to change logging media
* Add test code
* To composer
