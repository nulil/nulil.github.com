---
layout: post
title: "SCSS入門"
date: 2012-10-28 12:00:00
category : scss
tags: [scss,sass]
---

<!--more-->

# なんでSCSS？


## そもそもSCSSって何？

SCSSは簡単に言うと、CSSを出力するスクリプト言語（CSSメタ言語）。

SASSというものがベースになっていて、SASSよりCSSに近い記法で書く。  
見やすく書けたり、モジュール化しやすくする機能をもってる。

主な機能
* セレクタのネスティング
* 変数
* 条件分岐
* 演算
* ミックスイン
* セレクタの継承


## SCSS以外のCSSメタ言語

私の知っているところではLESS、Closure Stylesheets。  
この他にもいろいろある。

[LESS](http://lesscss.org/)もSASSからの派生言語  
現在はjavascriptで実装されていて、ブラウザ（javascript）でlessファイルをCSSに展開することが可能。

[Closure Stylesheets](http://code.google.com/p/closure-stylesheets/)はGoogleが提供している。  
Javaで実装されている。


## SCSSにしたワケ

LESSと比較してSCSSのいいところは
* 条件分岐、繰り返しの制御があり、記述がC言語系に似ている（LESSは"when"を使って条件分岐。繰り返し制御はないっぽい）
* セレクタの継承ができる

LESSにもメリットはあって、一番大きいのは、less.jsによりブラウザ側でcssに展開できることだと思うのだけど、表示の速度・javascript無効化とか考えると最終的にはブラウザ側でcssに展開するのは使わない気がする。  
ただし、lessファイル内でjavascriptを扱えるので、それを有効利用出来るなら…

Closure StylesheetsはCSSの最適化までやってくれるのでSCSSよりいい可能性も。  
でもまだディファクトスタンダードはSCSSかLESSな感じなので。

参考  
[CSS拡張メタ言語「SCSS(Sass)」と「LESS」の比較](http://dxd8.com/archives/217/)  
[LESSとSassの比較した結果LESSを採用することにした](http://yuku-tech.hatenablog.com/entry/20120304/1330851243)
[LESS でなく SCSS（Sass）を選ぶ理由](http://stack3.com/web-design/scss-or-less-css.html)


-----------------------------


# SCSS入門


## セレクタのネスティング

ネスティングとは、直訳すると"入れ子"で、CSSではセレクタに複数要素指定して親子関係を表現するところを、SCSSでは{}の入れ子で表現することができます。

参考  
[ネスティング](http://ja.wikipedia.org/wiki/%E3%83%8D%E3%82%B9%E3%83%86%E3%82%A3%E3%83%B3%E3%82%B0)

``` css
/* css */
#container div {
	margin-top: 10px;
}
#container p {
	margin-top: 20px;
}
```

{% highlight css %}
/* scss */
#container {
	div {
		margin-top: 10px;
	}
	p {
		margin-top: 20px;
	}
}
{% endhighlight %}


ネストの中で & を使うと親要素を参照できます。

{% highlight css %}
/* scss */
#container {
	div {
		margin-top: 10px;
	}
	p {
		margin-top: 20px;
	}
	a {
		color: blue;
		
		&:hover {
			color: aqua;
		}
	}
}
{% endhighlight %}


## 変数

変数名:初期値;  
と言う形で変数を宣言できます。変数名は$で始めるのがルール。  
変数を使えば、マジックナンバーを減らし、可読性・メンテナンス性が向上できる。  
また、後述の条件分岐等にも利用します。

参考  
[変数 (プログラミング)](http://ja.wikipedia.org/wiki/%E5%A4%89%E6%95%B0_(%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0))  
[マジックナンバー (プログラム)](http://ja.wikipedia.org/wiki/%E3%83%9E%E3%82%B8%E3%83%83%E3%82%AF%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC_(%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%A0))

{% highlight css %}
/* css */
#container {
	color: #EEE;
	background-color: #111;
}
#container div {
	color: #111;
	background-color: #16A;
}
{% endhighlight %}

{% highlight css %}
/* scss */
$BASE_COLOR: #111;
$ACCENT_COLOR: #EEE;
$MAIN_COLOR: #16A;

#container {
	color: $ACCENT_COLOR;
	background-color: $BASE_COLOR;

	div {
		color: $BASE_COLOR;
		background-color: $MAIN_COLOR;
	}
}
{% endhighlight %}

SCSSのほうが長くなってしまいますが、さらにコードが長くなったときの見やすさ、値の変更しやすさは変数を使ったほうが上でしょう。


## 演算

演算も可能です。

{% highlight css %}
/* scss */
#container{
	width: 600px+200px;
}
{% endhighlight %}


変数を使うと尚良し。

{% highlight css %}
/* scss */
$main_column_width :600px;
$side_column_width :200px;
#container {
	width:$main_column_width+$side_column_width;
}
{% endhighlight %}

色に対しての演算、文字列の結合等も可能です。


## 条件分岐

@ifを使って、出力を変えることができます。

{% highlight css %}
$foo: foo;
$BASE_COLOR: #111;
$MAIN_COLOR: #16A;

p {
	@if $foo == foo {
		color: red;
	}
	
	@if 1+1 < 5 {
		border: 1px solid;
	}

	@if $BASE_COLOR == #7FFFFF {
		background: $MAIN_COLOR;
	}@else if $BASE_COLOR minus #7FFFFF {
		background: $BASE_COLOR - #050505;
	}@else {
		background: $BASE_COLOR + #050505;
	}
}
{% endhighlight %}

数値には不等号が使えますが、colorではエラーとなります。  
代わりに minus 等のメソッドを使います。


## ミックスイン

一緒に設定されるCSSをまとめておき、使い回ししやすくできます。  
CSSフレームワークの代わりに、ミックスインを使ってフレームワークが作られていたりします。

@mixin で定義して、@include でミックスインを呼び出します。

{% highlight css %}
/* scss */
$support_for_old_ie: true;
@mixin inline_block {
	display: inline-block;

	@if $support_for_old_ie {
		*display: inline;
		*zoom: 1;
	}
}

.inlineblock {
	@include inline_block;	// mixin呼び出し
}
{% endhighlight %}


値を渡すことも可能。未指定時の値も設定できます。

{% highlight css %}
/* scss */
@mixin dashed_border($color, $width: 1px) {
	border: {
		color: $color;
		width: $width;
		style: dashed;
	}
}
p {
	@include dashed_border(red);
}
div {
	@include dashed_border(blue, 0.2em);
}
{% endhighlight %}


## セレクタの継承

{% highlight css %}

{% endhighlight %}



## 行コメント

//による行コメントが使えます。  
行コメントは、//から改行までがコメントとして扱われ、CSSには出力されません。



-----------------------------

その他、以下の機能もありますが、とりあえず入門としては上記のものを押させとけば大丈夫でしょう。
* 他のSCSSファイルの読み込み
* !defaultによる変数の設定
* 繰り返し
* 関数
* #{}によるセレクタやプロパティでの変数利用
* mixinにブロックコンテンツを渡す
* %によるプレースホルダーセレクタ
* 可変長引数
