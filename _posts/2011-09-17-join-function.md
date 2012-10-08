---
layout: post
title: "join関数"
date: 2011-09-17 11:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (grep re coll)

正規表現によってcollの要素をフィルタリング。

<!--more-->

coll各要素の文字列表現をre-find関数でテストしている。

{% highlight clojure linenos %}
user=> (use '[clojure.contrib.str-utils2 :only (grep)])
nil
user=> (grep #"_+" ["abc" "def_" "_ghi" "jkl"])
("def_" "_ghi")
{% endhighlight %}

