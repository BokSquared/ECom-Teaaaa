<!DOCTYPE html>
<html lang="en">
<?= view('components/head', ['title' => '🔥 Order Details']) ?>

<body class="bg-[var(--accent)] font-sans text-[var(--neutral)]">
    <?= view('components/header_user'); ?>

    <div class="mx-auto px-6 py-8 container">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4 text-[var(--neutral)]/60">
                <a href="/user/orders" class="hover:text-[var(--secondary)] transition">My Orders</a>
                <span>/</span>
                <span class="text-[var(--neutral)]"><?= esc($order->order_number) ?></span>
            </div>
            <h1 class="font-bold text-[var(--neutral)] text-3xl">Order Details</h1>
        </div>


        <div class="gap-6 grid lg:grid-cols-3">
            <!-- Left Column: Order Items & Customer Info -->
            <div class="space-y-6 lg:col-span-2">

                <!-- Order Items -->
                <div class="bg-[#1b1b1b] shadow-xl p-6 border border-[var(--secondary)]/20 rounded-lg">
                    <h2 class="mb-6 font-bold text-[var(--neutral)] text-2xl">Order Items</h2>

                    <div class="space-y-4">
                        <?php if (!empty($order->items)): ?>
                            <?php foreach ($order->items as $item): ?>
                                <div class="flex gap-4 pb-4 border-[var(--secondary)]/10 last:border-0 border-b">
                                    <!-- Product Image Placeholder -->
                                    <div class="flex flex-shrink-0 justify-center items-center bg-[var(--secondary)]/20 rounded-lg w-20 h-20">
                                        <i class="text-[var(--secondary)] text-2xl fa-solid fa-image"></i>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="mb-1 font-bold text-[var(--neutral)] text-lg">
                                            <?= esc($item->product_name) ?>
                                        </h3>
                                        <p class="mb-2 text-[var(--neutral)]/60 text-sm">
                                            <?= ucfirst(esc($item->product_category)) ?>
                                        </p>
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="text-[var(--neutral)]/80">
                                                <i class="mr-1 fa-solid fa-dollar-sign"></i>
                                                <?= number_format($item->price, 2) ?> each
                                            </span>
                                            <span class="text-[var(--neutral)]/80">
                                                <i class="mr-1 fa-solid fa-box"></i>
                                                Qty: <?= esc($item->quantity) ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <p class="font-bold text-[var(--primary)] text-xl">
                                            $<?= number_format($item->subtotal, 2) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Total Section -->
                            <div class="pt-4 border-[var(--secondary)]/20 border-t-2">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-[var(--neutral)] text-xl">Total Amount</h3>
                                    <p class="font-bold text-[var(--primary)] text-2xl">
                                        $<?= number_format($order->total_amount, 2) ?>
                                    </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="py-8 text-[var(--neutral)]/60 text-center">No items in this order</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Customer & Shipping Information -->
                <div class="bg-[#1b1b1b] shadow-xl p-6 border border-[var(--secondary)]/20 rounded-lg">
                    <h2 class="mb-6 font-bold text-[var(--neutral)] text-2xl">Shipping Information</h2>

                    <div class="gap-6 grid md:grid-cols-2">
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Customer Name</p>
                            <p class="font-semibold text-[var(--neutral)]"><?= esc($order->customer_name) ?></p>
                        </div>

                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Email</p>
                            <p class="font-semibold text-[var(--neutral)]"><?= esc($order->customer_email) ?></p>
                        </div>

                        <?php if ($order->customer_phone): ?>
                            <div>
                                <p class="mb-2 text-[var(--neutral)]/60 text-sm">Phone</p>
                                <p class="font-semibold text-[var(--neutral)]"><?= esc($order->customer_phone) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($order->shipping_address): ?>
                            <div class="md:col-span-2">
                                <p class="mb-2 text-[var(--neutral)]/60 text-sm">Shipping Address</p>
                                <p class="font-semibold text-[var(--neutral)]"><?= nl2br(esc($order->shipping_address)) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notes (if any) -->
                <?php if ($order->notes): ?>
                    <div class="bg-[#1b1b1b] shadow-xl p-6 border border-[var(--secondary)]/20 rounded-lg">
                        <h2 class="mb-4 font-bold text-[var(--neutral)] text-2xl">
                            <i class="fa-note-sticky mr-2 fa-solid"></i>Order Notes
                        </h2>
                        <p class="text-[var(--neutral)]/80"><?= nl2br(esc($order->notes)) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="space-y-6">

                <!-- Order Status Card -->
                <div class="bg-[#1b1b1b] shadow-xl p-6 border border-[var(--secondary)]/20 rounded-lg">
                    <h2 class="mb-6 font-bold text-[var(--neutral)] text-xl">Order Status</h2>

                    <div class="space-y-4">
                        <!-- Order Number -->
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Order Number</p>
                            <p class="font-bold text-[var(--neutral)] text-lg"><?= esc($order->order_number) ?></p>
                        </div>

                        <!-- Order Date -->
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Order Date</p>
                            <p class="font-semibold text-[var(--neutral)]">
                                <?= date('M d, Y - h:i A', strtotime($order->created_at)) ?>
                            </p>
                        </div>

                        <!-- Order Status -->
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Order Status</p>
                            <?php
                            $statusColors = [
                                'pending' => 'yellow-500',
                                'processing' => 'blue-500',
                                'shipped' => 'purple-500',
                                'delivered' => 'green-500',
                                'cancelled' => 'red-500'
                            ];
                            $color = $statusColors[$order->status] ?? 'gray-500';
                            ?>
                            <span class="inline-block bg-<?= $color ?>/20 text-<?= $color ?> px-4 py-2 rounded-lg font-bold text-sm">
                                <?= ucfirst(esc($order->status)) ?>
                            </span>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Payment Status</p>
                            <?php if ($order->payment_status === 'paid'): ?>
                                <span class="inline-block bg-green-500/20 px-4 py-2 rounded-lg font-bold text-green-500 text-sm">
                                    <i class="mr-2 fa-solid fa-check-circle"></i>Paid
                                </span>
                            <?php else: ?>
                                <span class="inline-block bg-red-500/20 px-4 py-2 rounded-lg font-bold text-red-500 text-sm">
                                    <i class="mr-2 fa-solid fa-clock"></i>Unpaid
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ($order->payment_status !== 'paid'): ?>
                            <div class="pt-4 border-[var(--secondary)]/20 border-t">
                                <p class="mb-3 text-[var(--neutral)]/60 text-sm">Complete Payment</p>


                                <div class="space-y-3">
                                    <!-- GCash -->
                                    <a href="/user/pay/gcash/<?= $order->id ?>"
                                        class="block bg-green-500 hover:bg-green-600 px-4 py-3 rounded-lg w-full font-semibold text-white text-center transition">
                                        <i class="mr-2 fa-solid fa-mobile-screen-button"></i>
                                        Pay with GCash
                                    </a>

                                    <!-- PayPal -->
                                    <a href="/user/pay/paypal/<?= $order->id ?>"
                                        class="block bg-blue-500 hover:bg-blue-600 px-4 py-3 rounded-lg w-full font-semibold text-white text-center transition">
                                        <i class="mr-2 fa-brands fa-paypal"></i>
                                        Pay with PayPal
                                    </a>

                                    <!-- Cash on Delivery -->
                                    <a href="/user/pay/cod/<?= $order->id ?>"
                                        class="block bg-yellow-500 hover:bg-yellow-600 px-4 py-3 rounded-lg w-full font-semibold text-black text-center transition">
                                        <i class="mr-2 fa-solid fa-truck"></i>
                                        Cash on Delivery
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($order->payment_status === 'paid'): ?>
                            <span class="font-bold text-[var(--primary)]">
                                Paid via <?= esc($order->payment_method ?? 'Unknown') ?>
                                <p>Shipping Cost: $<?= number_format($order->shipping_cost, 2) ?></p>
                                <p>Estimated Delivery: <?= date('F j, Y', strtotime($order->estimated_delivery)) ?></p>
                            </span>
                        <?php endif; ?>

                        <!-- Last Updated -->
                        <div>
                            <p class="mb-2 text-[var(--neutral)]/60 text-sm">Last Updated</p>
                            <p class="text-[var(--neutral)] text-sm">
                                <?= date('M d, Y - h:i A', strtotime($order->updated_at)) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="bg-[#1b1b1b] shadow-xl p-6 border border-[var(--secondary)]/20 rounded-lg">
                    <h2 class="mb-6 font-bold text-[var(--neutral)] text-xl">Order Timeline</h2>

                    <div class="space-y-4">
                        <?php
                        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);

                        foreach ($statuses as $index => $status):
                            $isComplete = $index <= $currentIndex;
                            $isCurrent = $index === $currentIndex;
                        ?>
                            <div class="flex items-center gap-3">
                                <div class="<?= $isComplete ? 'bg-[var(--primary)]' : 'bg-[var(--neutral)]/20' ?> w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <?php if ($isComplete): ?>
                                        <i class="text-white text-sm fa-solid fa-check"></i>
                                    <?php else: ?>
                                        <div class="bg-[var(--neutral)]/40 rounded-full w-2 h-2"></div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="<?= $isComplete ? 'text-[var(--neutral)] font-semibold' : 'text-[var(--neutral)]/40' ?> text-sm">
                                        <?= ucfirst($status) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="/user/orders"
                    class="block bg-[var(--accent)] hover:bg-[var(--secondary)]/10 px-4 py-3 border border-[var(--secondary)]/30 rounded-lg w-full font-semibold text-[var(--neutral)] text-center transition duration-200">
                    <i class="fa-arrow-left mr-2 fa-solid"></i>
                    Back to Orders
                </a>
            </div>
        </div>
    </div>

    <?= view('components/footer'); ?>
</body>

</html>