<?php

mb_language("Japanese");
date_default_timezone_set('Asia/Tokyo');

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

// extension
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
    'twig.options' => array('cache' => __DIR__ . '/../cache'),
));
ORM::configure('sqlite:../db/site.db');
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/post.php';

$app->get('/', function() use ($app) {
	$users = Model::factory('User')->find_many();
	
	return $app['twig']->render('index.twig', array(
				'users' => $users,
	));
});

$app->get('/user/{id}', function($id) use ($app) {

	$posts = ORM::for_table('posts')->where(array('user_id' => $id))->find_many();

	return $app['twig']->render('posts.twig', array(
				'posts' => $posts,
	));
});

// run app
$app->run();
