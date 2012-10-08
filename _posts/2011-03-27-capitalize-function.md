---
layout: post
title: "capitalize関数"
date: 2011-03-27 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (capitalize s)  
型ヒント: String s

sの最初の文字を大文字にして、他は全て小文字にした文字列を返す。

<!--more-->

{% highlight clojure linenos %}
user=> (use 'clojure.contrib.str-utils2)
;clojure.coreの関数と名前が被るよって、いっぱいWARNINGでるけど無視で
nil
user=> (capitalize "aBC")
"Abc"
{% endhighlight %}

