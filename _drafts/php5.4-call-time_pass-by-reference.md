---
layout: post
title: "PHP 呼び出し時の参照渡し"
date: 2012-10-28 12:00:00
category : php
tags: [php,reference]
---
PHP5.4で、呼び出し時の参照渡しがサポートされなくなるってのを知ってマジかよ…と思い試してみた。

<!--more-->



//PHP5.3
function foo(&$value){
	$value = "FOO";
}
$hoge = "hogehoge";
foo($hoge);
var_dump($hoge);
>string(3) "FOO"

function foo($value){
  $value = "FOO";
}
$hoge = "hogehoge";
foo(&$hoge);                             
var_dump($hoge);
>string(3) "FOO"

function foo(&$value){
  $value = "FOO";
}
$hoge = "hogehoge";
foo(&$hoge);                              
var_dump($hoge);
>string(3) "FOO"

function foo(&$value){
  $value = "FOO";
}
$hoge = "hogehoge";
call_user_func_array("foo",array($hoge));
var_dump($hoge);
>PHP Warning:  Parameter 1 to foo() expected to be a reference, value given in Command line code on line 5
>PHP Stack trace:
>PHP   1. {main}() Command line code:0
>PHP   2. call_user_func_array() Command line code:5
>string(8) "hogehoge"

function foo(&$value){
  $value = "FOO";
}
$hoge = "hogehoge";
call_user_func_array("foo",array(&$hoge));
var_dump($hoge);
>string(3) "FOO"

function foo($value){
  $value = "FOO";
}
$hoge = "hogehoge";
call_user_func_array("foo",array(&$hoge));
var_dump($hoge);
>string(3) "FOO"
