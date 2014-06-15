<?
/*                                                                                          
   SSSSSSSSSSSSSSS     tttt                                                                     
 SS:::::::::::::::S ttt:::t                                                                     
S:::::SSSSSS::::::S t:::::t                                                                     
S:::::S     SSSSSSS t:::::t                                                                     
S:::::S       ttttttt:::::ttttttt     aaaaaaaaaaaaa     mmmmmmm    mmmmmmm  ppppp   ppppppppp   
S:::::S       t:::::::::::::::::t     a::::::::::::a  mm:::::::m  m:::::::mmp::::ppp:::::::::p  
 S::::SSSS    t:::::::::::::::::t     aaaaaaaaa:::::am::::::::::mm::::::::::p:::::::::::::::::p 
  SS::::::SSSStttttt:::::::tttttt              a::::am::::::::::::::::::::::pp::::::ppppp::::::p
    SSS::::::::SS   t:::::t             aaaaaaa:::::am:::::mmm::::::mmm:::::mp:::::p     p:::::p
       SSSSSS::::S  t:::::t           aa::::::::::::am::::m   m::::m   m::::mp:::::p     p:::::p
            S:::::S t:::::t          a::::aaaa::::::am::::m   m::::m   m::::mp:::::p     p:::::p
            S:::::S t:::::t    ttttta::::a    a:::::am::::m   m::::m   m::::mp:::::p    p::::::p
SSSSSSS     S:::::S t::::::tttt:::::a::::a    a:::::am::::m   m::::m   m::::mp:::::ppppp:::::::p
S::::::SSSSSS:::::S tt::::::::::::::a:::::aaaa::::::am::::m   m::::m   m::::mp::::::::::::::::p 
S:::::::::::::::SS    tt:::::::::::tta::::::::::aa:::m::::m   m::::m   m::::mp::::::::::::::pp  
 SSSSSSSSSSSSSSS        ttttttttttt   aaaaaaaaaa  aaammmmmm   mmmmmm   mmmmmmp::::::pppppppp    
                                                                             p:::::p            
                                                                             p:::::p            
                                                                            p:::::::p           
                                                                            p:::::::p           
                                                                            p:::::::p           
                                                                            ppppppppp           


					An easy Newsletter Templating engine by Charlie Wilson
										
										Version 1.0


TEMPLATE DOCS:

A .st template is essentially a mixed PHP/HTML document.

The following variables exist for you to access the .sc data, for example, <p><? echo $st_date; ?></p> would render the newsletter's date in a paragraph tag.

$st_date - Human-readable date.
$st_subject - Subject line of the message (not actually featured in email HTML contents, hence optional).
$st_intro - Introductory paragraph, can be multiline. Line breaks are automatically converted to <br /> tags.
$st_numberOfItems - Computed number of newsletter items.

The $st_numberOfItems variable is used in conjunction with a FOR loop and the $st_item array to iterate over items.
For example:

for ($i = 0; $i < $st_numberOfItems; $i++)
{
	echo "<div class='block'><h1>" . $st_item[$i]['title'] . "</h1><p>" . $st_item[$i]['content'] . "</p></div>";
}

By passing the expression variable ($i, in this case) as the first index in the $st_item array, you can use the second index to retrieve the following data:

$st_item[itemnumber]['title'] - Title of the block.
$st_item[itemnumber]['image_path'] - Filepath of the image.
$st_item[itemnumber]['image_link'] - Destination URL of the image, when clicked.
$st_item[itemnumber]['content'] - The HTML-escaped content of the block. Line breaks are automatically converted to <br /> tags.
$st_item[itemnumber]['link_title'] - The display text of the link.
$st_item[itemnumber]['link_url'] - The destination URL of the link.

As of Stamp v1.0, Each block supports a title, a clickable image, body content and a clickable link.

Stamp syntax also has support for an optional banner advertisement. You can use the following variables:

$st_hasBanner - Boolean, returns True if a banner tag is present in the .sc file specified, returns false if there isn't one.
$st_banner['image_path'] - Filepath of the banner image.
$st_banner['image_link'] - Destination URL of the banner, when clicked.

*/

