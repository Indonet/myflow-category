<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api/categories', function ($routes) {
    //category
    $routes->post('category', 'Category::get_category');
    $routes->post('category/create', 'Category::create');
    $routes->put('category/(:num)', 'Category::update/$1');
    $routes->post('category/disable', 'Category::disable');
    $routes->get('category/(:num)', 'Category::detail/$1');
    //sub_category
    $routes->post('sub_category', 'Sub_category::index');
    $routes->post('sub_category/create', 'Sub_category::create');
    $routes->put('sub_category/(:num)', 'Sub_category::update/$1');
    $routes->post('sub_category/disable', 'Sub_category::disable');
    $routes->get('sub_category/(:num)', 'Sub_category::detail/$1');

    //criteria
    $routes->get('criteria', 'Criteria::get_criteria');
    $routes->post('criteria/create', 'Criteria::create');
    $routes->put('criteria/(:num)', 'Criteria::update/$1');
    $routes->post('criteria/disable', 'Criteria::disable');

    //criteria mapping
    $routes->post('criteria_mapping', 'Criteria_mapping::get_criteria_mapping');
    $routes->post('criteria_mapping/create', 'Criteria_mapping::create');
    $routes->put('criteria_mapping/(:num)', 'Criteria_mapping::update/$1');
    $routes->post('criteria_mapping/disable', 'Criteria_mapping::disable');
});


