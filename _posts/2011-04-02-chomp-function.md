---
layout: post
title: "chomp関数"
date: 2011-04-02 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (chomp s)
型ヒント: String s

sの末尾の全ての改行(\n)、または復帰(\r)を削除した文字列を返す。
String.trim()と類似して高速動作

<!--more-->

	user=> (use '[clojure.contrib.str-utils2 :only (chomp)])
	nil
	user=> (chomp "abc\n")
	"abc"
	user=> (chomp "abc\r")
	"abc"
	user=> (chomp "abc\n\r")
	"abc"
	user=> (chomp "abc\ndef\n")
	"abc\ndef"
	user=> (chomp "abc\n\n\n\n\n\r\r\n\r\n")
	"abc"
