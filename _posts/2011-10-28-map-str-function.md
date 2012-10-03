---
layout: post
title: "map-str関数"
date: 2011-10-28 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (map-str f coll)

collの各要素全てにfを適用し、結果を連結した文字列で返す。

<!-- more -->

	user=> (use '[clojure.contrib.str-utils2 :only (map-str)])
	nil
	user=> (map-str #(.toUpperCase %) ["abc" "def" "ghi"])
	"ABCDEFGHI"
