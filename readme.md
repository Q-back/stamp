Readme
======

**Stamp** is both an easy, flexible templating language for newsletter content, and a PHP API for creating HTML templates compatible with the Stamp language.

Stamp Language
--------------

The Stamp language is typically used in *Stamp Content* files with the file extension `.sc`.

The Stamp language's syntax can be split into two different categories, the first of which are **Elements**.

###Element Reference

`==Newsletter Subject==` - The subject line of the newsletter. Opened and closed with two `=` characters.

`^15th June 2014^` - The human-readable date of the newsletter. Opened and closed with the `^` character. There is no specific format for this line, so you can use whichever date format you prefer.

`#Hello, World! Welcome to our monthly newsletter!#` - The introductory paragraph of the newsletter. Opened and closed with the `#` tag. Can be multi-line.






Templates
---------

A `.st` template is essentially a mixed PHP/HTML document.

The following variables exist for you to access the data from the specified `.sc` file, for example, `<p><? echo $st_date; ?></p>` would render the newsletter's date in a paragraph tag.


###Template Variables

`$st_date` - Human-readable date.

`$st_subject` - Subject line of the message (not actually featured in email HTML contents, hence optional).

`$st_intro` - Introductory paragraph, can be multiline. Line breaks are automatically converted to `<br />` tags.

`$st_numberOfItems` - Computed number of newsletter items.

The `$st_numberOfItems` variable is used in conjunction with a FOR loop and the `$st_item` array to iterate over items. For example:

	for ($i = 0; $i < $st_numberOfItems; $i++)
	{
		echo "<div class='block'><h1>" . $st_item[$i]['title'] . "</h1><p>" . $st_item[$i]['content'] . "</p></div>";
	}

By passing the expression variable (`$i`, in this case) as the first index in the `$st_item` array, you can use the second index to retrieve the following data:

`$st_item[itemnumber]['title']` - Title of the block.

`$st_item[itemnumber]['image_path']` - Filepath of the image.

`$st_item[itemnumber]['image_link']` - Destination URL of the image, when clicked.

`$st_item[itemnumber]['content']` - The HTML-escaped content of the block. Line breaks are automatically converted to `<br />` tags.

`$st_item[itemnumber]['link_title']` - The display text of the link.

`$st_item[itemnumber]['link_url']` - The destination URL of the link.

As of Stamp v1.0, Each block supports a title, a clickable image, body content and a clickable link.

Stamp syntax also has support for an optional banner advertisement. You can use the following variables:

`$st_hasBanner` - Boolean, returns True if a banner tag is present in the `.sc` file specified, returns false if there isn't one.

`$st_banner['image_path']` - Filepath of the banner image.

`$st_banner['image_link']` - Destination URL of the banner, when clicked.