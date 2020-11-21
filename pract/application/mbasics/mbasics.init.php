<?php
/*
 * @company: 	Symbiotic Infotech Pvt. Ltd.
 * @copyright: 	� Symbiotic Infotech Pvt. Ltd. 2011
 *				All rights reserved.Any redistribution or reproduction of part
 * 				or all of the contents in any form is prohibited. You may not,
 * 				except with express written permission, distribute or
 * 				commercially exploit or personally use the content.
 * 				Nor may you transmit it or store it in any other media or
 * 				other form of electronic or physical retrieval system.
 *
 * @filename:	mbasics.init.php
 * @filetype:	PHP
 * @filedesc:	This file is used for intializing the needed modules for mbasics module.
 *
 */

global $library;
$fileLoaderObj = new fileLoader("mbasics");
$fileLoaderObj->addFile("application/mbasics/model/mbasics.class.inc",true);
$fileLoaderObj->addFile("application/mbasics/controller/mbasics.service.class.inc");
$library->addLibrary($fileLoaderObj);

if($library->addLibrary($fileLoaderObj) !== true){
	console(LOG_LEVEL_ERROR,"Unable to create library Service");
	return false;
}
$library->loadLibrary("mbasics");
$library->loadLibrary("dbqryconstructor");
$library->loadLibrary("dbvalidator");
new MbasicsController();

?>