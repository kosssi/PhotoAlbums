<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1';

$blogPosts = array(
  1 => array(
    'date'      => '2011-03-29',
    'author'    => 'igorw',
    'title'     => 'Using Silex',
    'body'      => '...',
  ),
);

$app->get('/', function () use ($blogPosts) {
  $output = '';
  foreach ($blogPosts as $post) {
    $output .= $post['title'];
    $output .= '<br />';
  }

  return $output;
});

$app->get('/blog/show/{id}', function (Silex\Application $app, $id) use ($blogPosts) {
  if (!isset($blogPosts[$id])) {
    $app->abort(404, "Post $id does not exist.");
  }

  $post = $blogPosts[$id];

  return  "<h1>{$post['title']}</h1>".
    "<p>{$post['body']}</p>";
});

$app->run();