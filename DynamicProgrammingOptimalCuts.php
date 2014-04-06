<?php
namespace Algorithms\DynamicProgramming\OptimalCuts;

define("CUT_LENGTH", 4); // number of cuts we want to find optimal revenue for (4 lengths)
$price = array(0, 1, 5, 8, 9, 10, 17, 17, 20, 24, 30);

$example = new DynamicProgrammingOptimalCuts();
$memo = $example->initializeLookup();
$revenue = $example->memoizedRodCut($price, CUT_LENGTH, $memo);

echo '*********************************<br />';
echo "Cuts at: yield an Optimal Revenue of: {$revenue}";
echo '<br />*********************************';

/**
 * PHP implementation example of a simple Dynamic Programming
 * top-down algorithm for finding the optimal revenue of
 * an item whose value differs by the length of cuts.
 * Using array memoization brings the running time to Θ(n²)
 */
class DynamicProgrammingOptimalCuts
{
    public function __construct()
    {}

    public function initializeLookup()
    {
        $pricesUnknown = array();
        for ($i = 0; $i <= CUT_LENGTH; $i++) {
            $pricesUnknown[$i] = -1; // unknown prices start negative
        }
        return $pricesUnknown;
    }

    public function memoizedRodCut(array $price, $n, array $memo)
    {
        if ($memo[$n] >= 0) { // check if already stored
            return $memo[$n];
        }

        if ($n == 0) { // at the bottom
            $q = $price[0]; // set a *zero length* item to non negative zero price
        } else {
            $q = -1; // we want to initially compare with an unknown price
            for ($i = 1; $i <= $n; $i++) {
                $q = max($q, $price[$i] + $this->memoizedRodCut($price, $n - $i, $memo)); // get optimal from sub problems
            }
        }

        $memo[$n] = $q; // add to lookup table
        return $q;
    }
}

?>