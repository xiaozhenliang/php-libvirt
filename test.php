<?php
include __DIR__."/vendor/autoload.php";
use Lps\Libvirt;

$libvirt = new Libvirt();
$vnc = $libvirt->getNewDomainVnc();
var_dump( $vnc);

