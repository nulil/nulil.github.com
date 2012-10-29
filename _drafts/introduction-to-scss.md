---
layout: post
title: "SCSS入門"
date: 2012-10-28 12:00:00
category : scss
tags: [scss,sass]
---
SCSSを布教するために入門的なものを書いてみました。

<!--more-->

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

``` css
/* scss */
#container {
	div {
		margin-top: 10px;
	}
	p {
		margin-top: 20px;
	}
}
```

<br />
ネストの中で & を使うと親要素を参照できます。

``` css
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
```

<br />
## 変数

変数名:初期値;  
と言う形で変数を宣言できます。変数名は$で始めるのがルール。  
変数を使えば、マジックナンバーを減らし、可読性・メンテナンス性が向上できる。  
また、後述の条件分岐等にも利用します。

参考  
[変数 (プログラミング)](http://ja.wikipedia.org/wiki/%E5%A4%89%E6%95%B0_%28%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0%29)  
[マジックナンバー (プログラム)](http://ja.wikipedia.org/wiki/%E3%83%9E%E3%82%B8%E3%83%83%E3%82%AF%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC_%28%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%A0%29)

``` css
/* css */
#container {
	color: #EEE;
	background-color: #111;
}
#container div {
	color: #111;
	background-color: #16A;
}
```

``` css
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
```

SCSSのほうが長くなってしまいますが、さらにコードが長くなったときの見やすさ、値の変更しやすさは変数を使ったほうが上でしょう。

<br />
## 演算

演算も可能です。

``` css
/* scss */
#container{
	width: 600px+200px;
}
```

<br />
変数を使うと尚良し。

``` css
/* scss */
$main_column_width :600px;
$side_column_width :200px;
#container {
	width:$main_column_width+$side_column_width;
}
```

色に対しての演算、文字列の結合等も可能です。

<br />
## 条件分岐

@ifを使って、出力を変えることができます。

``` css
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
```

数値の比較には不等号が使えますが、colorではエラーとなります。  
代わりに minus 等のメソッドを使います。

<br />
## ミックスイン

一緒に設定されるCSSをまとめておき、使い回ししやすくできます。  
CSSフレームワークの代わりに、ミックスインを使ってフレームワークが作られていたりします。

@mixin で定義して、@include でミックスインを呼び出します。

``` css
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
```

<br />
値を渡すことも可能。未指定時の値も設定できます。

``` css
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
```

<br />
## セレクタの継承

``` css
/* scss */
// 継承元のセレクタ
p {
	&.foo {
		font: {
			size: 2em;
			style: italic;
		}
	}
}
div{
	@extend p.foo;		// 継承
	
	font-style: normal;
	
	.black {
		color: black;
	}
}
```

コンパイルすると↓になります。

``` css
/* css */
p.foo, div {
  font-size: 2em;
  font-style: italic;
}

div {
  font-style: normal;
}
div .black {
  color: black;
}
```

継承を使うと p.foo, div のように、複数セレクタのCSSを出力してくれます。

<br />
ミックスインで書くと...

``` css
/* scss */
@mixin bar{
	font: {
		size: 2em;
		style: italic;
	}
}

p {
	&.foo {
		@include bar;	// mixin
	}
}
div{
	@include bar;		// mixin
	
	font-style: normal;
	
	.black {
		color: black;
	}
}
```

``` css
/* css */
p.foo {
  font-size: 2em;
  font-style: italic;
}

div {
  font-size: 2em;
  font-style: italic;
  font-style: normal;
}
div .black {
  color: black;
}
```

複数セレクタではなくなり、CSSが冗長なってしまいます。




<br />
## 行コメント

//による行コメントが使えます。  
行コメントは、//から改行までがコメントとして扱われ、CSSには出力されません。

<br />

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
