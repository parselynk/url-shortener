<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group url_redirect_endpoint_test
 */
class UrlًRedirectTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * @test
     *
     * @group endpoint_redirects_to_path_based_on_short_code
     * @return void
     */
    public function endpoint_redirects_to_path_based_on_short_code()
    {
        $url = Url::factory()->create([
            'hit_count' => 0
        ]);

        /**
         * @given url has never been visited.
         */
        $this->assertDatabaseHas($url, [
            'shortcode_uuid' => $url->shortcode_uuid,
            'hit_count' => 0
        ]);

        /**
         * @given url has been visited.
         */
        $response = $this->get('/'. $url->shortcode_uuid);

        $response->assertRedirect($url->redirect_url);

        /**
         * @expected hit_count now increased.
         */
        $this->assertDatabaseHas($url, [
            'shortcode_uuid' => $url->shortcode_uuid,
            'hit_count' => '1'
        ]);
    }

    /**
     * @test
     *
     * @group endpoint_redirects_to_404_on_invalid_shortcode
     * @return void
     */
    public function endpoint_redirects_to_404_on_invalid_shortcode()
    {
        $response = $this->get('/'. 'anywrongshortcode');

        $response->assertNotFound();
    }
}
