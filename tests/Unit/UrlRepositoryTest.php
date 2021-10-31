<?php

namespace Tests\Unit;

use App\Models\Url;
use Tests\TestCase;
use App\Repositories\UrlRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UrlRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     * @group repository_saves_url
     */
    public function repository_saves_url()
    {
        $url = 'www.test.test';


        $shortendUrl = $this->repository()->save($url);


        $this->assertDatabaseHas('urls', [
            'shortcode_uuid' => $shortendUrl,
            'redirect_url' => $url
        ]);

    }

    /**
     * @test
     * @group it_gets_url
     */
    public function it_gets_url()
    {

        $expectedUrl = Url::factory()->create();
        $shortendUrl = $this->repository()->getByUuid($expectedUrl->shortcode_uuid);

        self::assertSame($expectedUrl->toArray(), $shortendUrl);

    }

    /**
     * @test
     * @group it_updates_url
     */
    public function it_updates_url()
    {
        /**
         * @given there a url entity is created
         */
        $urlBeforeUpdate = Url::factory()->create();
        $hitCountToUpdate = 1234121231313123;

        $this->assertDatabaseHas('urls', [
            'shortcode_uuid' => $urlBeforeUpdate->shortcode_uuid,
            'redirect_url' => $urlBeforeUpdate->redirect_url,
            'active' => $urlBeforeUpdate->active,
        ]);

        /**
         * @given shortcode_uuid, redirect_url and active are updated for url
         */
        $urlNewParameters = Url::factory()->make();
        $dataToUpdate = [
            'shortcode_uuid' => $urlNewParameters->shortcode_uuid,
            'redirect_url' => $urlNewParameters->redirect_url,
            'active' => $urlNewParameters->active,
            'hit_count' => $hitCountToUpdate,
        ];

        $result = $this->repository()->updateByUuid(
            $urlBeforeUpdate->shortcode_uuid,
            $dataToUpdate
        );

        self::assertIsInt($result);
        self::assertEquals(1, $result);

        /**
         * @expected  the $url data is updated in db
         */
        $urlAfterUpdate = $this->repository()->getByUuid($urlNewParameters->shortcode_uuid);
        self::assertNotSame($urlBeforeUpdate->toArray(), $urlAfterUpdate);

        /**
         * @expected "hit_count" column remaines unchanged in db
         */
        self::assertSame($urlBeforeUpdate->hit_count, $urlAfterUpdate['hit_count']);
    }

    /**
     * @test
     * @group it_updates_hits
     */
    public function it_updates_hits()
    {
        /**
         * @given there a url entity is created
         */
        $urlBeforeHitUpdate = Url::factory()->create();
        $this->assertDatabaseHas('urls', [
            'shortcode_uuid' => $urlBeforeHitUpdate->shortcode_uuid,
            'redirect_url' => $urlBeforeHitUpdate->getRediractionPath(),
            'active' => $urlBeforeHitUpdate->active,
            'hit_count' => $urlBeforeHitUpdate->hit_count
        ]);

        $increasedHit = $this->repository()->updateHitByUuid(
            $urlBeforeHitUpdate->shortcode_uuid,
        );

        /**
         * @expected "hit_count" is increased by 1
         */
        self::assertIsInt($increasedHit);
        self::assertLessThan( $increasedHit, $urlBeforeHitUpdate->hit_count);
        self::assertEquals(($urlBeforeHitUpdate->hit_count + 1), $increasedHit);
    }



    public function repository()
    {
        return new UrlRepository();
    }
}
