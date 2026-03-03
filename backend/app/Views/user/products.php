<!DOCTYPE html>
<html lang="en">
<?= view('components/head', ['title' => '🔥 Browse Products']) ?>

<body class="bg-[var(--accent)] font-sans text-[var(--neutral)]">
    <?= view('components/header_user'); ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-500/20 mb-6 p-4 border border-green-500 rounded-lg text-green-400">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500/20 mb-6 p-4 border border-red-500 rounded-lg text-red-400">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')): ?>
        <div class="bg-yellow-500/20 mb-6 p-4 border border-yellow-500 rounded-lg text-yellow-400">
            <?= session()->getFlashdata('warning') ?>
        </div>
    <?php endif; ?>

    <div class="mx-auto px-6 py-8 container">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="font-bold text-[var(--neutral)] text-3xl">Product Gallery</h1>
            <p class="mt-2 text-[var(--neutral)]/70">Explore our collection of artworks, artbooks, and merchandise</p>
        </div>

        <!-- Search Bar with Clear Button -->
        <div class="flex items-center gap-2 mb-6">
            <input type="text" id="productSearch" placeholder="Search products..."
                class="flex-1 bg-[#1b1b1b] px-4 py-2 border border-[var(--secondary)] rounded-lg focus:outline-none focus:ring-[var(--primary)] focus:ring-2 text-[var(--neutral)]" />
            <button id="clearSearch"
                class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-semibold text-white text-sm transition">
                Clear
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-4 mb-8 overflow-x-auto">
            <button onclick="setActive(this, 'all')"
                class="bg-[var(--primary)] px-6 py-3 border-[var(--primary)] border-2 rounded-lg font-semibold text-white whitespace-nowrap transition"
                data-category="all">
                All Products
            </button>
            <button onclick="setActive(this, 'artwork')"
                class="bg-[var(--accent)] px-6 py-3 border-[var(--secondary)] border-2 rounded-lg font-semibold text-[var(--neutral)] whitespace-nowrap transition"
                data-category="artwork">
                Artworks
            </button>
            <button onclick="setActive(this, 'artbook')"
                class="bg-[var(--accent)] px-6 py-3 border-[var(--secondary)] border-2 rounded-lg font-semibold text-[var(--neutral)] whitespace-nowrap transition"
                data-category="artbook">
                Artbooks
            </button>
            <button onclick="setActive(this, 'merchandise')"
                class="bg-[var(--accent)] px-6 py-3 border-[var(--secondary)] border-2 rounded-lg font-semibold text-[var(--neutral)] whitespace-nowrap transition"
                data-category="merchandise">
                Merchandise
            </button>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <!-- Empty State -->
            <div class="bg-[#1b1b1b] shadow-xl p-12 border border-[var(--secondary)]/20 rounded-lg text-center">
                <div class="flex justify-center items-center bg-[var(--secondary)]/20 mx-auto mb-6 rounded-full w-24 h-24">
                    <i class="text-[var(--secondary)] text-4xl fa-solid fa-box-open"></i>
                </div>
                <h2 class="mb-3 font-bold text-[var(--neutral)] text-2xl">No Products Available</h2>
                <p class="mb-6 text-[var(--neutral)]/70">Check back later for new items!</p>
            </div>
        <?php else: ?>
            <div class="gap-6 grid md:grid-cols-2 lg:grid-cols-3" id="productsGrid">
                <?php foreach ($products as $product): ?>
                    <div class="bg-[#1b1b1b] shadow-xl border border-[var(--secondary)]/20 hover:border-[var(--secondary)]/40 rounded-lg overflow-hidden transition duration-200 product-card"
                        data-category="<?= esc($product->category) ?>">

                        <!-- Product Image -->
                        <div class="relative bg-[var(--secondary)]/10 h-64 overflow-hidden">
                            <?php if ($product->image_url): ?>
                                <img src="<?= esc($product->image_url) ?>"
                                    alt="<?= esc($product->name) ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="flex justify-center items-center w-full h-full">
                                    <i class="text-[var(--secondary)] text-6xl fa-solid fa-image"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Category Badge -->
                            <?php
                            $categoryColors = [
                                'artwork' => 'primary',
                                'artbook' => 'secondary',
                                'merchandise' => 'green-500'
                            ];
                            $color = $categoryColors[$product->category] ?? 'gray-500';
                            ?>
                            <div class="top-4 right-4 absolute">
                                <span class="bg-[var(--<?= $color ?>)]/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                    <?= ucfirst(esc($product->category)) ?>
                                </span>
                            </div>

                            <!-- Stock Status Badge -->
                            <?php if ($product->stock <= 5 && $product->stock > 0): ?>
                                <div class="top-4 left-4 absolute">
                                    <span class="bg-orange-500/90 backdrop-blur-sm px-3 py-1 rounded-full font-semibold text-white text-xs">
                                        Only <?= $product->stock ?> left
                                    </span>
                                </div>
                            <?php elseif ($product->stock == 0): ?>
                                <div class="top-4 left-4 absolute">
                                    <span class="bg-red-500/90 backdrop-blur-sm px-3 py-1 rounded-full font-semibold text-white text-xs">
                                        Out of Stock
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="top-4 left-4 absolute">
                                    <span class="bg-green-500/90 backdrop-blur-sm px-3 py-1 rounded-full font-semibold text-white text-xs">
                                        In Stock
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="mb-2 font-bold text-[var(--neutral)] text-xl">
                                <?= esc($product->name) ?>
                            </h3>

                            <?php if ($product->artist): ?>
                                <p class="mb-3 text-[var(--neutral)]/60 text-sm">
                                    <i class="mr-1 fa-solid fa-user"></i>
                                    by <?= esc($product->artist) ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($product->description): ?>
                                <p class="mb-4 text-[var(--neutral)]/80 text-sm line-clamp-2">
                                    <?= esc($product->description) ?>
                                </p>
                            <?php endif; ?>

                            <div class="flex justify-between items-center pt-4 border-[var(--secondary)]/20 border-t">
                                <div>
                                    <p class="font-bold text-[var(--primary)] text-2xl">
                                        $<?= number_format($product->price, 2) ?>
                                    </p>
                                    <p class="text-[var(--neutral)]/60 text-xs">
                                        <i class="mr-1 fa-solid fa-box"></i>
                                        <?= $product->stock ?> in stock
                                    </p>
                                </div>

                                <?php if ($product->stock > 0): ?>
                                    <div class="flex flex-col gap-2">

                                        <!-- Add to Cart Form -->
                                        <form method="POST" action="/user/cart/add">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?= esc($product->id) ?>">
                                            <input type="hidden" name="product_name" value="<?= esc($product->name) ?>">
                                            <input type="hidden" name="product_price" value="<?= esc($product->price) ?>">
                                            <input type="hidden" name="product_image" value="<?= esc($product->image_url) ?>">

                                            <button type="submit"
                                                class="bg-[var(--secondary)] hover:bg-[var(--secondary)]/80 px-6 py-2 rounded-lg w-full font-semibold text-white transition duration-200">
                                                <i class="mr-2 fa-solid fa-cart-plus"></i>
                                                Add to Cart
                                            </button>
                                        </form>

                                        <!-- Order Now -->
                                        <a href="/user/order/confirm/<?= esc($product->id) ?>"
                                            class="bg-[var(--primary)] hover:bg-[var(--primary)]/80 px-6 py-2 rounded-lg w-full font-semibold text-[var(--neutral)] text-center transition duration-200">
                                            Order Now
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <button disabled
                                        class="bg-gray-500/20 px-6 py-3 rounded-lg font-semibold text-gray-500 cursor-not-allowed">
                                        Unavailable
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?= view('components/footer'); ?>

    <script>
        function setActive(button, category) {
            // Remove active style from all buttons
            document.querySelectorAll('button[data-category]').forEach(btn => {
                btn.classList.remove('bg-[var(--primary)]', 'text-white', 'border-[var(--primary)]', 'active');
                btn.classList.add('bg-[var(--accent)]', 'text-[var(--neutral)]', 'border-[var(--secondary)]');
            });

            // Set active style on clicked button
            button.classList.remove('bg-[var(--accent)]', 'text-[var(--neutral)]', 'border-[var(--secondary)]');
            button.classList.add('bg-[var(--primary)]', 'text-white', 'border-[var(--primary)]', 'active');

            // Filter products based on active category + search input
            filterProducts(category);
        }

        function filterProducts(category) {
            const query = document.getElementById('productSearch').value.toLowerCase();
            const products = document.querySelectorAll('.product-card');

            products.forEach(product => {
                const name = product.querySelector('h3').textContent.toLowerCase();
                const descEl = product.querySelector('p');
                const desc = descEl ? descEl.textContent.toLowerCase() : '';
                const matchesCategory = (category === 'all') || (product.dataset.category === category);
                const matchesSearch = name.includes(query) || desc.includes(query);

                product.style.display = (matchesCategory && matchesSearch) ? 'block' : 'none';
            });
        }

        // Search input live filtering
        document.getElementById('productSearch').addEventListener('input', function() {
            const activeCategory = document.querySelector('button.active').dataset.category;
            filterProducts(activeCategory);
        });

        // Clear button
        document.getElementById('clearSearch').addEventListener('click', function() {
            const input = document.getElementById('productSearch');
            input.value = '';
            const activeCategory = document.querySelector('button.active').dataset.category;
            filterProducts(activeCategory);
            input.focus();
        });

        document.addEventListener('DOMContentLoaded', () => {
            setActive(document.querySelector('button[data-category="all"]'), 'all');
        });
    </script>
</body>

</html>