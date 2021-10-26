<?php
/**
 * @file
 * @version 0.1
 * @copyright 2018 wesen <wesen-ac@web.de>
 * @author wesen
 */

namespace MapListParser;

/**
 * Checks whether a map name is a gema map name.
 */
class MapNameChecker
{
    /**
     * The gema map name implicit words
     * If a map name contains one of these words it will be counted as a gema map name
     * even when it doesn't contain the gema map name codes
     *
     * @var string[] $gemaMapNameImplicits
     */
    private $gemaMapNameImplicits = array("jigsaw", "deadmeat-10");


    /**
     * Returns whether a map name is a gema map name.
     *
     * @param string $_mapName The map name
     *
     * @return bool True: The map name is a gema map name
     *              False: The map name is not a gema map name
     */
    public function isGemaMapName(string $_mapName)
    {
        $mapName = strtolower($_mapName);
        return ($this->containsGemaMapNameImplicit($mapName) || $this->containsGemaMapNameCodes($mapName));
    }

    /**
     * Returns whether $_mapName contains the word "jigsaw" or "deadmeat-10".
     *
     * @param String $_mapName The map name
     *
     * @return bool True: The map name contains the word "jigsaw" or "deadmeat-10"
     *              False: The map name does not contain the word "jigsaw" or "deadmeat-10"
     */
    private function containsGemaMapNameImplicit(String $_mapName)
    {
        foreach ($this->gemaMapNameImplicits as $gemaMapNameImplicit)
        {
            if (stristr($_mapName, $gemaMapNameImplicit) !== false) return true;
        }

        return false;
    }

    /**
     * Checks whether a map name contains ge3ma@4.
     *
     * @param String $_mapName The map name
     *
     * @return bool 0: Map name does not contain ge3ma@4
     *              1: Map name contains ge3ma@4
     */
    private function containsGemaMapNameCodes (string $_mapName)
    {
        return preg_match("/g[e3]m[a@4]/", $_mapName);
    }
}
