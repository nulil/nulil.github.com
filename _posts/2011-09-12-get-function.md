---
layout: post
title: "get関数"
date: 2011-09-12 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (get s i)
型ヒント: String s

s内のi+1番目の文字を取得する。

<!-- more -->

	user=> (use '[clojure.contrib.str-utils2 :only (get)])
	WARNING: get already refers to: #'clojure.core/get in namespace: user, being replaced by: #'clojure.
	contrib.str-utils2/get
	nil
	user=> (get "abc" 2)
	\c
	user=> (get "abc" 0)
	\a
	user=> (get "abc" 4)
	java.lang.StringIndexOutOfBoundsException: String index out of range: 4 (NO_SOURCE_FILE:0)
