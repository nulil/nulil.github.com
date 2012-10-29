---
layout: post
title: "SCSS入門"
date: 2012-10-28 12:00:00
category : scss
tags: [scss,sass]
---

<!--more-->

## SCSSって？

そもそもSCSSって何だって？って話ですよね。  
SCSSは簡単に言うと、CSSを出力するスクリプト言語（CSSメタ言語）。

SASSというものがベースになっていて、SASSよりCSSに近い記法で書く。  
見やすく書けたり、モジュール化しやすくする機能をもってる。

主な機能
* 変数
* セレクタのネスト
* ミックスイン
* セレクタの継承


## SCSS以外のCSSメタ言語

私の知っているところではLESS、Closure Stylesheets。  
他にもいろいろあると思う。

[LESS](http://lesscss.org/)もSASSからの派生言語  
現在はjavascriptで実装されていて、ブラウザ（javascript）でlessファイルをcssに展開することが可能。

[Closure Stylesheets](http://code.google.com/p/closure-stylesheets/)はGoogleが提供している。  
Javaで実装されている。


## SCSSにしたワケ

LESSと比較して
* 機能が豊富
* 条件分岐、繰り返し等の制御あり、記述がC言語系に似ている（LESSは"when"を使って条件分岐）
* LESSには @extend 的なものがない

LESSにもメリットはあって、一番大きいのは、less.jsによりブラウザ側でcssに展開できることだと思うのだけど、表示の速度・js無効化とか考えると最終的にはブラウザ側でcssに展開するのは使わない気がする。  
ただし、lessファイル内でjsを扱えるので、それを有効利用出来るなら…

Closure StylesheetsはCSSの最適化までやってくれるのでSCSSよりいい可能性も。  
でもまだディファクトスタンダードはSCSSかLESSな感じなので。

参考  
[CSS拡張メタ言語「SCSS(Sass)」と「LESS」の比較](http://dxd8.com/archives/217/)  
[LESSとSassの比較した結果LESSを採用することにした](http://yuku-tech.hatenablog.com/entry/20120304/1330851243)


## セレクタのネスト





