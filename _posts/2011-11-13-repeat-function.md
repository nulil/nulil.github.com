---
layout: post
title: "repeat関数"
date: 2011-11-13 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (repeat s n)
型ヒント: String s

sをn個くっつけた文字列を返す。

<!--more-->

	user=> (use '[clojure.contrib.str-utils2 :only (repeat)])
	WARNING: repeat already refers to: #'clojure.core/repeat in namespace: user, being replaced by: #'clojure.contrib.str-utils2/repeat
	nil
	user=> (repeat "abc" 3)
	"abcabcabc"
