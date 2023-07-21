<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
//        dd(Order::query()->first());
        $query = Order::query();
        if ($request->get('status')) {
            $query->where('status', 'like', \request('status'));
        } else {
            $query->where('status', '!=', 'PENDING');
        }
        $orders = $query->when(!$request->has('order'), function ($query) {
            $query->latest('id');
        });


        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return "<div class='text-nowrap'>" . $row->created_at->format('d-M-Y') . "<br>" . $row->created_at->format('h:i A') . "</div>";
            })
            ->editColumn('price', function ($row) {
                return $row->data->subtotal + $row->data->shipping_cost;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="order_id[]" value="' . $row->id . '">';
            })
            ->editColumn('name', function ($row) {
                return "<div class='text-nowrap'>" . $row->name . "<br><span class='text-danger'>" . $row->note . "</span></div>";
            })
            ->addColumn('actions', function (Order $order) {
                return '<div class="d-flex justify-content-center">
                    <a href="'.route('admin.orders.show', $order).'" class="btn btn-sm btn-primary px-2 d-block">View</a>
                    <a href="'.route('admin.orders.edit', $order).'" class="btn btn-sm btn-success px-2 d-block">Edit</a>
                    <a href="'.route('admin.orders.destroy', $order).'" data-action="delete" class="btn btn-sm btn-danger px-2 d-block">Delete</a>
                </div>';
            })
//            ->filterColumn('created_at', function($query, $keyword) {
//                $query->where('created_at', 'like', "%" . Carbon::createFromFormat('d-M-Y', $keyword)->format('Y-m-d') ."%");
//            })
            ->rawColumns(['checkbox', 'name', 'created_at', 'actions'])
            ->make(true);
    }
}
