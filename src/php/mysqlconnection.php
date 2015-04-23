<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 * Date: 4/22/2015
 * Time: 8:30 PM
 */

//script contains database access info

//set db access info as constants
DEFINE (‘DB_USER’, ‘jkasa’);
DEFINE (‘DB_PASSWORD’, ‘*gajl%82160*’);
DEFINE (‘DB_HOST’, ‘localhost’);
DEFINE (‘DB_NAME’, ‘bookmark’);

//connect
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die (‘Could not connect to MySQL: ’ . mysqli_connect_error() );

//set encoding
mysqli_set_charset($dbc, ‘utf8’);

