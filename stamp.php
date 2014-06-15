<?
/*
	Stamp v1.0
	An easy, flexible templating language and API for HTML newsletters
*/

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