---
path: /documentation/keywords
site: sensibilis

---

Markdown variables are stored / wrote at the top of your document :
<pre>
---
title: Sensibilis - Static Flexible CMS - Markdown Online edition
author: Benjamin Baschet
forkme: https://github.com/Darkapus/sensibilis
showMarkdown: true
path: /home

---
</pre>

- first occurence before " : " is the key
- second occurence after " : " is the value

Example :
<pre>
stringkey: stringvalue
</pre>

> **true** and **false** string are considered as boolean value

- if there is no occurence after " : ", that mean the value will be an array. To compose an array, need to start by " - "

Example :
<pre>
arraykey:
	- arrayvalue1
	- arrayvalue2
	- arrayvalue3
</pre>

All variable will be transfer to your twig document
<pre>
// for example
&lt;html&gt;
&lt;body&gt;
Hello my name is {{ stringkey }}
&lt;/body&gt;
&lt;/html&gt;
</pre>

| Keyword | Mandatory | Used For |
| -------- | -------- | -------- |
| path     | Yes      | Needed to know the path for the url     |
| site     | No    | Which configuration site to use  |
| tags     | No    | tags are used to design your website with some link  |
| draft     | No    | If draft equals to true, the document will not be published  |

<script>
$(document).ready(function(){$('table').addClass('table');})
</script>