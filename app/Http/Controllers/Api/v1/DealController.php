<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DealController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = Deal::query();

        if ($request->has('q')) {
            $queryString = $request->input('q');
            $filters = explode(',', $queryString);

            foreach ($filters as $filter) {
                $filter = trim($filter);

                if (str_contains($filter, 'title=')) {
                    $title = trim(str_replace('title=', '', $filter));
                    $query->where('title', $title);
                } elseif (str_contains($filter, 'title:')) {
                    $title = trim(str_replace('title:', '', $filter));
                    $query->whereRaw("LOWER(title) LIKE ?", ['%' . strtolower($title) . '%']);
                } elseif (str_contains($filter, 'salePrice>')) {
                    $price = trim(str_replace('salePrice>', '', $filter));
                    $query->where('salePrice', '>', $price);
                } elseif (str_contains($filter, 'salePrice<')) {
                    $price = trim(str_replace('salePrice<', '', $filter));
                    $query->where('salePrice', '<', $price);
                } else {
                    $query->where('title', 'LIKE', '%' . $filter . '%');
                }
            }
        }

        $deals = $query->get();

        return response()->json($deals);
    }
}
