<?php
header('Content-Type: application/xslt+xml; charset=utf-8');

// https://stackoverflow.com/a/35020250/1109380
echo file_get_contents('https://bronoverrattvik.github.io/rss.xslt?t='.time());