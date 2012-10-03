---
layout: post
title: "docharsマクロ"
date: 2011-05-10 12:00:00
category : clojure
tags : [clojure, contrib, str-utils2, library]
---
使用方法: (dochars bindings & body)
バインディング => [name string]

stringに指定された文字列の各charをnameに束縛してbodyを適用する。(だと思う)
Unicodeの補助文字を処理しない。(単純に.charAtで1文字を取得)

<!-- more -->

bindingsにはベクターで指定。
--name=bodyの中でchar(stringを分解した)を参照するための変数
--string=bodyを適用する文字列

	user=> (use '[clojure.contrib.str-utils2 :only (dochars)])
	nil
	user=> (dochars [c "test"] (println c))
	t
	e
	s
	t
	nil

~@はスプライシングアンクオートで、()で囲わない形で展開するらしいので
(let [~(first bindings) (.charAt s# i#)] ~@body) は
(let [name (.charAt s i)] body) といった感じに展開されるんだと思う。
