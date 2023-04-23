<?php
include('config.php');
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:taxo=\"http://purl.org/rss/1.0/modules/taxonomy/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" version=\"2.0\">";
echo "
  <channel>
    <title>" . $sitename . " News</title>
    <link>" . $url . "</link>
    <description>The latest happenings on " . $shortname . " direct to your news reader</description>";

$sql = $bdd->query("SELECT * FROM gabcms_news ORDER BY -id");
$c = 0;
while ($news = $sql->fetch()) {
  $c++;
  echo "
    <item>
      <title>" . $news[title]  . "</title>
      <link>" . $url . "articles.php?id=" . $news[id] . "</link>
      <description>" . $news[shortstory] . "</description>
      <pubDate>" . $news[date] . "</pubDate>
      <guid isPermaLink=\"true\">" . $url . "news.php?id=" . $news[id] . "</guid>
      <dc:date>" . $news[id] . "</dc:date>
    </item>";
}

echo "
</channel>
</rss>";
