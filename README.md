PHP Symbolic File Browser
=========================
*a clean and simple solution to serve files and show folders outside of your public html folder*

A single php and .htaccess file that can make a private folder in another directory such as a folder outside of a public directory.

Examples
--------
>use the parameter cache=false to send no cache headers

Direct access to a file:
```
getfile.php?file=/file.foo
```
With .htaccess rewrite:
```
protected/file.foo
```
Direct access to a file inside another folder:
```
getfile.php/folder/file.foo
```
With .htaccess rewrite:
```
protected/folder/file.foo
```

Inside an img tag:
```
<img src="getfile.php?file=image.jpg">
```
Or with .htaccess rewrite:
```
<img src="protected/image.jpg">
```
