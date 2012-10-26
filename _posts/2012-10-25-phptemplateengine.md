---
layout: post
title: "PHP template engine?"
date: 2012-10-25 12:00:00
category : php
tags: [php,template engine]
---
PHPでヒアドキュメント内で関数を使う方法を試したら、思ったとおりに動いた。
そして、それを利用したら簡単なテンプレートエンジンが出来そうな気がしたので作ってみた。

<!--more-->

ソースコードはリポジトリ見てください。
[PHPStringTemplateEngine](https://github.com/nulil/PHPStringTemplateEngine)



ヒアドキュメント内で関数を使う方法てのは

{% highlight php linenos %}
$echo = create_function('$val', 'return $val;');
$foo = 'foo';
echo <<<EOD
hoge {$echo(strtoupper($foo))} hoge
EOD;
{% endhighlight %}

変数に入れた無名関数使うだけ。
簡単w

PHP5.3以上ならcreate_functionじゃなくて大丈夫

{% highlight php linenos %}
$echo = function($val){ return $val; };
$foo = 'foo';
echo <<<EOD
hoge {$echo(strtoupper($foo))} hoge
EOD;
{% endhighlight %}

