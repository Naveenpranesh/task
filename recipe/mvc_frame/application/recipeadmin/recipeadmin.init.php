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
 * @filename:	admin.init.php
 * @filetype:	PHP
 * @filedesc:	This file is used for intializing the needed modules for admin module.
 *
 */

global $library;
$fileLoaderObj = new fileLoader("recipeadmin");
$fileLoaderObj->addFile("application/recipeadmin/model/recipeadmin.class.inc",true);
$fileLoaderObj->addFile("application/recipeadmin/controller/recipeadmin.service.class.inc");
$library->addLibrary($fileLoaderObj);

if($library->addLibrary($fileLoaderObj) !== true){
	console(LOG_LEVEL_ERROR,"Unable to create library Service");
	return false;
}
$library->loadLibrary("recipeadmin");
$library->loadLibrary("dbqryconstructor");
$library->loadLibrary("dbvalidator");
new RecipeAdminController();

?>