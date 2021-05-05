<?php
header('Content-Type: application/xml; charset=utf-8');
//header('Content-Type: application/rss+xml; charset=utf-8'); //

// https://stackoverflow.com/a/35020250/1109380
echo file_get_contents('https://bronoverrattvik.github.io/bronoverrattvik.xml?t='.time());