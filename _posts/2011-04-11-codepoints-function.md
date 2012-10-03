---
layout: post
title: "codepoints関数"
date: 2011-04-11 11:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (codepoints s)
型ヒント: String s

sの各文字のUnicodeコードポイントを遅延シーケンスで返す。(だと思う)

<!--more-->

sの各charが、上位サロゲートコード単位だったら(Character#isHighSurrogate==true) 、.codePointAt使って2char進め、Character#isHighSurrogate==falseならcharをintにして1char進めている。

	user=> (use '[clojure.contrib.str-utils2 :only (codepoints)])
	nil
	user=> (codepoints "abcあいう")
	(97 98 99 66 68 70)
