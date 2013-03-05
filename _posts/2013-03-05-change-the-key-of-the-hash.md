---
layout: post
title: "連想配列のキー値の書き換え"
date: 2013-03-05 12:00:00
category : php
tags: [php]
---
PHPで連想配列のキー値の一律変更、さくっと書くとこんな感じかな？

<!--more-->

{% highlight php %}
$foo = array('k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3');
$bar = call_user_func_array('array_merge', array_map(function($k, $v){ return array(':' . $k => $v); }, array_keys($foo), array_values($foo)));
{% endhighlight %}

phpだとながいな...

