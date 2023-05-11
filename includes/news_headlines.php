<?php
/*---------------------------------------------------+
| HoloCMS - Website and Content Management System
+----------------------------------------------------+
| Copyright &copy; 2008 Meth0d
+----------------------------------------------------+
| HoloCMS is provided "as is" and comes without
| warrenty of any kind. 
+---------------------------------------------------*/


// So many queries just to make it look pretty..

$news_1_query = $bdd->query("SELECT num, title, date, topstory, short_story FROM cms_news ORDER BY num DESC LIMIT 1");
$news_2_query = $bdd->query("SELECT num, title, date, topstory, short_story FROM cms_news ORDER BY num DESC LIMIT 1,2");
$news_3_query = $bdd->query("SELECT num, title, date, topstory, short_story FROM cms_news ORDER BY num DESC LIMIT 2,3");
$news_4_query = $bdd->query("SELECT num, title, date, topstory, short_story FROM cms_news ORDER BY num DESC LIMIT 3,4");

$news_1_row = $news_1_query ? $news_1_query->fetch(PDO::FETCH_ASSOC) : null;
$news_2_row = $news_2_query ? $news_2_query->fetch(PDO::FETCH_ASSOC) : null;
$news_3_row = $news_3_query ? $news_3_query->fetch(PDO::FETCH_ASSOC) : null;
$news_4_row = $news_4_query ? $news_4_query->fetch(PDO::FETCH_ASSOC) : null;

$news_1_title = isset($news_1_row['title']) ? HoloText($news_1_row['title']) : "News non trouv&eacute;e";
$news_1_snippet = isset($news_1_row['short_story']) ? HoloText($news_1_row['short_story']) : "Cet article n'existe pas.";
$news_1_date = isset($news_1_row['date']) ? HoloText($news_1_row['date']) : "";
$news_1_topstory = isset($news_1_row['topstory']) ? HoloText($news_1_row['topstory']) : "http://images.habbohotel.co.uk/c_images/Top_Story_Images/shabbolin_300x187_A.gif";
$news_1_id = isset($news_1_row['num']) ? HoloText($news_1_row['num']) : "";

$news_2_title = isset($news_2_row['title']) ? HoloText($news_2_row['title']) : "News non trouv&eacute;e";
$news_2_snippet = isset($news_2_row['short_story']) ? HoloText($news_2_row['short_story']) : "Cet article n'existe pas.";
$news_2_date = isset($news_2_row['date']) ? HoloText($news_2_row['date']) : "";
$news_2_topstory = isset($news_2_row['topstory']) ? HoloText($news_2_row['topstory']) : "http://images.habbohotel.co.uk/c_images/Top_Story_Images/shabbolin_300x187_A.gif";
$news_2_id = isset($news_2_row['num']) ? HoloText($news_2_row['num']) : "";

$news_3_title = isset($news_3_row['title']) ? HoloText($news_3_row['title']) : "";
$news_3_title = '';
$news_3_snippet = '';
$news_3_date = '';
$news_3_id = '';
if ($news_3_row) {
    $news_3_title = HoloText($news_3_row['title']);
    $news_3_snippet = HoloText($news_3_row['short_story']);
    $news_3_date = HoloText($news_3_row['date']);
    $news_3_id = HoloText($news_3_row['num']);

    if (empty($news_3_title)) {
        $news_3_title = "News non trouv&eacute;e";
    }
    if (empty($news_3_date)) {
        $news_3_date = "Cet article n'existe pas.";
    }
}

$news_4_title = '';
$news_4_snippet = '';
$news_4_date = '';
$news_4_id = '';
if ($news_4_row) {
    $news_4_title = HoloText($news_4_row['title']);
    $news_4_snippet = HoloText($news_4_row['short_story']);
    $news_4_date = HoloText($news_4_row['date']);
    $news_4_id = HoloText($news_4_row['num']);

    if (empty($news_4_title)) {
        $news_4_title = "News non trouv&eacute;e";
    }
    if (empty($news_4_date)) {
        $news_4_date = "Cet article n'existe pas.";
    }
}
