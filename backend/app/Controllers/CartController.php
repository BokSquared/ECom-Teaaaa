<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;

class CartController extends BaseController
{
    public function add()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        $productModel = new ProductsModel();
        $id = $this->request->getPost('product_id');
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->back();
        }

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] < $product->stock) {
                $cart[$id]['quantity'] += 1;
            }
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'stock' => $product->stock,
                'quantity' => 1
            ];
        }

        $session->set('cart', $cart);
        return redirect()->back();
    }
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        return view('user/cart', ['cart' => $cart]);
    }

    public function update()
    {
        $session = session();
        $cart = $session->get('cart');

        $id = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if (!isset($cart[$id])) {
            return redirect()->to('/user/cart');
        }

        $maxStock = $cart[$id]['stock'];

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = min($quantity, $maxStock);
        }

        $session->set('cart', $cart);
        return redirect()->to('/user/cart');
    }

    public function remove()
    {
        $session = session();
        $cart = $session->get('cart');

        $id = $this->request->getPost('product_id');
        unset($cart[$id]);

        $session->set('cart', $cart);
        return redirect()->to('/user/cart');
    }
}
