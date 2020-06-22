<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AbstractPizzaException;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CreateOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $orders = Order::search($request)->get();

        return OrderResource::collection($orders);
    }

    /**
     * @param Request $request
     * @param CreateOrder $createOrder
     *
     * @return OrderResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, CreateOrder $createOrder)
    {
        $this->validate($request, [
            'name'       => 'required',
            'email'      => 'required|email',
            'basket'     => 'required',
            'currency'   => 'required',
            'deliveryId' => 'required',
        ]);

        try {
            $order = $createOrder->handler(
                $request->get('basket'),
                $request->except('basket'),
                auth('api')->user()
            );

            return new OrderResource($order);
        } catch (AbstractPizzaException $exception) {
            \Log::error('OrderCreateError.user', ['error' => $exception]);

            return response(['message' => $exception->getMessage()], 400);
        } catch (\Exception $exception) {
            \Log::error('OrderCreateError.unexpected', ['error' => $exception]);

            return response(['message' => 'Sorry, unprocessed error, try later.'], 500);
        }
    }
}
