<?php

it('ensures there is no smoke', function () {

    $pages = visit(['/login', '/users', '/welcome']);

    $pages->assertNoSmoke()
        // ->assertNoAccessibilityIssues()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors();
});
