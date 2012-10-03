---
layout: post
title: "butlast関数"
date: 2011-03-23 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (butlast s n)  
型ヒント: String s

nが(count s)より大きい場合、空文字を返し、小さい場合、sの末尾からn分削った文字列を返す。

<!--more-->

{% highlight clojure linenos %}
user=> (use 'clojure.contrib.str-utils2)
;clojure.coreの関数と名前が被るよって、いっぱいWARNINGでるけど無視で
nil
user=> (butlast "abc" 4)
""
user=> (butlast "abcdef" 4)
"ab"
{% endhighlight %}
