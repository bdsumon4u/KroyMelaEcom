<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Notifications\User\AccountCreated;
use App\Notifications\User\OrderPlaced;
use App\Admin;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\CheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CheckoutRequest $request)
    {
        if ($request->isMethod('GET')) {
            //\LaravelFacebookPixel::createEvent('AddToCart', $parameters = []);
            return view('checkout');
        }

        $data = $request->validated();

        $order = DB::transaction(function () use ($data, &$order) {
            $products = Product::find(array_keys($data['products']))
                ->map(function (Product $product) use ($data) {
                    $id = $product->id;
                    $quantity = $data['products'][$id];

                    if ($quantity <= 0) {
                        return null;
                    }
                    // Manage Stock
                    if ($product->should_track) {
                        if ($product->stock_count <= 0) {
                            return null;
                        }
                        $quantity = $product->stock_count >= $quantity ? $quantity : $product->stock_count;
                        $product->decrement('stock_count', $quantity);
                    }

                    // Needed Attributes
                    return [
                        'id' => $id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image' => $product->base_image->src,
                        'price' => $product->selling_price,
                        'quantity' => $quantity,
                        'total' => $quantity * $product->selling_price,
                    ];
                })->filter(function ($product) {
                    return $product != null; // Only Available Products
                })->toArray();

            $data['products'] = json_encode($products);
            $oldOrders = Order::select(['id', 'admin_id', 'status'])->where('phone', $data['phone'])->get();
            $adminIds = $oldOrders->pluck('admin_id')->unique()->toArray();
            $adminQ = Admin::where('role_id', 1)->where('is_active', true)->inRandomOrder();
            if (count($adminIds) > 0) {
                $data['admin_id'] = $adminQ->whereIn('id', $adminIds)->first()->id ?? $adminQ->first()->id ?? null;
            } else {
                $data['admin_id'] = $adminQ->first()->id ?? null;
            }
            $user = $this->getUser($data);
            $status = !auth('user')->user() ? 'PROCESSING' // PENDING
                : data_get(config('app.orders', []), 0, 'PROCESSING'); // Default Status
            $data += [
                'user_id' => $user->id, // If User Logged In
                'status' => $status,
                // Additional Data
                'data' => [
                    'is_repeat'     => $oldOrders->count() > 0,
                    'is_fraud'      => $oldOrders->filter(function ($order) {
                        return $order->status == 'CANCELLED' || $order->status == 'RETURNED';
                    })->count() > 0,
                    'shipping_area' => $data['shipping'],
                    'shipping_cost' => setting('delivery_charge')->{$data['shipping'] == 'Inside Dhaka' ? 'inside_dhaka' : 'outside_dhaka'} ?? config('services.shipping.'.$data['shipping']),
                    'subtotal'      => is_array($products) ? array_reduce($products, function ($sum, $product) {
                        return $sum += $product['total'];
                    }) : $products->sum('total'),
                ],
            ];

           // \LaravelFacebookPixel::createEvent('Purchase', ['currency' => 'USD', 'value' => data_get(json_decode($data['data'], true), 'subtotal')]);

            $order = Order::create($data);
            $user->notify(new OrderPlaced($order));
            return $order;
        });

        // Undefined index email.
        // $data['email'] && Mail::to($data['email'])->queue(new OrderPlaced($order));

        session()->flash('completed', 'Dear ' . $data['name'] . ', Your Order is Successfully Recieved. Thanks For Your Order.');

        return redirect()->route('track-order', [
            'phone' => $data['phone'],
            'order' => optional($order)->getKey(),
        ] + ($request->isMethod('GET') ? [] : ['clear' => 'all']));
    }

    private function getUser($data)
    {
        if ($user = auth('user')->user()) {
            return $user;
        }

        $user = User::query()->firstOrCreate(
            ['phone_number' => $data['phone']],
            array_merge(Arr::except($data, 'phone'), [
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ])
        );

        // $user->notify(new AccountCreated());

        return $user;
    }
}
