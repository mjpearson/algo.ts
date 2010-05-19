<?php
/**
 * Maintains standard deviation, time independant for float $value
 */
namespace AlgoTS;

class stddev {

	private $xWindow = array();
	private $xTotal = 0;
	private $xCount = 0;

	var $xMean = 0;
	var $stdDev = 0;

	private $maxWindow = 0;

	function __construct($maxWindow = 0) {
		if ($maxWindow) $this->maxWindow = $maxWindow;
	}

	/**
	 * Calculates, saves and returns a current Std Dev for $value.
	 * @param $value float Value to return standard deviation for when added to the set
	 * @return $stdDev float Standard Deviation as at point $value
	 */
	function calc($value) {
                $this->xCount = array_push($this->xWindow, $value);

		// recalculate if a window size specified
		if ($this->maxWindow && $this->xCount > $this->maxWindow) {
			array_shift($this->xWindow);
			$this->xCount = sizeof($this->xWindow);
			$this->xTotal = array_sum($this->xWindow);
		} else {
	                $this->xTotal += $value;
		}

                $this->xMean = ($this->xTotal / $this->xCount);

                // calculate standard deviation
                $dTotal = 0;
                foreach ($this->xWindow as $x) {
                        $d = abs($x - $this->xMean);
                        $dTotal += ($d * $d);
                }

                $this->stdDev = sqrt($dTotal / $this->xCount);

		return $this->stdDev;
	}
}
?>
