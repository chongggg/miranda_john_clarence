<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

// Authentication routes
$router->match('auth/login', 'Auth::login', ['GET','POST']);
$router->match('auth/register', 'Auth::register', ['GET','POST']);
$router->get('auth/logout', 'Auth::logout');
$router->match('auth/profile', 'Auth::profile', ['GET','POST']);
$router->post('auth/upload_image', 'Auth::upload_image');
$router->post('auth/change_password', 'Auth::change_password');

// Main routes
$router->get('/', 'Welcome::index');
$router->get('students', 'Students::index');
$router->match('students/create', 'Students::create', ['GET','POST']);
$router->match('students/edit/{id}', 'Students::edit', ['GET','POST']);
$router->get('students/delete/{id}', 'Students::delete');
$router->get('students/deleted', 'Students::deleted');
$router->get('students/restore/{id}', 'Students::restore');
$router->get('students/permanent_delete/{id}', 'Students::permanent_delete');
$router->get('students/index/{page}', 'Students::index');