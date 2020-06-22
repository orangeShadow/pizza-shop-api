<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Rules\CurrencyValidation;
use Illuminate\Http\Request;
use App\Services\PriceConverting;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'currency' => ['nullable', new CurrencyValidation]
        ]);

        return ProductResource::collection(Product::all());
    }
}
