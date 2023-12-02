package main

import (
	"bufio"
	"fmt"
	"os"
	"slices"
	"strconv"
	"strings"
)

func check(e error) {
	if e != nil {
		panic(e)
	}
}

func parseLine(line []string, checkwords bool) int {
	sNums := []string{"one", "two", "three", "four", "five", "six", "seven", "eight", "nine"}
	digits := []string{"", ""}

	for s := 0; s < len(line); s++ {
		character := line[s]
		if _, err := strconv.Atoi(character); err == nil {
			if digits[0] == "" {
				digits[0] = character
			}
			digits[1] = character

			continue
		}

		if !checkwords {
			continue
		}

		for e := s; e <= len(line); e++ {
			substr := line[s:e]
			idx := slices.Index(sNums, strings.Join(substr, ""))
			if idx != -1 {
				if digits[0] == "" {
					digits[0] = fmt.Sprint(idx + 1)
				}
				digits[1] = fmt.Sprint(idx + 1)
			}

		}
	}

	calibrationValueStr := strings.Join(digits, "")
	i, _ := strconv.Atoi(calibrationValueStr)
	return i
}

func main() {

	file, err := os.Open("input.txt")
	check(err)

	scanner := bufio.NewScanner(file)
	p1total := 0
	p2total := 0

	for scanner.Scan() {
		p1total += parseLine(strings.Split(scanner.Text(), ""), false)
		p2total += parseLine(strings.Split(scanner.Text(), ""), true)
	}

	fmt.Printf("Part 1: %d\n", p1total)
	fmt.Printf("Part 2: %d\n", p2total)

	file.Close()
}
