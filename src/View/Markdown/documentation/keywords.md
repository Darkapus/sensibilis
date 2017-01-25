---
path: /documentation/keywords
site: sensibilis
title: Manage your variables
description: Learn to Manage your variables, Markdown variables are stored / wrote at the top of your document

---

Markdown variables are stored / wrote at the top of your document :

	---
	title: Sensibilis - Static Flexible CMS - Markdown Online edition
	author: Benjamin Baschet
	forkme: https://github.com/Darkapus/sensibilis
	showMarkdown: true
	path: /home

	---


- first occurence before " : " is the key
- second occurence after " : " is the value

Example :

	stringkey: stringvalue


> **true** and **false** string are considered as boolean value

- if there is no occurence after " : ", that mean the value will be an array. To compose an array, need to start by " - "

Example :

	arraykey:
		- arrayvalue1
		- arrayvalue2
		- arrayvalue3


All variable will be transfer to your twig document

	// for example
	<html>
<body&gt;
	Hello my name is {{ '{{stringkey}}' }}
	</body>
	</html>


| Keyword | Mandatory | Used For |
| -------- | -------- | -------- |
| path     | Yes      | Needed to know the path for the url     |
| site      | No        | Which configuration site to use  |
| tags     | No       | tags are used to design your website with some link  |
| draft     | No       | If draft equals to true, the document will not be published  |
| delete  | No       | If delete equals to true, the document will be delete  |

<script>
$(document).ready(function(){$('table').addClass('table');})
</script>