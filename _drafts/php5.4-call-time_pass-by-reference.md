---
layout: post
title: "PHP 呼び出し時の参照渡し"
date: 2012-10-28 12:00:00
category : php
tags: [php,reference]
---
PHP5.4で、呼び出し時の参照渡しがサポートされなくなるってのを知って、参照渡し結構使ってる...呼び出し時の参照渡し？...と思い試してみた。

<!--more-->


{% highlight php %}
function foo(&$value){
	$value = "FOO";
}
function bar($value){
  $value = "BAR";
}

$baz1 = "baz";
foo($baz1);
echo "baz1: ", $baz1, PHP_EOL;

$baz2 = "baz";
foo(&$baz2);
echo "baz2: ", $baz2, PHP_EOL;

$baz3 = "baz";
call_user_func_array("foo", array($baz3));
echo "baz3: ", $baz3, PHP_EOL;

$baz4 = "baz";
call_user_func_array("foo", array(&$baz4));
echo "baz4: ", $baz4, PHP_EOL;

$baz5 = "baz";
bar(&$baz5);
echo "baz5: ", $baz5, PHP_EOL;

$baz6 = "baz";
call_user_func_array("bar", array(&$baz6));
echo "baz6: ", $baz6, PHP_EOL;
{% endhighlight %}

<br />
PHP5.3での実行結果  
baz3がエラーになるのは知らなかった...

	baz1: FOO
	baz2: FOO
	PHP Warning:  Parameter 1 to foo() expected to be a reference, value given in Command line code on line 17
	PHP Stack trace:
	PHP   1. {main}() Command line code:0
	PHP   2. call_user_func_array() Command line code:17
	baz3: baz
	baz4: FOO
	baz5: BAR
	baz6: BAR

<br />
PHP5.4での実行結果

