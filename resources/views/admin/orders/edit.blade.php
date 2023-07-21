@extends('layouts.light.master')
@section('title', 'Edit Order')

@section('breadcrumb-title')
<h3>Edit Order</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">
    <a href="{{ route('admin.orders.index') }}">Orders</a>
</li>
<li class="breadcrumb-item">Edit Order</li>
@endsection

@section('content')
<div class="row mb-5">
    <div class="col-sm-12">
        <div class="orders-table">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header p-3"><strong>Edit Order</strong></div>
                <div class="card-body p-3">
                    <x-form :action="route('admin.orders.update', $order)" method="PATCH">
                        @php $data = $order->data @endphp
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl-7">
                                <div class="card mb-lg-0">
                                    <div class="card-body p-3">
                                        <h3 class="card-title">Billing details</h3>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <x-label for="name">Name</x-label> <span class="text-danger">*</span>
                                                <x-input name="name" placeholder="Type your name here" :value="$order->name" />
                                                <x-error field="name" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <x-label for="phone">Phone</x-label> <span class="text-danger">*</span>
                                                <x-input name="phone" placeholder="Type your phone number here" :value="$order->phone ?? '+880'" />
                                                <x-error field="phone" />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <x-label for="email">Email Address</x-label>
                                                <x-input type="email" name="email" placeholder="Email Address" :value="$order->email" />
                                                <x-error field="email" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Shipping City <span class="text-danger">*</span></label>
                                            <div class="form-control @error('shipping') is-invalid @enderror">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="inside-dhaka" name="shipping" value="Inside Dhaka" data-val="50" {{ $data->shipping_area == 'Inside Dhaka' ? 'checked' : '' }} disabled>
                                                    <label class="custom-control-label" for="inside-dhaka">Inside Dhaka</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="outside-dhaka" name="shipping" value="Outside Dhaka" data-val="100" {{ $data->shipping_area == 'Outside Dhaka' ? 'checked' : '' }} disabled>
                                                    <label class="custom-control-label" for="outside-dhaka">Outside Dhaka</label>
                                                </div>
                                            </div>
                                            <x-error field="shipping" />
                                        </div>
                                        <div class="form-group">
                                            <x-label for="address">Address</x-label> <span class="text-danger">*</span>
                                            <x-input name="address" :value="$order->address" placeholder="Enter Correct Address" />
                                            <x-error field="address" />
                                        </div>
                                    </div>
                                    <div class="card-divider"></div>
                                    <div class="card-body p-3">
                                        <h3 class="card-title">Shipping Details</h3>
                                        <div class="form-group">
                                            <x-label for="note">Order Notes (Optional)</x-label>
                                            <x-textarea name="note" rows="4">{{ $order->note }}</x-textarea>
                                            <x-error field="note" />
                                        </div>
                                    </div>
                                    <div class="card-divider"></div>
                                    <div class="card-body p-3">
                                        <h3 class="card-title">Ordered Products</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->products as $product)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $product->image }}" width="100" height="100" alt="">
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                                        </td>
                                                        <td>{{ $product->quantity }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h3 class="card-title">Your Order</h3>
                                        
                                        <label for="status">Order Status</label>
                                        <select name="status" id="status" class="form-control">
                                            @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ $status == $order->status ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>

                                        <table class="checkout__totals table table-borderless">
                                            <tbody class="checkout__totals-subtotals">
                                                <tr>
                                                    <th>Subtotal</th>
                                                    <td class="checkout-subtotal">{!!  theMoney($data->subtotal)  !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping</th>
                                                    <td class="shipping">
                                                        <input style="height: auto; padding: 2px 8px;" type="text" name="data[shipping_cost]" value="{!!  $data->shipping_cost ?? 0  !!}" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="checkout__totals-footer">
                                                {{-- <tr>
                                                    <th>Total</th>
                                                    <td>{!!  theMoney($data->shipping_cost + $data->subtotal)  !!}</td>
                                                </tr> --}}
                                                <tr>
                                                    <th>Advanced</th>
                                                    <td>
                                                        <input style="height: auto; padding: 2px 8px;" type="text" name="data[advanced]" value="{!!  $data->advanced ?? 0  !!}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount</th>
                                                    <td>
                                                        <input style="height: auto; padding: 2px 8px;" type="text" name="data[discount]" value="{!!  $data->discount ?? 0  !!}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Payable</th>
                                                    <td class="shipping">{!!  theMoney($order->data->shipping_cost + $order->data->subtotal - ($order->data->advanced ?? 0) - ($order->data->discount ?? 0))  !!}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button type="submit" class="btn btn-primary btn-xl btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
