<?php
namespace Algorithms\Greedy\ActivityScheduling;

$start = array(1, 3, 0, 5, 3, 5, 6, 8, 8, 2, 12); // set s_i of activity starting times
// must sort by ascending order and maintain finish indice correlation (if not already sorted)
// with starting time indices - right now hardcoded
$finish = array(4, 5, 6, 7, 9, 9, 10, 11, 12, 14, 16); // set f_i of activity ending times

$example = new ActivitySelection();
$result = $example->recursiveActivitySelector($start, $finish, 0, count($finish)-1);
var_dump($result);

class ActivitySelection
{
    private $a = array();
    public function __construct()
    {}

    /**
     * PHP implementation example of solving an
     * activity scheduling problem by implementing
     * a simple top-down Greedy algorithm
     */
    public function recursiveActivitySelector(array $start, array $finish, $k, $n)
    {
        $m = $k + 1;
        while ($m <= $n && $start[$m] < $finish[$k]) {
            $m += 1;
        }

        // greedy element - time interval is not overlapping (optimal)
        // add the corresponding indice and total interval for the activity
        array_push($this->a, $k.'::'.$start[$k].'-'.$finish[$k]);

        unset($start[$k]); // activity interval compatible and taken, so remove start time
        unset($finish[$k]); // since activity interval taken, remove corresponding finish time

        if ($m <= $n) {
            return $this->recursiveActivitySelector($start, $finish, $m, $n);
        } else {
            $start = array_values($start); // reindex array after full pass
            $finish = array_values($finish); // reindex array after full pass

            array_push($this->a, '----------------------------------'); // new partition for overlapping intervals
            return !empty($finish) ? $this->recursiveActivitySelector($start, $finish, 0, count($finish)-1) : $this->a;
        }
    }
}

?>