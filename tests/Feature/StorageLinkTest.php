<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorageLinkTest extends TestCase
{
    public function test_public_storage_directory_exists(): void
    {
        $this->assertTrue(is_dir(public_path('storage')) || is_link(public_path('storage')));
    }
}
