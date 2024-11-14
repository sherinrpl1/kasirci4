<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/tampil', 'Produk::tampil_produk');
$routes->post('/produk/simpan', 'Produk::simpan_produk');
$routes->delete('/produk/hapus/(:num)', 'Produk::delete/$1');
$routes->post('/produk/update', 'Produk::update_produk');
$routes->get('/produk/detail/(:num)', 'Produk::detail/$1');
