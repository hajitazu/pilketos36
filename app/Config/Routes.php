<?php

namespace Config;

$routes = Services::routes(true);

// Default controller if needed
$routes->get('/', 'Voting::index');

// Voting routes
$routes->get('voting', 'Voting::index');
$routes->post('voting/login', 'Voting::verifyToken');
$routes->get('voting/ballot', 'Voting::ballot');
$routes->post('voting/vote', 'Voting::vote');
$routes->get('voting/thanks', 'Voting::thanks');

// Admin routes
$routes->get('admin', 'Admin::login');
$routes->post('admin/login', 'Admin::loginPost');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/dashboard', 'Admin::dashboard', ['filter' => 'authadmin']);
$routes->get('admin/settings', 'Admin::settings', ['filter' => 'authadmin']);
$routes->post('admin/settings/save', 'Admin::saveSettings', ['filter' => 'authadmin']);
$routes->get('admin/candidates', 'Admin::candidates', ['filter' => 'authadmin']);
$routes->get('admin/candidates/new', 'Admin::candidateForm', ['filter' => 'authadmin']);
$routes->get('admin/candidates/edit/(:num)', 'Admin::candidateForm/$1', ['filter' => 'authadmin']);
$routes->post('admin/candidates/save', 'Admin::saveCandidate', ['filter' => 'authadmin']);
$routes->get('admin/candidates/delete/(:num)', 'Admin::deleteCandidate/$1', ['filter' => 'authadmin']);
$routes->get('admin/results', 'Admin::results', ['filter' => 'authadmin']);
$routes->post('admin/end', 'Admin::endElection', ['filter' => 'authadmin']);
