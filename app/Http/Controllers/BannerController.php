<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use Hossam\Licht\Controllers\LichtBaseController;

class BannerController extends LichtBaseController
{
    public function index()
    {
        $banners = Banner::all();
        return view('banners', compact('banners'));
    }

    public function store(StoreBannerRequest $request)
    {
        $validData = $request->validated();
        $validData['image'] = $this->uploadFile($validData['image'], Banner::PathToStoredImages);
        $banner = Banner::create($validData);
        return to_route('banners.index');
    }



    public function destroy(Banner $banner)
    {
        $this->deleteFile($banner->image);
        $banner->delete();
        return to_route('banners.index');
    }
}
