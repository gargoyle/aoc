<?php

namespace Day06;

class Main extends \Base
{
    public function title(): string
    {
        return "Lanternfish";
    }

    public function one(): string
    {
        $days = 80;
        $fishData = explode(",", $this->lines[0]);

        for ($i = 0; $i <= 8; $i++) {
            $fishAtTimer[$i] = 0;
        }
        foreach ($fishData as $fish) {
            $fishAtTimer[$fish]++;
        }

        for ($d = 1; $d <= $days; $d++) {
            // Fish at timer 0 are ready to spawn.
            $spawningFish = $fishAtTimer[0];

            // Shunt other fish down a group.
            for ($i = 1; $i <= 8; $i++) {
                $fishAtTimer[$i - 1] = $fishAtTimer[$i];
            }

            // Add the same number of new fish as spawning fish to group 8
            $fishAtTimer[8] = $spawningFish;

            // Append spawning fish to group 6.
            $fishAtTimer[6] += $spawningFish;
        }

        return array_sum($fishAtTimer);
    }

    public function two(): string
    {
        $days = 256;
        $fishData = explode(",", $this->lines[0]);

        for ($i = 0; $i <= 8; $i++) {
            $fishAtTimer[$i] = 0;
        }
        foreach ($fishData as $fish) {
            $fishAtTimer[$fish]++;
        }

        for ($d = 1; $d <= $days; $d++) {
            $spawningFish = $fishAtTimer[0];
            for ($i = 1; $i <= 8; $i++) {
                $fishAtTimer[$i - 1] = $fishAtTimer[$i];
            }
            $fishAtTimer[8] = $spawningFish;
            $fishAtTimer[6] += $spawningFish;
        }

        return array_sum($fishAtTimer);
    }
}
