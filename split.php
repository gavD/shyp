<?php

/**
 * Script which reads shyp-trimmed.txt and outputs a set of JavaScript commands which you can paste into
 * the browser developer console on Tweetdeck to schedule tweets (once you've loaded tweet.js) to schedule
 * quotes from shyp-trimmed.txt to be tweeted
 *
 * Niladic - takes no arguments
 *
 * Randomises the order of quotes
 * Takes either the first 4 lines of a stanza, or the first 2 if 4 lines would be >140 chars
 * Doesn't do much to normalise punctuation
 */

// Get the raw contents of the manuscript
$raw = file_get_contents('shyp-trimmed.txt');

// Split it into an array of stanzas
$parts = explode("\n\n", $raw);

// Filter the array - only keep any that have at least 2 lines
$stanzas = array_filter($parts, function($stanza) {
    $lines = explode("\n", trim($stanza));
    return count($lines) >= 2;
});

// Cut each stanza down to tweet length
// If >140 take the first 2 lines
// if <140 take the whole thing
$tweetCandidates = array_map( function( $stanza ) {
    $lines = explode("\n", $stanza);
    $lineCount = 4;
    if (strlen ($stanza) > 140) {
        $lineCount = 2;
    }
    return implode("\n", array_filter($lines, function($k) use ($lineCount) {
	return $k < $lineCount;
    }, ARRAY_FILTER_USE_KEY));
}, $stanzas );

shuffle( $tweetCandidates );
// print_r($tweetCandidates);

// Schedule the tweets, starting at 12:00 uk time on Friday 20th October 2017
// and tweeting on the hour, every hour.
$startdate = DateTime::createFromFormat('Y-m-d H:i:s', '2017-10-20 12:00:00');
$nextdate = $startdate;
$schedule = [];

foreach($tweetCandidates as $tweet) {
    $schedule[$nextdate->format('Y-m-d H:i:s')] = $tweet;
    $nextdate = $startdate->modify("+1 hour");
}

// Display the schedule as JavaScript calls
foreach ($schedule as $date => $tweet) {
  echo 'scheduleTweet("';
  echo str_replace("\n", '\n', str_replace('"', "'", trim($tweet)));
  echo '", ';
  echo DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('H');
  echo ', ';
  echo DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d');
  echo "); // ";
  echo DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('M');
  echo "\n";
}
