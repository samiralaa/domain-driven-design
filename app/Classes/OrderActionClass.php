<?php 
namespace App\Classes;

class OrderActionClass{
    public function createOrder(array $array) 
    {
        return Order::create($array);

    }


    public function OptimizCodeGetData()
    {
        return Order::with('user')->get();
    }

    
}