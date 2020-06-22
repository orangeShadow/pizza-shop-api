<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AbstractPizzaException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Rules\CurrencyValidation;
use App\Services\GetDelivery;
use App\Services\GetDeliveryList;
use App\Services\PriceConverting;
use Illuminate\Http\Request;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DeliveryController extends Controller
{
    /**
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getDeliveryList(Request $request): AnonymousResourceCollection
    {
        $getDeliveryList = new GetDeliveryList();
        $deliveryList = $getDeliveryList->handler();

        return DeliveryResource::collection($deliveryList);
    }

    /**
     * @param Request $request
     * @param GetDelivery $deliveryService
     * @param PriceConverting $priceConverting
     */
    public function calcDelivery(Request $request,
                                              GetDelivery $deliveryService,
                                              PriceConverting $priceConverting)
    {
        $this->validate($request, [
            'currency'    => ['required', new CurrencyValidation],
            'basketPrice' => ['required', 'numeric'],
            'deliveryId'  => ['required']
        ]);

        try {
            $delivery = $deliveryService->handler((int)$request->get('deliveryId'));

            return response([
                'price' => $delivery->priceCalculate(
                    (int)$request->get('basketPrice'),
                    $request->get('currency')
                ),
            ]);
        } catch (AbstractPizzaException $exception) {
            return response(['message' => 'Bad request'], 400)->json();
        } catch (\Throwable $e) {
            return response(['message' => 'Server error'], 500)->json();
        }
    }
}
