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

Breadcrumbs::for('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard',url('/admin'));
});
Breadcrumbs::for('user-index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Users', route('users.index'));
});
Breadcrumbs::for('user-view', function ($breadcrumbs,$user) {
    $breadcrumbs->parent('user-index');
    $breadcrumbs->push(ucfirst($user->name), route('users.show',$user->id));
});

