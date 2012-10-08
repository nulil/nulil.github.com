---
layout: post
title: "lower-case関数"
date: 2011-10-10 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (lower-case s)  
型ヒント: String s

sを全て小文字に変換する。

<!--more-->

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (lower-case)])
nil
user=> (lower-case "AbC")
"abc"
{% endhighlight %}

