---
layout: post
title: "join関数"
date: 2011-09-17 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (join separator coll)  
型ヒント: String separator coll

sequenceの要素全てをseparatorで繋げた文字列を返す。  
Perlの’join’のように動作する。

<!--more-->

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (join)])
nil
user=> (join "," ["a" "b" "c"])
"a,b,c"
{% endhighlight %}