//Returns the version number. Something of a "Hello, World" for my projects :)
function stampVersion()
{
	return 1.0;
}

//Returns the raw HTML content of the rendered newsletter
//$contentFile - An .sc file containing the newsletter's content
//$templateFile - An .st file containing the Stamp template to be used in rendering
function stampRender($contentFile, $templateFile)
{
	//Read the Stamp content file into a string for analysis
	$inFile = file_get_contents($contentFile);

	//Regex match Elements and output to arrays
	//^13th June 2014^
	preg_match("/\^[\s\S]+\^/", $inFile, $date);

	//==subject==
	preg_match("/\=\=[\s\S]+\=\=/", $inFile, $subject);

	//#copybody#
	preg_match("/\#[\s\S]+\#/", $inFile, $intro);

	//*(item block)*
	preg_match_all("/\<[\s\S][^\>]+\>/", $inFile, $block, PREG_SET_ORDER);

	//{http://bannerad.imageurl|http://bannerad.link}
	preg_match("/{[\s\S][^\]]+}/", $inFile, $bannerline);

	//Number of item slots to render
	$st_numberOfItems = sizeof($block);

	//Strip tags from returned arrays and assign to variables
	$st_date = str_replace("^", "", $date[0]);
	$st_subject = str_replace("=", "", $subject[0]);
	$st_intro = nl2br(htmlentities(str_replace("#", "", $intro[0])));

	//Remove the start/end tags from the banner line (if it exists), and explode by | to get the image URL and destination link
	if ($bannerline)
	{
		$a = trim(substr($bannerline[0], 1, -1));
		$b = explode("|", $a);
		$st_hasBanner = true;
		$st_banner['image_path'] = trim($b[0]);
		$st_banner['image_link'] = trim($b[1]);
	}
	else
	{
		$st_hasBanner = false;
		$st_banner['image_path'] = false;
		$st_banner['image_link'] = false;
	}
	
	//Regex match the items within each block and define output arrays
	for ($i = 0; $i < $st_numberOfItems; $i++)
	{
		//implode() is used with a blank match to convert a specific array value to a string:
		//-item title-
		preg_match("/^-[\s\S]+-$/m", implode('',$block[$i]), $itemtitle);
		//?[http://image.url|http://image.link]
		preg_match("/(\?\[)[\s\S][^\]]+\]/", implode('',$block[$i]), $imageline);
		//"Body text"
		preg_match("/\"[\s\S]+\"/", implode('',$block[$i]), $bodytext);
		//![Link Title|http://link.url]
		preg_match("/(\!\[)[\s\S][^\]]+\]/", implode('',$block[$i]), $linkline);

		//Create the $st_item array for each item and sanitise it's inputs:
		//Strip preceding and trailing '-' from title and trim the whitespace
		$st_item[$i]['title'] = htmlentities(trim(substr($itemtitle[0], 1, -1)));

		//Remove the start/end tags from the image line, and explode by | to get the image URL and destination link
		$a = trim(substr($imageline[0], 2, -1));
		$b = explode("|", $a);
		$st_item[$i]['image_path'] = trim($b[0]);
		$st_item[$i]['image_link'] = trim($b[1]);

		//Strip preceding and trailing '"' from body text and trim the whitespace
		$st_item[$i]['content'] = htmlentities(trim(substr($bodytext[0], 1, -1)));

		//Remove the start/end tags from the link line, and explode by | to get the link title and URL
		$a = trim(substr($linkline[0], 2, -1));
		$b = explode("|", $a);
		$st_item[$i]['link_title'] = htmlentities(trim($b[0]));
		$st_item[$i]['link_url'] = trim($b[1]);
	}
	
	//Use output buffering to 'capture' the required template file's output, and return it.	
	ob_start();
	require_once($templateFile);
	return ob_get_clean();
	ob_end_clean();
}
?>