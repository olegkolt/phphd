<?php

require 'vendor/autoload.php';

use PHPHD\View\Html;
use PHPHD\DataSource\Serialize;

$dataSrc = new Serialize('tests/acceptance/data/data.dump');

$html = new Html($dataSrc);
$html->output();
