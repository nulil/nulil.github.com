---
layout: post
title: "apacheでgit pull"
date: 2013-04-22 12:00:00
category : development
tags: [apache,git,php]
---
gitのhookを使ってサイトをデプロイするために、apacheでgit pullさせるようにしたのでメモ。
OSはCent。

[GitHubにpushがあったら，自動でpullする環境（on Plesk）のメモ ::ハブろぐ](http://havelog.ayumusato.com/develop/server/e328-nightly_pulling.html)を参考にさせて頂き、リポジトリをapacheの管理下に置く形でやってみて、"一時的に通常ユーザからapache名目で操作できるように変更"までは問題なく進みましたが、その後ハマったので...


* 参考サイト
** [GitHubにpushがあったら，自動でpullする環境（on Plesk）のメモ ::ハブろぐ](http://havelog.ayumusato.com/develop/server/e328-nightly_pulling.html)
** [git-config(1) Manual Page](https://www.kernel.org/pub/software/scm/git/docs/git-config.html#FILES)
** [ブログ Apache＋PHPで環境変数を追加したい](http://yukke.blog3.fc2.com/blog-entry-68.html)
** [Linux ユーザ情報の変更 - usermod](http://kazmax.zpp.jp/linux_beginner/usermod.html)
** [Jenkins@さくらVPSにOctopressのデプロイを任せてみる - TOKOROM BLOG](http://www.tokoro.me/2012/07/29/jenkins-octopress/)


<!--more-->

## Gitのインストールしてclone

{% highlight sh %}
yum install git
cd /var/www
git clone repository subdomain
{% endhighlight %}

Virtual Hostの設定して、サイトルートは subdomain/public にした。



## とりあえずrootで鍵作成と /root/.ssh/config の設定

SSH用のパスフレーズなしの鍵作成

{% highlight sh %}
ssh-keygen -t rsa
{% endhighlight %}


/root/.ssh/config に下記追記

{% highlight apache %}
Host repository_domain
        HostName        repository_domain
        IdentityFile    /root/.ssh/id_rsa
        User            username
{% endhighlight %}


## グループを作成

deployers って名前のグループにした

{% highlight sh %}
groupadd deployers
usermod -G deployers <username>
usermod -G gitwriters apache
{% endhighlight %}

## リポジトリの権限付与

{% highlight sh %}
chgrp -R deployers /var/www/subdomain
chmod -R g+rw /var/www/subdomain
find /var/www/subdomain -type d -print0 | xargs -0 chmod g+s
{% endhighlight %}

## .ssh 作成

{% highlight sh %}
mkdir /var/www/.ssh
chown apache /var/www/.ssh
{% endhighlight %}

## apacheユーザーで操作できるようにする

visudo 実行して下記追記

{% highlight sh %}
apache ALL=(ALL) NOPASSWD: ALL
{% endhighlight %}


## apacheユーザーで鍵作成

{% highlight sh %}
sudo -u apache ssh-keygen -t rsa
{% endhighlight %}

-----------------
ここからハマったところ

## apacheでpull

{% highlight sh %}
cd /var/www/subdomain
sudo -u apache git pull
{% endhighlight %}

エラー...
/root/.config/git/config の権限がないって...？

/root/.config/git/config 自体存在しなかったので、作って apache をオーナーにするもエラー...

ググっていろいろまわり、[git-config(1) Manual Page](https://www.kernel.org/pub/software/scm/git/docs/git-config.html#FILES)に $XDG_CONFIG_HOME のことが書かれていたので、これを設定してみようとさらにググる...

そして[ブログ Apache＋PHPで環境変数を追加したい](http://yukke.blog3.fc2.com/blog-entry-68.html)にたどり着き、なんとか $XDG_CONFIG_HOME を設定するところを知る。

{% highlight sh %}
nano /etc/sysconfig/httpd
export XDG_CONFIG_HOME=/var/www/.config	#追記
cd /var/www
mkdir -p .config/git
chown -R apache .config
/etc/init.d/httpd restart
{% endhighlight %}

こ　れ　で　！　と勇んでpullするもエラー...
今度は /root/.ssh/id_rsa の権限がないとかだったかな...（うろおぼえ）

なんで /var/www/.ssh/id_rsa を見てくれないんだよorz

...
......
.........

で、いろいろすったもんだしたあと、apacheユーザーでログインすればいいんじゃないかと気が付き（気付くの遅すぎ

{% highlight sh %}
usermod -s /bin/bash
su apache
cd /var/www/subdomain
git pull
{% endhighlight %}

ヽ(;Д;)ノ
プログラムはなんとかなってるけど、サーバの知識が足らないなぁ...

