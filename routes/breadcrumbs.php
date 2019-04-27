<?php

/*
|--------------------------------------------------------------------------
| Dynamic Breadcrumbs
|--------------------------------------------------------------------------
|
| Now create something great!
|
*/
Breadcrumbs::for('welcome', function ($breadcrumbs) {
    $breadcrumbs->push('Welcome', route('welcome'));
});
Breadcrumbs::for('login', function ($breadcrumbs) {
    $breadcrumbs->parent('welcome');
    $breadcrumbs->push('Login', route('login'));
});
Breadcrumbs::for('register', function ($breadcrumbs) {
    $breadcrumbs->parent('welcome');
    $breadcrumbs->push('Register', route('register'));
});
Breadcrumbs::for('share-index', function ($breadcrumbs) {
    $breadcrumbs->parent('welcome');
    $breadcrumbs->push('Shares Details', route('shares.index'));
});

