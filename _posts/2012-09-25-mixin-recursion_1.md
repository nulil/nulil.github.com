---
layout: default
title: "SCSS使ってるんだけど"
date: 2012-09-25 22:42:00
category : whatnot
tags : [scss, ruby]
---
最近SCSSが便利なこと知って、CSSを書くときはもっぱらSCSSを使ってます。

で、このサイトのCSSもSCSS使って書いてるのですが、メニューの段組構成をmixinの再帰で書けないかなぁと書いてみたんですが...

<pre>
@mixin ul-loop($i : 2){
	@if 0 < $i {
		ul {
			visibility	:	visible;

			li {
				ul {
					visibility	:	hidden;
				}

				&:hover,
				&.current,
				a:hover,
				a:active {
					@include ul-loop($i - 1);
				}
			}
		}
	}
}

@include ul-loop(4);
</pre>

しかし無残にもエラーorz

	Sass::SyntaxError: An @include loop has been found: ul-loop includes itself
	  handle_include_loop! at sass/lib/sass/tree/visitors/perform.rb:424


perform.rbのSass::Tree::Visitors::Perform#handle_include_loop!(sass3.2.1)を↓のようにしちゃえば再帰もできるんですが...

	def handle_include_loop!(node)
	  msg = "An @include loop has been found:"
	  content_count = 0
	  mixins = @stack.reverse.map {|s| s[:name]}.compact.select do |s|
		if s == '@content'
		  content_count += 1
		  false
		elsif content_count > 0
		  content_count -= 1
		  false
		else
		  true
		end
	  end

	  return if mixins.empty?
	  true						# true返しちゃう！	エラーは発生させない！
	#  raise Sass::SyntaxError.new("#{msg} #{node.name} includes itself") if mixins.size == 1
	#
	#  msg << "\n" << Sass::Util.enum_cons(mixins.reverse + [node.name], 2).map do |m1, m2|
	#	"    #{m1} includes #{m2}"
	#  end.join("\n")
	#  raise Sass::SyntaxError.new(msg)
	end


再帰便利なんだけどなぁ...
