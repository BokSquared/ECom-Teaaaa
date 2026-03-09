<!DOCTYPE html>
<html lang="en">

<?= view('components/head', ['title' => '🛒 My Cart']) ?>

<body class="bg-[var(--accent)] font-sans text-[var(--neutral)]">
    <?= view('components/header_user'); ?>

    <div class="mx-auto px-6 py-8 container">

        <h1 class="mb-8 font-bold text-3xl">Shopping Cart</h1>

        <?php if (empty($cart)): ?>
            <div class="bg-[#1b1b1b] p-10 border border-[var(--secondary)]/20 rounded-lg text-center">
                <p class="mb-4 text-[var(--neutral)]/70 text-lg">Your cart is empty.</p>
                <a href="/user/products"
                    class="bg-[var(--primary)] px-6 py-3 rounded-lg font-semibold">
                    Browse Products
                </a>
            </div>
        <?php else: ?>

            <?php $total = 0; ?>

            <div class="space-y-6">
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <?php $total += $subtotal; ?>

                    <div class="flex justify-between items-center bg-[#1b1b1b] p-6 border border-[var(--secondary)]/20 rounded-lg">

                        <div class="flex items-center gap-6">
                            <img src="<?= esc($item['image']) ?>"
                                class="rounded w-20 h-20 object-cover">

                            <div>
                                <h2 class="font-semibold text-xl"><?= esc($item['name']) ?></h2>
                                <p class="font-bold text-[var(--primary)]">
                                    $<?= number_format($item['price'], 2) ?>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">

                            <!-- Update Quantity -->
                            <form method="POST" action="/user/cart/update" class="flex items-center gap-2">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">

                                <input type="number"
                                    name="quantity"
                                    value="<?= $item['quantity'] ?>"
                                    min="1"
                                    class="bg-[#111] border border-[var(--secondary)] rounded w-16 text-center">

                                <button type="submit"
                                    class="bg-[var(--secondary)] px-4 py-2 rounded">
                                    Update
                                </button>
                            </form>

                            <!-- Remove -->
                            <form method="POST" action="/user/cart/remove">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">

                                <button type="submit"
                                    class="bg-red-500 px-4 py-2 rounded text-white">
                                    Remove
                                </button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Total -->
            <div class="flex justify-between items-center bg-[#1b1b1b] mt-10 p-6 border border-[var(--secondary)]/20 rounded-lg">
                <h2 class="font-bold text-2xl">Total:</h2>
                <h2 class="font-bold text-[var(--primary)] text-2xl">
                    $<?= number_format($total, 2) ?>
                </h2>
            </div>

            <!-- Checkout Button -->
            <div class="mt-6 text-right">
                <a href="/user/order/confirm/<?= esc($item['id']) ?>"
                    class="bg-[var(--primary)] px-6 py-2 rounded-lg w-full font-semibold text-[var(--neutral)] text-center">
                    Order Now
                </a>
                </a>
            </div>

        <?php endif; ?>

    </div>

    <?= view('components/footer'); ?>
</body>

</html>