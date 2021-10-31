<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UrlTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     * @group it_gets_its_url
     */
    public function it_gets_its_url()
    {
        $sampleUrl = 'https://sampleurl.test';

        $url = Url::factory()->create([
            'redirect_url' =>  $sampleUrl
        ]);

        $this->assertEquals($sampleUrl, $url->getRediractionPath());
    }
}
