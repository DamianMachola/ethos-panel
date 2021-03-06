<?php

/*
 * The MIT License
 *
 * Copyright 2018 foraern.
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
 */

session_start();
include('lib/functions.php');
$f = new functions();
if(!isset($_SESSION['uid'])){
	header('location: /');
}
$f->getuser($_SESSION['uid']);
if(!empty($_POST['password']) && !empty($_POST['confirmpassword']) && $_POST['password'] == $_POST['confirmpassword'])
{
	$f->changepassword($_POST['password']);
}
if(!empty($_POST['url']))
{
	if (filter_var($_POST['url'], FILTER_VALIDATE_URL) !== FALSE) {
		$f->saveprofile($_POST['url']);
		$f->getuser($_SESSION['uid']);
	}
}
$contentdata["email"] = $f->user->email;
$contentdata["url"] = $f->user->url;
$contentdata["news"]=$f->getnews();
echo $f->getcontent('./templates/profile.html', $contentdata);
