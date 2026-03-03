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
            $session->setFlashdata('error', 'Product not found');
            return redirect()->back();
        }

        $productId = $product->id;

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] < $product->stock) {
                $cart[$productId]['quantity'] += 1;
                $session->setFlashdata('success', "Increased quantity of '{$product->name}' in cart.");
            } else {
                $session->setFlashdata('warning', "'{$product->name}' has only {$product->stock} in stock.");
            }
        } else {
            if ($product->stock > 0) {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image_url,
                    'stock' => $product->stock,
                    'quantity' => 1
                ];
                $session->setFlashdata('success', "Added '{$product->name}' to cart.");
            } else {
                $session->setFlashdata('error', "'{$product->name}' is out of stock.");
            }
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
        $cart = $session->get('cart') ?? [];

        $id = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if (!isset($cart[$id])) {
            $session->setFlashdata('error', 'Product not found in cart.');
            return redirect()->to('/user/cart');
        }

        $maxStock = $cart[$id]['stock'];

        if ($quantity <= 0) {
            unset($cart[$id]);
            $session->setFlashdata('success', 'Item removed from cart.');
        } else {
            $cart[$id]['quantity'] = min($quantity, $maxStock);
            $session->setFlashdata('success', "Updated quantity of '{$cart[$id]['name']}' to {$cart[$id]['quantity']}.");
        }

        $session->set('cart', $cart);
        return redirect()->to('/user/cart');
    }

    public function remove()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        $id = $this->request->getPost('product_id');

        if (isset($cart[$id])) {
            $name = $cart[$id]['name'];
            unset($cart[$id]);
            $session->setFlashdata('success', "Removed '{$name}' from cart.");
        } else {
            $session->setFlashdata('error', 'Product not found in cart.');
        }

        $session->set('cart', $cart);
        return redirect()->to('/user/cart');
    }

    // Optional helper: clean unavailable items
    public function cleanUnavailable()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $productModel = new ProductsModel();

        $updatedCart = [];

        foreach ($cart as $item) {
            $product = $productModel->find($item['id']);
            if ($product && $product->stock > 0 && $product->is_available == 1) {
                $updatedCart[$item['id']] = $item;
            }
        }

        $session->set('cart', $updatedCart);
    }
}
