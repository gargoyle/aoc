package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
	"strings"
)

func check(e error) {
	if e != nil {
		panic(e)
	}
}

type symbol struct {
	Char  string
	X     int
	Y     int
	Ratio int
}

type partNum struct {
	Num string
	X   int
	Y   int
}

func (part partNum) value() int {
	val, _ := strconv.Atoi(part.Num)
	return val
}

func (p partNum) isAdjacent(sym symbol) bool {
	if ((p.X - 1) <= sym.X) && ((p.X + len(p.Num)) >= sym.X) &&
		((p.Y - 1) <= sym.Y) && ((p.Y + 1) >= sym.Y) {
		return true
	}
	return false
}

var schematicLines []string
var realPartNumbers []partNum
var possiblePartNumbers []partNum
var symbols []symbol

func load() {
	file, err := os.Open("input.txt")
	check(err)

	scanner := bufio.NewScanner(file)
	y := 0
	for scanner.Scan() {
		line := scanner.Text()
		var partNumBuffer []string

		for x := 0; x < len(line); x++ {
			char := string(line[x])

			if _, err := strconv.Atoi(char); err == nil {
				// If we have a digit, stuff it into a buffer.
				partNumBuffer = append(partNumBuffer, char)
			} else {
				// Otherwise, if the buffer is not empty save the part number and reset the buffer.
				if len(partNumBuffer) > 0 {
					possiblePartNumbers = append(possiblePartNumbers, partNum{
						Num: strings.Join(partNumBuffer, ""),
						X:   x - len(partNumBuffer),
						Y:   y})
					partNumBuffer = nil
				}

				// If not a ".", save the symbol.
				if char != "." {
					symbols = append(symbols, symbol{Char: char, X: x, Y: y})
				}
			}
		}
		y++
	}
}

func main() {
	load()

	sum := 0
	for _, poss := range possiblePartNumbers {
		for _, sym := range symbols {
			if poss.isAdjacent(sym) {
				realPartNumbers = append(realPartNumbers, poss)
				sum = sum + poss.value()
			}
		}
	}

	ratioSum := 0
	for _, sym := range symbols {
		first := -1

		if sym.Char != "*" {
			continue
		}

		for _, pn := range realPartNumbers {
			if pn.isAdjacent(sym) {
				if first == -1 {
					first = pn.value()
				} else {
					sym.Ratio = first * pn.value()
					first = -1
				}
			}
		}

		ratioSum = ratioSum + sym.Ratio
	}

	fmt.Printf("Part 1: %d\n", sum)
	fmt.Printf("Part 2: %d\n", ratioSum)
}
