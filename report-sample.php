<?php

require 'vendor/autoload.php';

use PHPHD\View\Html;
use PHPHD\DataSource\Serialize;

// open data source
$dataSrc = new Serialize('tests/acceptance/data/data.dump');

// read data source and generate report
$html = new Html($dataSrc);
$html->output();
