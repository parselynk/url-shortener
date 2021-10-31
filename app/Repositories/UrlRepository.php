<?php

namespace App\Repositories;

use App\Models\Url;
use App\Repositories\Contracts\UrlRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class UrlRepository implements UrlRepositoryInterface
{

    public function save(string $url): string
    {
        $generateCode = $this->generateShoretendUrl();

            $url = Url::firstOrCreate(
                ['redirect_url' => $url], // if url not exists tehn create it
                ['shortcode_uuid' => $generateCode,]
            );


        return $url->shortcode_uuid !== $generateCode ? $url->shortcode_uuid : $generateCode;
    }

    public function getByUuid(string $uuid): array
    {
       try {
            return Url::where('shortcode_uuid', $uuid)
            ->firstOrFail()
            ->toArray();
       } catch(ModelNotFoundException $e){
            return [];
       }
    }

    public function updateByUuid(string $uuid, array $dataToUpdate): int
    {
        if(empty($dataToUpdate) === 0) {
            return 0;
        }

        unset($dataToUpdate['hit_count']);
        return Url::where('shortcode_uuid', $uuid)->update($dataToUpdate);
    }

    /**
     * @note this method never been used as the functionality
     * was directly provided on Model.
     *
     */
    public function updateHitByUuid(string $uuid): int
    {
        $url = Url::where('shortcode_uuid', $uuid)->first();
        $url->increment('hit_count', 1);
        return $url->hit_count;
    }

    public function generateShoretendUrl(): string
    {
        return Str::upper(substr(md5(microtime()),rand(0,26),5));
    }

}
