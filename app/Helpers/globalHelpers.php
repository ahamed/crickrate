<?php

  /**
     * Custom Map function
     *
    */
     function map($value, $low1, $high1, $low2, $high2) {
        return ($value / ($high1 - $low1)) * ($high2 - $low2) + $low2;
    }
