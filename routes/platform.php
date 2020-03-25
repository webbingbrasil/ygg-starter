<?php

use App\Ygg\Screens\Examples\ExampleFieldsScreen;
use App\Ygg\Screens\Examples\ExampleLayoutsScreen;
use App\Ygg\Screens\Examples\ExampleScreen;
use App\Ygg\Screens\PlatformScreen;
use App\Ygg\Screens\Role\RoleEditScreen;
use App\Ygg\Screens\Role\RoleListScreen;
use App\Ygg\Screens\User\UserEditScreen;
use App\Ygg\Screens\User\UserListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
$this->router->screen('/main', PlatformScreen::class)->name('platform.main');

// Users...
$this->router->screen('users/{users}/edit', UserEditScreen::class)->name('platform.systems.users.edit');
$this->router->screen('users/create', UserEditScreen::class)->name('platform.systems.users.create');
$this->router->screen('users', UserListScreen::class)->name('platform.systems.users');

// Roles...
$this->router->screen('roles/{roles}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit');
$this->router->screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create');
$this->router->screen('roles', RoleListScreen::class)->name('platform.systems.roles');

// Example...
$this->router->screen('example', ExampleScreen::class)->name('platform.example');
$this->router->screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
$this->router->screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
//Route::screen('/dashboard/screen/idea', 'Idea::class','platform.screens.idea');
