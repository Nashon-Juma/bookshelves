<?php

define('__API_BOOKS__', '/api/books');

it('first page available', function () {
    $response = $this->get(__API_BOOKS__);

    $response->assertStatus(200);
});

it('have content', function () {
    $response = $this->get(__API_BOOKS__);

    $this->assertEquals(200, $response->getStatusCode());
    $json = json_decode($response->content());
    $this->assertNotEmpty($json->data, true);

    $response->assertStatus(200);
});

it('all pages available', function () {
    $response = $this->get(__API_BOOKS__.'?limit=full');
    $response->assertStatus(200);
});

it('random book detail', function () {
    $response = $this->get(__API_BOOKS__);
    $json = json_decode($response->content());
    $randomElement = array_rand($json->data, 1);
    $showLink = $json->data[$randomElement]->meta->show;

    $response = $this->get($showLink);
    $response->assertStatus(200);
});

it('count', function () {
    $response = $this->get('/api/count?entity=book');
    $response->assertStatus(200);
});
