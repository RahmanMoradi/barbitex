<?php

namespace App\Http\Controllers;

use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\Traits\General\Responseable;
use App\Http\Controllers\Traits\General\Uploadable;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Uploadable, Responseable;

    const PER_PAGE = 15;

    public function setSeo($title, $key, $description, $image)
    {
        $title = $title ? $title . ' | ' . Setting::get('title') : Setting::get('title');

        SEOMeta::addKeyword($key);
        SEOMeta::setTitleSeparator('|');
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setKeywords($key);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addImage($image ?: asset(Setting::get('logo'))); // add an array of url images
        OpenGraph::setTitle($title); // define title
        OpenGraph::setDescription($description);  // define description
        OpenGraph::setUrl(url()->current()); // define url
        OpenGraph::setSiteName(Setting::get('title')); //define site_name

        TwitterCard::setType('webpage'); // type of twitter card tag
        TwitterCard::setTitle($title); // title of twitter card tag
        TwitterCard::setSite('website'); // site of twitter card tag
        TwitterCard::setDescription($description); // description of twitter card tag
        TwitterCard::setUrl(url()->current()); // url of twitter card tag
        TwitterCard::setImage($image ?: asset(Setting::get('logo'))); // add image url

        JsonLd::setType('webpage'); // type of twitter card tag
        JsonLd::setTitle($title); // title of twitter card tag
        JsonLd::setSite('website'); // site of twitter card tag
        JsonLd::setDescription($description); // description of twitter card tag
        JsonLd::setUrl(url()->current()); // url of twitter card tag
        JsonLd::setImage($image ?: asset(Setting::get('logo'))); // add image url
    }
}
