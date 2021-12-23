<?php

namespace Day23;

class Main extends \Base
{
    public function title(): string
    {
        return "Amphipod";
    }

    public function clearOutput()
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    }

    private function runGame($lines): void
    {
        $board = new Board($lines);
        $board->selectNextAmphipod();

        $stdin = fopen('php://stdin', 'r');
        stream_set_blocking($stdin, false);
        system('stty cbreak -echo');

        while (true) {
            $this->clearOutput();

            $keypress = fgets($stdin);
            if ($keypress) {
                //echo 'Key pressed: ' . $this->translateKeypress($keypress) . PHP_EOL;
                switch ($this->translateKeypress($keypress)) {
                    case "SPACE":
                        $board->selectNextAmphipod();
                        break;
                    case "UP":
                    case "DOWN":
                    case "LEFT":
                    case "RIGHT":
                        $board->moveSelectedAmphipod($this->translateKeypress($keypress));
                        break;
                    case "z":
                    case "Z":
                        $board->undoLastSwap();
                        break;
                    case "ESC":
                        break 2;
                }
            }

            echo $board->render();

            echo "\n";
            echo "Energy Used: " . $board->energyUsed() . "\n";
            echo "Message: " . $board->getMessage() . "\n";
            echo "\n";
            echo "Controls: [space] = Select next Amphipod\n          [arrow keys] = Move selected Amphipod\n          [ESC] = Goto part 2/Quit)";

            usleep(1000 * 100);
        }
    }

    public function one(): string
    {
        $lines = [];
        $lines[] = "#############";
        $lines[] = "#...........#";
        $lines[] = "###A#D#B#D###";
        $lines[] = "  #B#C#A#C#";
        $lines[] = "  #########";

        $this->runGame($lines);

        echo "\n";
        return "Game One Over";
    }

    public function two(): string
    {
        $lines = [];
        $lines[] = "#############";
        $lines[] = "#...........#";
        $lines[] = "###A#D#B#D###";
        $lines[] = "  #D#C#B#A#";
        $lines[] = "  #D#B#A#C#";
        $lines[] = "  #B#C#A#C#";
        $lines[] = "  #########";

        $this->runGame($lines);

        echo "\n";
        return "Game Two Over";
    }

    private function translateKeypress($string)
    {
        switch ($string) {
            case "\033[A": return "UP";
            case "\033[B": return "DOWN";
            case "\033[C": return "RIGHT";
            case "\033[D": return "LEFT";
            case "\n": return "ENTER";
            case " ": return "SPACE";
            case "\e": return "ESC";
        }
        return $string;
    }
}
