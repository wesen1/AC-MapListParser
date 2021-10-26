<?php
/**
 * @file
 * @version 0.1
 * @copyright 2018 wesen <wesen-ac@web.de>
 * @author wesen
 */

$loader = require_once(__DIR__ . "/vendor/autoload.php");
$loader->addPsr4("MapListParser\\", __DIR__ . "/src");

use MapListParser\MapNameChecker;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;


$dom = new Dom();
$mapNameChecker = new MapNameChecker();

echo "Loading DOM from URL ... ";
$dom->loadFromUrl("frag.gq/packages/maps/");
echo "Done\n";

echo "Finding all anchor tags in DOM ... ";

/** @var HtmlNode[] $links */
$links = $dom->find("a");
$gemaMapLinks = array();
echo "Done\n";


echo "Finding all gema map links ... ";
foreach ($links as $link)
{
    $mapName = urldecode($link->getAttribute("href"));

    if ($mapNameChecker->isGemaMapName($mapName)) $gemaMapLinks[] = $link;
}
echo "Done\n";


$counter = 0;
$amountGemaMapLinks = count($gemaMapLinks);
$outputFolder = __DIR__ . "/maps";

if (!is_dir($outputFolder))
{
    mkdir($outputFolder);
}

$fileNames = array();

echo "Downloading gema maps ...\n";
foreach ($gemaMapLinks as $gemaMapLink)
{
    if ($mapNameChecker->isGemaMapName($gemaMapLink->text()))
    {
        $fileName = urldecode($gemaMapLink->getAttribute("href"));
        $url = "http://www.frag.gq/packages/maps/" . $fileName;

        $fileNames[] = $fileName;

        echo "Downloading file " . ++$counter . " of " . $amountGemaMapLinks . "\r";
        system("wget \"" . $url . "\" -O \"" . $outputFolder . "/" . $fileName . "\" 2>/dev/null");
    }
}
echo "Done\n";

echo "Extracting downloaded zip packages ... ";
system("unzip \"" . __DIR__ . "/maps/*\" -d \"" . __DIR__ . "/maps-extracted\"");
echo "Done\n\n\n";
