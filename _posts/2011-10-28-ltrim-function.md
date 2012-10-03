---
layout: post
title: "ltrim関数"
date: 2011-10-28 11:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (ltrim s)
型ヒント: String s

sの左側の空白を削除した文字列を返す。

<!-- more -->

	user=> (use '[clojure.contrib.str-utils2 :only (ltrim)])
	nil
	user=> (ltrim "   abc   ")
	"abc   "
