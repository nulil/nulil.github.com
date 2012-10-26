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

<br />
<br />

ヒアドキュメント内で関数を使う方法ってのは

{% highlight php linenos %}
<?php
$echo = create_function('$val', 'return $val;');
$foo = 'foo';
echo <<<EOD
hoge {$echo(strtoupper($foo))} hoge
EOD;
{% endhighlight %}

変数に入れた無名関数使うだけ。  
簡単w

他にも関数実行するだけなら ${ print "foo"} とか書けるみたいだけど、Notice発生しちゃうのがいかん。  
（{}の中の関数等の出力を変数名として評価するため、" "で変数評価して、変数が見つからないってなる様子）

<br />

PHP5.3以上ならcreate_functionじゃなくても大丈夫

{% highlight php linenos %}
<?php
$echo = function($val){ return $val; };
$foo = 'foo';
echo <<<EOD
hoge {$echo(strtoupper($foo))} hoge
EOD;
{% endhighlight %}

