<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <!--
      *********************************************************************************
      * 
      * File: display.php   | For retrieving and displaying data from the DB.
      * 
      * 
      * Created by Jason Lengstorf for Ennui Design. Copyright (C) 2008 Ennui Design.
      * 
      *        www.EnnuiDesign.com | answers@ennuidesign.com | (406) 270-4435
      *  https://css-tricks.com/php-for-beginners-building-your-first-simple-cms/
      * http://www.wikihow.com/Create-a-Database-in-MySQL
      * -----------------------------------------------------------------------------
      * 
      * This file was created to accompany an article written for CSS-Tricks.com
      * 
      * -----------------------------------------------------------------------------
      *
      * this file was modified by Alex Griffen to run HelloSign API tests
      * there were no animlas harmed in the modification of these pages
      *
      *********************************************************************************
    -->
    <!--
      *********************************************************************************
      *This file is part of php-example.
      *
      *php-example is free software: you can redistribute it and/or modify
      *it under the terms of the GNU General Public License as published by
      *the Free Software Foundation, either version 3 of the License, or
      *(at your option) any later version.
      *
      *php-example is distributed in the hope that it will be useful,
      *but WITHOUT ANY WARRANTY; without even the implied warranty of
      *MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      *GNU General Public License for more details.
      *
      *See <http://www.gnu.org/licenses/> for a copy of the license.
      *********************************************************************************
    -->

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>PHP example with DB(eventually)+HelloSign API</title>
        <!-- style.css was included with the simpleCMS program -->
        <!-- <link rel="stylesheet" type="text/css" href="style.css" />-->
        <link rel="stylesheet" type="text/css" href="newcss.css" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">
    </head>

    <body>
        <div id="html">
            <?php
            include_once('_class/simpleCMS.php');
            $obj = new simpleCMS();

            /* CHANGE THESE SETTINGS FOR YOUR OWN DATABASE */
            /* Alex here - updated settings on 11/11/16 */
            $obj->host = '127.0.0.1';
            $obj->username = 'root';
            $obj->password = 'Wh4tMAtters';
            $obj->table = 'sigantureRequestDB';
            $obj->connect();

            if ($_POST)
                $obj->write($_POST);

            echo ( $_GET['admin'] == 1 ) ? $obj->display_admin() : $obj->display_public();
            ?>
        </div>
    </body>

</html>