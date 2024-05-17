<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Article\Article;
use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    public function slides(Request $request)
    {
        $articles = Article::query()
            ->where('show_app', 1)
            ->where('vip', 0)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0);
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $list = ArticleResource::collection($articles->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('slides lists'));
    }

    public function currencies(Request $request)
    {
        $currencies = Currency::query();
        $currencies = $currencies->where('active', true);
        if ($request->has('search') && $request->get('search') != '') {
            $request->merge([
                'page' => null
            ]);
            $currencies = $this->filter($currencies, $request->get('search'));
        }
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $list = CurrencyResource::collection($currencies->with('networks')->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('currencies lists'));
    }

    public function currency($id)
    {
        $currency = Currency::with('networks')->where('id', $id)->first();
        return $this->response(1, [new CurrencyResource($currency)], [], Lang::get('currency information'));

    }

    public function oscillation(Request $request)
    {
        $type = $request->has('type') ? $request->type : 'positive';

        $currencies = Currency::query();
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        if ($type == 'negative') {
            $currencies = $currencies->where('percent', '<', -5);
            $currencies = $currencies->orderByRaw('CONVERT(percent, SIGNED)');
        } else {
            $currencies = $currencies->orWhere('percent', '>', 5);
            $currencies = $currencies->orderByRaw('CONVERT(percent, SIGNED) desc');
        }
        $list = CurrencyResource::collection($currencies->with('networks')->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('the most oscillation'));
    }

    private function filter($currencies, $serach)
    {
        return $currencies
            ->where('symbol', 'LIKE', '%' . $serach . '%')
            ->orWhere('name', 'LIKE', '%' . $serach . '%');
    }
}
