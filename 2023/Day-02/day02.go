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

// a set of cubes in 3 possible colours
type CubeSet struct {
	Red   int
	Green int
	Blue  int
}

// is a single set of cubes playable with a supplied set of cubes
func (required CubeSet) playableWith(supply CubeSet) bool {
	return ((required.Red <= supply.Red) && (required.Blue <= supply.Blue) && (required.Green <= supply.Green))
}

func (target *CubeSet) setColourCount(colour string, count int) *CubeSet {
	// fmt.Printf("Setting colour count for %s to %d\n", colour, count)
	switch colour {
	case "red":
		target.Red = count
	case "green":
		target.Green = count
	case "blue":
		target.Blue = count
	}
	return target
}

func (cs CubeSet) cubesetPower() int {
	return cs.Red * cs.Blue * cs.Green
}

// a game has multiple sets (we'll call them rounds)
type Game struct {
	id     int
	rounds []*CubeSet
}

// is a whole game playable with a supplied set of cubes
func (theGame Game) playableWith(supply CubeSet) bool {
	for _, round := range theGame.rounds {
		if !round.playableWith(supply) {
			return false
		}
	}

	return true
}

func (theGame Game) minimumSet() CubeSet {
	minimumSet := CubeSet{Red: 0, Green: 0, Blue: 0}
	for _, round := range theGame.rounds {
		if round.Red > minimumSet.Red {
			minimumSet.Red = round.Red
		}
		if round.Green > minimumSet.Green {
			minimumSet.Green = round.Green
		}
		if round.Blue > minimumSet.Blue {
			minimumSet.Blue = round.Blue
		}
	}

	return minimumSet
}

// Take a string like "Game 12" and extract the 12 off the end.
func parseGameId(strGameIdLine string) int {
	strGameId, found := strings.CutPrefix(strings.TrimSpace(strGameIdLine), "Game ")
	if !found {
		panic("Invalid game id!")
	}
	intGameId, _ := strconv.Atoi(strGameId)
	return intGameId
}

// Take a set string like "1 green, 2 blue" or "3 red, 4 green, 1 red"
func parseSet(strSetSpec string) *CubeSet {
	strColourSpecs := strings.Split(strSetSpec, ",")
	cubeSpec := &CubeSet{}

	for _, strColourSpec := range strColourSpecs {
		var strCount string
		var colour string
		_, err := fmt.Sscan(strColourSpec, &strCount, &colour)
		check(err)
		count, _ := strconv.Atoi(strCount)
		cubeSpec = cubeSpec.setColourCount(colour, count)
	}

	return cubeSpec
}

func main() {

	file, err := os.Open("input.txt")
	check(err)

	idSum := 0
	powerSum := 0

	scanner := bufio.NewScanner(file)
	for scanner.Scan() {
		gameId, gameSets, _ := strings.Cut(scanner.Text(), ":")
		strSetSpecList := strings.Split(gameSets, ";")
		var cubesetList []*CubeSet
		for _, strSetSpec := range strSetSpecList {
			cubesetList = append(cubesetList, parseSet(strSetSpec))
		}

		currentGame := Game{id: parseGameId(gameId), rounds: cubesetList}
		supply := CubeSet{Red: 12, Green: 13, Blue: 14}
		if currentGame.playableWith(supply) {
			idSum = idSum + currentGame.id
		}

		powerSum += currentGame.minimumSet().cubesetPower()
	}
	file.Close()

	fmt.Println("")
	fmt.Printf("Part1: %d\n", idSum)
	fmt.Printf("Part2: %d\n", powerSum)
}
