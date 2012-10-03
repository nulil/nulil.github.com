---
layout: post
title: "partial関数"
date: 2011-11-06 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (partial f & args)

clojure.core/partialのように動作
第一引数は、第二引数以降を受け取る関数
(fn [s & more] (apply f s (concat args more))))に展開される。

例：
	(use '[clojure.contrib.str-utils2 :only (partial)])
	(partial clojure.contrib.str-utils2/take 2)
	;;=> (fn [s] (str-utils2/take s 2))

<!-- more -->

	user=> (use '[clojure.contrib.str-utils2 :only (partial)])
	WARNING: partial already refers to: #'clojure.core/partial in namespace: user, being replaced by: #'
	clojure.contrib.str-utils2/partial
	nil
	user=> (partial clojure.contrib.str-utils2/take 2)
	#< str_utils2 $partial$fn__412 clojure.contrib.str_utils2/$partial$fn__412@1716fa0>
	user=> ((partial clojure.contrib.str-utils2/map-str) #(.toUpperCase %)  ["abc" "def" "ghi"] )
	"ABCDEFGHI"
	user=> ((partial clojure.contrib.str-utils2/map-str ["abc" "def" "ghi"]) #(.toUpperCase %)  )
	"ABCDEFGHI"
	user=> (map (partial concat "a") ["1" "2" "3"])
	((\1 \a) (\2 \a) (\3 \a))
	user=> ( (partial concat "a") ["1" "2" "3"])
	("1" "2" "3" \a)
