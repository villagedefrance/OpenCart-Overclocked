// ----------------------------------------
// markItUp!
// ----------------------------------------
// Copyright (C) 2011 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------
// Overclocked Edition set
// ----------------------------------------
var mySettings = {
	onShiftEnter: {keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter: {keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
	onTab: {keepDefault:false, replaceWith:'    '},
	markupSet: [
		{name:'Heading 1', key:'1', openWith:'<h1>', closeWith:'</h1>', placeHolder:'Your title here...'},
		{name:'Heading 2', key:'2', openWith:'<h2>', closeWith:'</h2>', placeHolder:'Your title here...'},
		{name:'Heading 3', key:'3', openWith:'<h3>', closeWith:'</h3>', placeHolder:'Your title here...'},
		{separator:'---------------' },
		{name:'Bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)'},
		{name:'Italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'},
		{name:'Stroke through', key:'S', openWith:'<del>', closeWith:'</del>'},
		{separator:'---------------' },
		{name:'Paragraph', openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>'},
		{name:'Bulleted List', openWith:'  <li>', closeWith:'</li>', multiline:true, openBlockWith:'<ul>\n', closeBlockWith:'\n</ul>'},
		{name:'Numeric List', openWith:'  <li>', closeWith:'</li>', multiline:true, openBlockWith:'<ol>\n', closeBlockWith:'\n</ol>'},
		{separator:'---------------' },
		{name:'Picture', key:'P', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />'},
		{name:'Link', key:'L', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...'},
		{separator:'---------------' },
		{name:'Code', openWith:'(!(<?[![Language:!:php]!] |!|<pre>)!)', closeWith:'(!(; ?>|!|</pre>)!)'},
		{separator:'---------------' },
		{name:'Preview', className:'preview', call:'preview'}
	]
}
