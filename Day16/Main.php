<?php

namespace Day16;

class Main extends \Base
{
    public function title(): string
    {
        return "Packet Decoder";
    }

    public function popBits(&$bits, int $length): string
    {
        $popped = substr($bits, 0, $length);
        $bits = substr($bits, $length);

        return $popped;
    }

    public function one(): string
    {
        $hexBytes = str_split($this->lines[0]);
        $bits = '';
        foreach ($hexBytes as $byte) {
            $tmp = str_pad(base_convert($byte, 16, 2), 4, "0", STR_PAD_LEFT);
            $bits .= $tmp;
        }

        $packets = $this->decodePayload($bits);
        $versionSum = $this->sumPacketVersions($packets);
        return $versionSum;
    }

    public function two(): string
    {
        $hexBytes = str_split($this->lines[0]);
        $bits = '';
        foreach ($hexBytes as $byte) {
            $tmp = str_pad(base_convert($byte, 16, 2), 4, "0", STR_PAD_LEFT);
            $bits .= $tmp;
        }

        $packets = $this->decodePayload($bits);
        return $packets[0]->value();
    }


    public function sumPacketVersions(array $packets): int
    {
        $versionSum = 0;
        foreach ($packets as $packet) {
            $versionSum += $packet->ver;
            if (is_array($packet->payload)) {
                $versionSum+= $this->sumPacketVersions($packet->payload);
            }
        }
        return $versionSum;
    }


    public function decodePayload(string &$bits, $limit = 0): array
    {
        $packets = [];
        $count = 0;
        while (!empty($bits)) {
            $count++;
            if (($limit !== 0) && ($count > $limit)) {
                break;
            }

            if (strlen($bits) < 6) {
                // not enough for a valid packet, must be end of transmission padding.
                break;
            }

            $packet = new Packet();
            $packet->ver = bindec($this->popBits($bits, 3));
            $packet->type = bindec($this->popBits($bits, 3));

            switch ($packet->type) {
                case 4:
                    // Value packet
                    $buffer = '';
                    do {
                        $chunk = $this->popBits($bits, 5);
                        $buffer .= substr($chunk, 1);
                    } while ($chunk[0] !== "0");
                    $packet->payload = bindec($buffer);
                    break;
                default:
                    // Operator Packet;
                    $packet->lenType = $this->popBits($bits, 1);
                    if ($packet->lenType == "0") {
                        $packet->length = bindec($this->popBits($bits, 15));
                        $tmpPayload = $this->popBits($bits, $packet->length);
                        $packet->payload = $this->decodePayload($tmpPayload);
                    } else {
                        $packet->length = bindec($this->popBits($bits, 11));
                        $packet->payload = $this->decodePayload($bits, $packet->length);
                    }
                    break;
            }

            if ($packet !== null) {
                $packets[] = $packet;
            }
        }
        return $packets;
    }
}
