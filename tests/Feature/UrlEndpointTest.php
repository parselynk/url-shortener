<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Url;

/**
 * @group Url
 * @group UrlEndpointTest
 */
class UrlEndpointTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    public const  URL_ENDPOINT_PATH = '/api/v1/url';

    /**
     * @test
     *
     * @group endpoint_saves_url_and_reutrns_generated_short_code
     * @return void
     */
    public function endpoint_saves_url_and_reutrns_generated_short_code()
    {
        $urlToSave = $this->faker->url;
        $response = $this->post(self::URL_ENDPOINT_PATH, ['url' => $urlToSave]);
        $generatedUuid = json_decode($response->getContent(), true)['shortcode_uuid'];

        $response->assertStatus(201)->assertJsonStructure(['shortcode_uuid']);

        /**
         * @expected database stored the url
         */
        $this->assertDatabaseHas('urls', [
            'shortcode_uuid' => $generatedUuid,
            'redirect_url' => $urlToSave,
        ]);
    }

    /**
     * @test
     *
     * @group endpoint_does_not_save_one_url_twice
     * @return void
     */
    public function endpoint_does_not_save_one_url_twice()
    {
        $url = Url::factory()->create();
        $existingUrlPath = $url->redirect_url;
        $existingGeneratedUuid = $url->shortcode_uuid;

        /**
         * @given the URL entity already exists in DB
         */
        $this->assertDatabaseHas($url, ['redirect_url' => $existingUrlPath]);
        $this->assertDatabaseCount($url, 1);


        /**
         * @given endpoint is called with same url
         */
        $response = $this->post(self::URL_ENDPOINT_PATH, ['url' => $existingUrlPath]);
        $expectedUuid = json_decode($response->getContent(), true)['shortcode_uuid'];

        $response->assertStatus(201);
        /**
         * @expecte no new entity is saved in DB for given url
         */
        self::assertSame($expectedUuid, $existingGeneratedUuid);
        $this->assertDatabaseCount($url, 1);
    }

    /**
     * @test
     *
     * @group endpoint_gets_url_by_uuid
     * @return void
     */
    public function endpoint_gets_url_by_uuid()
    {
        $url = Url::factory()->create();
        $expectedUrlPath = $url->redirect_url;
        $expectedUuid = $url->shortcode_uuid;


        /**
         * @given endpoint is called with same url
         */
        $response = $this->get(self::URL_ENDPOINT_PATH . "/{$expectedUuid}");
        $content = json_decode($response->getContent(), true);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'shortcode_uuid',
            'redirect_url',
            'hit_count',
            'active',
            'created_at',
            'updated_at'
        ]);
        /**
         * @expecte no new entity is saved in DB for given url
         */
        self::assertSame($expectedUuid, $content['shortcode_uuid']);
        self::assertSame($expectedUrlPath, $content['redirect_url']);
    }
}
