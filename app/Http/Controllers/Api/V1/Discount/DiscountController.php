<?php

namespace App\Http\Controllers\Api\V1\Discount;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Article\Article;
use App\Models\Balance\Balance;
use App\Models\Currency\Currency;
use App\Models\vip\VipPackage;
use App\Models\vip\VipUsers;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()->where('discount', 1)->orderByDesc('created_at');
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $list = ArticleResource::collection($articles->paginate($per_page))->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('discount content'));
    }
}
