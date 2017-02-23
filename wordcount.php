<?php

include "autoload.php";

use Core\App;

$app = new App();
$app->processFile( $argv[1] );

echo "Distinct unique words: " . count( $app->getUniqWords() ) . "\n";

echo "Watchlist words:\n";

foreach( $app->getWatchListMatchedWords() as $word ) {
	echo $word . "\n";
}


/************************************************************************/
/************************************************************************
									SQL

CREATE TABLE `watchlist`(
	`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`word` varchar(255) NOT NULL
);

INSERT INTO `watchlist` (`word`) VALUES ( "horse" ), ( "zebra" ), ( "dog" ), ( "elephant" );

************************************************************************/
/************************************************************************/