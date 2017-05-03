Readme
======

**Stamp** is both an easy, flexible templating language for newsletter content, and a PHP API for creating HTML templates compatible with the Stamp language.

Stamp Language
--------------

The Stamp language is typically used in *Stamp Content* files with the file extension `.stamp`.

The Stamp language's syntax can be split into two different categories, the first of which are **Document Elements**.

###Document Elements

`==Newsletter Subject==` - The subject line of the newsletter. Opened and closed with two `=` characters.

`^15th June 2014^` - The human-readable date of the newsletter. Opened and closed with the `^` character. There is no specific format for this line, so you can use whichever date format you prefer.

`#Hello, World! Welcome to our monthly newsletter!#` - The introductory paragraph of the newsletter. Opened and closed with the `#` tag. Can be multi-line.

`{bannerimage.png|http://destination.url}` - *(Optional)* The banner advertisement of the newsletter. Opened with the `{` character and closed with the `}` character. The image path and destination URL are separated by the `|` character, on the left and the right, respectively.

The other category of Stamp syntax refers to **Item Elements**.

###Item Elements

An item element refers to any element of the `.stamp` file contained within an **Item**. Items are what makes up the core content of your newsletter, and you can have unlimited items in the same `.stamp` document.

Have a look at the following Stamp code for an example item:

	<
	-First Item-
	?[http://placehold.it/280x125|http://www.google.com]
	
	"This is the first item. These paragraphs are rendered exactly like the intro paragraph, with each new line replaced by a HTML line break, and all entities HTML encoded."
	
	![Click here|http://www.google.com]
	>
	
An item is opened with the `<` character, and closed with a `>` character. These characters don't necessarily need to be on their own line, but for the sake of readibility, it's recommended.

The following elements exist within an item:

`-First Item-` - The title of the item. Opened and closed with `-` characters.

`?[http://placehold.it/280x125|http://www.google.com]` - The item's image. Image links are opened with `?[`, and closed with `]`. The image's filepath and destination link are seperated on the right and left, respectively, by the `|` character.

`"This is the first item..."` - The item's main content. Can be multiline.

`![Click here|http://www.google.com]` - The item's main link. The text link syntax is identical to that of the image link, only it opens with a `!` character, instead of a `?`.

These four elements can only be used inside an item, but they can sit in any position within the element. Likewise, the subject, date, introductory paragraph and banner ad tags can be used anywhere in the document outside of an item. This allows you more flexibility to write your `.stamp` document to better visually match your HTML template.


Templates
---------

A `.temp` template is essentially a mixed PHP/HTML document.

The following variables exist for you to access the data from the specified `.stamp` file, for example, `<p><? echo $st_date; ?></p>` would render the newsletter's date in a paragraph tag.


###Template Variables

`$st_date` - Human-readable date.

`$st_subject` - Subject line of the message (not actually featured in email HTML contents, hence optional).

`$st_intro` - Introductory paragraph, can be multiline. Line breaks are automatically converted to `<br />` tags.

`$st_numberOfItems` - Computed number of newsletter items.

The `$st_numberOfItems` variable is used in conjunction with a FOR loop and the `$st_item` array to iterate over items. For example:

	for ($i = 0; $i < $st_numberOfItems; $i++)
	{
		echo "<div class='item'><h1>" . $st_item[$i]['title'] . "</h1><p>" . $st_item[$i]['content'] . "</p></div>";
	}

By passing the expression variable (`$i`, in this case) as the first index in the `$st_item` array, you can use the second index to retrieve the item's data. By passing a fixed integer as the first index, you can access the data of specific blocks, to make the first block in a document a wider size, for example.

The following variables exist for accessing item elements:

`$st_item[itemnumber]['title']` - Title of the item.

`$st_item[itemnumber]['image_path']` - Filepath of the image.

`$st_item[itemnumber]['image_link']` - Destination URL of the image, when clicked.

`$st_item[itemnumber]['content']` - The HTML-escaped content of the item. Line breaks are automatically converted to `<br />` tags.

`$st_item[itemnumber]['link_title']` - The display text of the link.

`$st_item[itemnumber]['link_url']` - The destination URL of the link.

As of Stamp v1.0, Each item supports a title, a clickable image, body content and a clickable link.

Stamp syntax also has support for an optional banner advertisement. You can use the following variables:

`$st_hasBanner` - Boolean, returns True if a banner tag is present in the `.stamp` file specified, returns false if there isn't one.

`$st_banner['image_path']` - Filepath of the banner image.

`$st_banner['image_link']` - Destination URL of the banner, when clicked.