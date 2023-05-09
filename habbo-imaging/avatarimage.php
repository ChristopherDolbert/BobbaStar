<?php
// //////////////////////////////////////////////////////
//	avatarimage.php script by ltR.bdh (aka rangulf)
//
//	ver 1.0.0b
//	Thanks to Holo&HoloCMS Crew, Yifan Lu, Elitex
//  GD-Library is necessary
//	(c) 06.2009
// //////////////////////////////////////////////////////


// /////////////////// Constants ////////////////////////

// path to the directory where the figureparts are stored
$path_data = "./data/";

// define a credits text shown in the avatarimage
$show_credits = 1;
$credits_text = "bdh 2009";
$credits_color = array('r' => 0, 'g' => 45, 'b' => 255);
$credits_position = array('x' => 1, 'y' => 1);
$credits_font = 1; // 1 - 5

// array with sortinformation to display the parts in the right order
$sort_cmp = array('hd' => 1, 'sh' => 2, 'lg' => 3, 'ch' => 4, 'hr' => 5, 'wa' => 6, 'ca' => 7, 'fa' => 8, 'ea' => 9, 'ha' => 10, 'he' => 11);

// /////////////////// Sourcecode ///////////////////////

header('Content-type: image/png');


if(!isset($figure)) {$figure="hd-615-1";}

$img_master = imagecreatetruecolor(64, 110);

$color_transparent = @imagecolorallocate($img_master, 255, 255, 255); 
@imagefill ($img_master,1,1,$color_transparent);
@imagecolortransparent($img_master, $color_transparent); 

$figureparts = @split("\.",$figure);

@usort($figureparts, "cmp");

foreach($figureparts as $figurepart) {
	$partdata=@split("-",$figurepart,3);

	@imagedestroy($img_source);
	
	if (trim($partdata[2])!="") {
		$img_source = @imagecreatefrompng($path_data.$partdata[0]."/".$partdata[1]."/".$partdata[2].".png");
	}
	else {
		$img_source = @imagecreatefrompng($path_data.$partdata[0]."/".$partdata[1].".png");
	}

	$color_transparent = @imagecolorallocate($img_source, 255, 255, 255); 
	@imagecolortransparent($img_source, $color_transparent); 

	@imagecopymerge($img_master, $img_source, 0, 0, 0, 0, 64, 110, 100);
}

if (isset($size) && $size=="s") {
	$image_p = imagecreatetruecolor(33, 56);

	$color_transparent = @imagecolorallocate($image_p, 255, 255, 255); 
	@imagefill ($image_p,1,1,$color_transparent);
	@imagecolortransparent($image_p, $color_transparent); 

	@imagecopyresized ($image_p, $img_master, 0, 0, 0, 0, 33, 56, 64, 110);

	@imagepng($image_p);
	@imagedestroy($image_p);
}
else {
	if($show_credits) {
		$c_color = imagecolorallocate($img_master, $credits_color["r"], $credits_color["g"], $credits_color["b"]);
		imagestring($img_master, $credits_font, $credits_position["x"], $credits_position["y"], $credits_text, $c_color);
	}

	@imagepng($img_master);
}
@imagedestroy($img_master);

//function for sorting purposes
function cmp($a, $b) {
    global $sort_cmp;

	$a1=@substr($a,0,2);
	$b1=@substr($b,0,2);

	if (!isset($sort_cmp[$a1])) {return 0;}
	if (!isset($sort_cmp[$b1])) {return 0;}

	return ($sort_cmp[$a1] < $sort_cmp[$b1]) ? -1 : 1;
}