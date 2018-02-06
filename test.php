<?php
include __DIR__."/vendor/autoload.php";
use Lps\Libvirt;

$libvirt = new Libvirt();
$res = $libvirt->listDomains();

var_dump($res);
