<?php

spl_autoload_register(function ($className) {
    $file = $className . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
});

$begin = microtime(true);

$rows = file("input.txt");
array_walk($rows, function(&$v){ $v = trim($v); });

$chunkCodes = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
];

$errorPoints = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137
];

$autocompletePoints = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4
];

$openers = array_keys($chunkCodes);
$closers = array_values($chunkCodes);

$score = 0;
foreach ($rows as $row) {
    $stack = new SplStack();
    
    for ($i = 0; $i < strlen($row); $i++) {
        $code = $row[$i];
        if (in_array($code, $openers)) {
            $stack->push($code);
        } else {
            if ($stack->isEmpty()) {
                // Invalid, expecting an opener.
                $score += $errorPoints[$code];
                break;
            }
            
            if ($code == $chunkCodes[$stack->top()]) {
                // valid closing code, pop the stack.
                $stack->pop();
            } else {
                // Invalid, line is corrupted.
                $score += $errorPoints[$code];
                break;
            }
        }
    }
}

$autocompleteScores = [];
foreach ($rows as $row) {
    $stack = new SplStack();
    $corrupted = false;
    
    for ($i = 0; $i < strlen($row); $i++) {
        $code = $row[$i];
        if (in_array($code, $openers)) {
            $stack->push($code);
        } else {
            if ($stack->isEmpty()) {
                // Corrupted line, ignore.
                $corrupted = true;
                break;
            }
            
            if ($code == $chunkCodes[$stack->top()]) {
                // valid closing code, pop the stack.
                $stack->pop();
            } else {
                // Corrupted line, ignore.
                $corrupted = true;
                break;
            }
        }
    }
    
    if ($corrupted) { continue; }
    
    // End of line, pop the remaining stack and find all the closing chars.
    $closing = '';
    while(!$stack->isEmpty()) {
        $closing .= $chunkCodes[$stack->pop()];
    }
    
    // Score the closing line.
    $as = 0;
    foreach (str_split($closing) as $char) {
        $as = ($as * 5) + $autocompletePoints[$char];
    }
    $autocompleteScores[] = $as;
}

sort($autocompleteScores);
print_r($autocompleteScores);

$midIndex = floor(count($autocompleteScores) / 2);


printf("Answer 1: %d\n", $score);
printf("Answer 2: %d\n", $autocompleteScores[$midIndex]);

printf("Runtime = %f seconds\n", 
        (microtime(true) - $begin)
        );


