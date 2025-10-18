<?php

it('ensures there is no smoke', function () {

    $pages = visit(['/login', '/users']);

    $pages->assertNoSmoke()
        ->assertNoAccessibilityIssues()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors();
});
