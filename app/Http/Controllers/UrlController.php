<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UrlRepositoryInterface;
use Illuminate\Http\Request;

class UrlController extends Controller
{

    private UrlRepositoryInterface $urlRepository;

    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       $url = request()->get('url');
       $shortCodeUuid = $this->urlRepository->save($url);

       return response(['shortcode_uuid'=> $shortCodeUuid], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $uuid)
    {
        $urlAsArray = $this->urlRepository->getByUuid($uuid);

        return response($urlAsArray, 200);
    }

    /**
     * Update the specified resource in storage.
     * for simplicity of this projct only active
     * and redirect_url will be updated.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(string $uuid)
    {
        $active = request()->get('active');
        $url = request()->get('redirect_url');

        if (isset($active)) {
            $dataToUpdate['active'] = $active;
        }

        if (isset($url)) {
            $dataToUpdate['redirect_url'] = $url;
        }

        $result = $this->urlRepository->updateByUuid($uuid, $dataToUpdate);

        return response([], 200);
    }
}
