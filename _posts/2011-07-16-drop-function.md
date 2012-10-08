---
layout: post
title: "escape関数"
date: 2011-07-16 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (drop s n)  
型ヒント: String s

sから最初のn文字を削除した文字列を返す。  
sの長さよりnが大きい場合は空文字を返す。

<!--more-->

引数の順番がclojure.core/dropとは反対なことに注意。  
(str-utils2の指針にある”最初の引数は文字列”を守るため)

{% highlight clojure linenos %}
(user=> (use '[clojure.contrib.str-utils2 :only (drop)])
WARNING: drop already refers to: #'clojure.core/drop in namespace: user, being replaced by: #'clojure.contrib.str-utils2/drop
nil
user=> (drop "abc" 2)
"c"
{% endhighlight %}

