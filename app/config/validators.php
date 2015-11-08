<?php
/*
* app/validators.php
*/

Validator::extend('alpha_spaces', function($attribute, $value)
{
	return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('alpha_num_dash', function($attribute, $value)
{
	return preg_match('/^[á-úÁ-Úa-zA-ZñÑüÜ0-9-_\s]+$/', $value);
});

Validator::extend('direction', function($attribute, $value)
{
	return preg_match('/^[á-úÁ-Úa-zA-ZñÑüÜ0-9-,.°\s]+$/', $value);
});