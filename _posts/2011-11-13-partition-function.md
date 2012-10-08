---
layout: post
title: "partition関数"
date: 2011-11-13 11:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (partition s re)  
型ヒント: String s  
java.util.regex.Pattern re

sをreに一致しない部分と一致した部分とで、遅延シーケンスに分割して返す。

<!--more-->

firstは”一致しない”がくるようで、文字列の最初から一致があると、firstは空白になるみたい。

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (partition)])
WARNING: partition already refers to: #'clojure.core/partition in namespace: user, being replaced by: #'clojure.contrib.str-utils2/partition
nil
user=> (partition "abc123def" #"[a-z]+")
("" "abc" "123" "def")
{% endhighlight %}

