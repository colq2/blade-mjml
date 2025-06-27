<?php

it('can extend layout', function () {
    View::addLocation(base_path('tests/views'));
    $view = view('test1');
    $viewString = (string) $view;

    expect($viewString)->not->toContain('<mj');
});
