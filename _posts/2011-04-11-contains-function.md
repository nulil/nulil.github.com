---
layout: post
title: "contains?関数"
date: 2011-04-11 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (contains? s substring)  
型ヒント: String s

sにsubstringが含まれている場合、trueを返す。

<!--more-->

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (contains?)])
WARNING: contains? already refers to: #'clojure.core/contains? in namespace: user, being replaced by: #'clojure.contrib.str-utils2/contains?
nil
user=> (contains? "abc123" "abc")
true
user=> (contains? "abc" "b")
true
user=> (contains? "abc" "e")
false
{% endhighlight %}
