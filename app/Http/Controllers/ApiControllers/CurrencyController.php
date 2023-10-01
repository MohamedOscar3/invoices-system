<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Http\Resources\CurrencyCollection;
use App\Http\Resources\CurrencyResource;
use App\Http\Responses\ApiResponse;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $currencies = Currency::where("status",1)->paginate(10);
        return ApiResponse::successResponse('Currencies retrieved successfully', 200, new CurrencyCollection($currencies));
    }

    /**
     * @param CurrencyRequest $request
     * @return JsonResponse
     */
    public function store(CurrencyRequest $request) : JsonResponse
    {
        $validatedData = $request->validated();
        $currency = Currency::create($validatedData);

        return ApiResponse::successResponse('Currency created successfully', 201, new CurrencyResource($currency));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $currency = Currency::find($id);

        if (!$currency) {
            return ApiResponse::errorResponse('Currency not found', 404);
        }

        return ApiResponse::successResponse('Currency retrieved successfully', 200, new CurrencyResource($currency));
    }

    /**
     * @param CurrencyRequest $request
     * @param int $currency
     * @return JsonResponse
     */
    public function update(CurrencyRequest $request, int $currency) : JsonResponse
    {
        $currency = Currency::find($currency);

        if (!$currency) {
            return ApiResponse::errorResponse('Currency not found', 404);
        }

        $validatedData = $request->validated();
        $currency->update($validatedData);

        return ApiResponse::successResponse('Currency updated successfully', 200, new CurrencyResource($currency));
    }
}
