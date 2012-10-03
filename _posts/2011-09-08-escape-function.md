---
layout: post
title: "escape関数"
date: 2011-09-12 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (escape s cmap)
型ヒント: String s

s内の各charにcmap(関数またはマップ)を適用した文字列を返す。
cmapがnilを返す場合は、元の文字がそのまま出力に追加される。

<!-- more -->

docharsマクロを使っているのでサロゲートコードには対応していない。

	user=> (use '[clojure.contrib.str-utils2 :only (escape)])
	nil
	user=> (escape "abc" #(str "3" %))
	"3a3b3c"
	user=> (escape "abc" {\a "e" \b "d" })
	"edc"
