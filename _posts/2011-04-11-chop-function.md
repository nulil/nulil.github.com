---
layout: post
title: "chop関数"
date: 2011-04-11 10:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (chop s)  
型ヒント: String s

sの最後の文字を削除した文字列を返す。

<!--more-->

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (chop)])
nil
user=> (chop "abc\n")
"abc"
user=> (chop "abcd")
"abc"
{% endhighlight %}
