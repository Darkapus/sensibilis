---
created: 2017-01-16 12:28:01
draft: false
path: /documentation
title: Understand Sensibilis
site: sensibilis
showMarkdown: true
type: documentation
sidebar:
  markdown: /documentation/menu
showChilds: true

---

> The web tends towards - **full static fronts**, soliciting a minimum servers. Thus the costs of the contents are greatly reduced because the "**safety**" aspect of the rubles is no longer to be managed.

Sensibilis is made for you if - **you are sensitive to** - what we are spending our time for it:

- Security
- Speed
- Readable
- SEO
- External backup (like dropbox)


## Definition of CMS
Content Management System (CMS) is a vague term, any software manages a content. More precisely we give this name to a software that manages the creation and publication of documents, possibly in a collaborative way.

## Easy management
With Sensibilis, it is possible to manage content and push it anywhere.

> The markdown is a easy and readable language that can translate into HTML. In addition, it takes less disk space than content managed by wysiwyg.


## A precise breakdown by activity
 - The template will be made by a **graphic designer**
 - The use of the variables in the templates will be managed by an **integrator**
 - Content will be wrote by the **publisher**

> However its simplicity of grip allows everything to be realized by the same person.

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<canvas id="myChart" width="450" height="300"></canvas>
<script>
var ctx = document.getElementById("myChart");

var data = {
    labels: ["graphic designer", "integrator", "publisher"],
    datasets: [
        {
            data: [20, 10, 70],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        }
    ]
};

var myRadarChart = new Chart(ctx, {
    type: 'pie',
    data: data,
		options: {responsive: true, legend: {position: 'right'}, title: {position: 'left', display: true,text: "Time to work"}}
});
</script>

## Static Deployment
Sensibilis opts for a static HTML page deployment, it allows to manage contents in - front end static - and to have a static stable architecture (non dynamic) and therefore with absolute security of your data.

Also, backing up your content is simple because there is no database.

## Composition of a document
There is the header and body of the document, the header allows to define the document's strategy and the body is simply the content that will be readable by the reader.

### Head
~~~ Markdown
---
draft: false
path: /documentation/help
site: sensibilis

---
~~~
	
- The variable "site: sensilis" allows to define where the content will be deposited during the deployment.
- The variable "path: / documentation / help" allows to define the url, here it will be http://www.sensibilis.fr/documentation/help
- The "draft: false" variable means that this document will have to be taken into account during the next deployment


### Body