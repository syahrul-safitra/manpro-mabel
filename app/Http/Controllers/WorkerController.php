<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderProduct $order)
    {
        $order->load('worker');

        $getUserIdWorkerInOrder = $order->worker->pluck('user_id');

        return view('Admin.Worker.create', [
            'users' => User::where('is_admin', 0)->whereNotIn('id', $getUserIdWorkerInOrder)->get(),
            'order_id' => $order->id
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required', 
            'order_product_id' => 'required'
        ]);

        $orderProduct = OrderProduct::find($validated['order_product_id']);

        $orderProduct->load('worker', 'material');
        
        // check data pada worker apakah sudah ada
        $check = $orderProduct->worker->where('user_id',$validated['user_id'] )->first();

        if( $check) {
            return redirect('detail-order/'  . $orderProduct->id)->with('error', 'Tukang sudah ada');
        }

        Worker::create($validated);

        return redirect('detail-order/'  . $orderProduct->id)->with('success', 'Tukang berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Worker $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        $worker->delete();

        return back()->with('success', 'Berhasil menghapus data tukang');
    }

    public function userWorker()
    {
        $user = auth()->user();

        $worker = Worker::where('user_id', $user->id)->with('orderProduct')->get();

        return view('User.work', [
            'worker' => $worker
        ]);
    }

    public function detailWorking(OrderProduct $order)
    {
        $order->load('worker.user', 'material', 'comment.user');

        return view('User.detail-working', [
            'order' => $order
        ]);
    }
}
