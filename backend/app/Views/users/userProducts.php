<!DOCTYPE html>
<html lang="en">
<?= view('components/head', ['title' => '🔥 Product Gallery']) ?>

<head>
    <?= view('components/head', ['title' => '🔥 Product Gallery']) ?>
</head>

<body class="bg-[var(--accent)] text-[var(--neutral)] font-sans">
    <?= view('components/header'); ?>

    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[var(--neutral)]">Product Gallery</h1>
            <p class="text-[var(--neutral)]/70 mt-2">Explore our collection of artworks, artbooks, and merchandise</p>
        </div>

        <!-- Search Bar with Clear Button -->
        <div class="mb-6 flex items-center gap-2">
            <input type="text" id="productSearch" placeholder="Search products..."
                class="flex-1 px-4 py-2 rounded-lg bg-[#1b1b1b] border border-[var(--secondary)] text-[var(--neutral)] focus:outline-none focus:ring-2 focus:ring-[var(--primary)]" />
            <button id="clearSearch" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition">
                Clear
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-4 mb-8 overflow-x-auto">
            <button onclick="setActive(this, 'all')"
                    class="px-6 py-3 rounded-lg font-semibold transition whitespace-nowrap bg-[var(--primary)] text-white border-2 border-[var(--primary)]"
                    data-category="all">
                All Products
            </button>
            <button onclick="setActive(this, 'artwork')"
                    class="px-6 py-3 rounded-lg font-semibold transition whitespace-nowrap bg-[var(--accent)] text-[var(--neutral)] border-2 border-[var(--secondary)]"
                    data-category="artwork">
                Artworks
            </button>
            <button onclick="setActive(this, 'artbook')"
                    class="px-6 py-3 rounded-lg font-semibold transition whitespace-nowrap bg-[var(--accent)] text-[var(--neutral)] border-2 border-[var(--secondary)]"
                    data-category="artbook">
                Artbooks
            </button>
            <button onclick="setActive(this, 'merchandise')"
                    class="px-6 py-3 rounded-lg font-semibold transition whitespace-nowrap bg-[var(--accent)] text-[var(--neutral)] border-2 border-[var(--secondary)]"
                    data-category="merchandise">
                Merchandise
            </button>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <!-- Empty State -->
            <div class="bg-[#1b1b1b] rounded-lg shadow-xl p-12 border border-[var(--secondary)]/20 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-[var(--secondary)]/20 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-box-open text-[var(--secondary)] text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-[var(--neutral)] mb-3">No Products Available</h2>
                <p class="text-[var(--neutral)]/70 mb-6">Check back later for new items!</p>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="productsGrid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card bg-[#1b1b1b] rounded-lg shadow-xl border border-[var(--secondary)]/20 overflow-hidden hover:border-[var(--secondary)]/40 transition duration-200"
                         data-category="<?= esc($product->category) ?>">
                        
                        <!-- Product Image -->
                        <div class="relative h-64 bg-[var(--secondary)]/10 overflow-hidden">
                            <?php if ($product->image_url): ?>
                                <img src="<?= esc($product->image_url) ?>" 
                                     alt="<?= esc($product->name) ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-image text-[var(--secondary)] text-6xl"></i>
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
                            <div class="absolute top-4 right-4">
                                <span class="bg-[var(--<?= $color ?>)]/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                    <?= ucfirst(esc($product->category)) ?>
                                </span>
                            </div>

                            <!-- Stock Status Badge -->
                            <?php if ($product->stock <= 5 && $product->stock > 0): ?>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-orange-500/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                        Only <?= $product->stock ?> left
                                    </span>
                                </div>
                            <?php elseif ($product->stock == 0): ?>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-red-500/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                        Out of Stock
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-green-500/90 text-white px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">
                                        In Stock
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[var(--neutral)] mb-2">
                                <?= esc($product->name) ?>
                            </h3>

                            <?php if ($product->artist): ?>
                                <p class="text-[var(--neutral)]/60 text-sm mb-3">
                                    <i class="fa-solid fa-user mr-1"></i>
                                    by <?= esc($product->artist) ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($product->description): ?>
                                <p class="text-[var(--neutral)]/80 text-sm mb-4 line-clamp-3">
                                    <?= esc($product->description) ?>
                                </p>
                            <?php endif; ?>

                            <div class="flex items-center justify-between pt-4 border-t border-[var(--secondary)]/20">
                                <div>
                                    <p class="text-[var(--primary)] font-bold text-2xl">
                                        ₱<?= number_format($product->price, 2) ?>
                                    </p>
                                    <p class="text-[var(--neutral)]/60 text-xs">
                                        <i class="fa-solid fa-box mr-1"></i>
                                        <?= $product->stock ?> available
                                    </p>
                                </div>

                                <!-- No Order Button - Just Show Availability -->
                                <div class="text-right">
                                    <?php if ($product->stock > 0): ?>
                                        <span class="inline-flex items-center gap-2 text-green-500 text-sm font-semibold">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Available
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-2 text-red-500 text-sm font-semibold">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?= view('components/footer'); ?>

    <script>
    // Single filterCategory function
    function filterCategory(category, event) {
        // Update active button
        if (event) {
            document.querySelectorAll('.category-filter').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Clear search input when switching categories
        document.getElementById('productSearch').value = '';

        const products = document.querySelectorAll('.product-card');
        products.forEach(product => {
            if (category === 'all' || product.dataset.category === category) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    // Search bar functionality
    document.getElementById('productSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const activeCategory = document.querySelector('.category-filter.active').dataset.category;

        const products = document.querySelectorAll('.product-card');
        products.forEach(product => {
            const name = product.querySelector('h3').textContent.toLowerCase();
            const desc = product.querySelector('p') ? product.querySelector('p').textContent.toLowerCase() : '';
            const matchesCategory = (activeCategory === 'all') || (product.dataset.category === activeCategory);
            const matchesSearch = name.includes(query) || desc.includes(query);

            product.style.display = (matchesCategory && matchesSearch) ? 'block' : 'none';
        });
    });

    // Clear button functionality
    document.getElementById('clearSearch').addEventListener('click', function() {
        const searchInput = document.getElementById('productSearch');
        searchInput.value = ''; // Clear input

        const activeCategory = document.querySelector('.category-filter.active').dataset.category;
        const products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            if (activeCategory === 'all' || product.dataset.category === activeCategory) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });

        searchInput.focus();
    });

    function setActive(button, category) {
    // Remove active style from all buttons
    document.querySelectorAll('button[data-category]').forEach(btn => {
        btn.classList.remove('bg-[var(--primary)]', 'text-white', 'border-[var(--primary)]');
        btn.classList.add('bg-[var(--accent)]', 'text-[var(--neutral)]', 'border-[var(--secondary)]');
    });

    // Set active style on clicked button
    button.classList.remove('bg-[var(--accent)]', 'text-[var(--neutral)]', 'border-[var(--secondary)]');
    button.classList.add('bg-[var(--primary)]', 'text-white', 'border-[var(--primary)]');

    // Filter products
    const products = document.querySelectorAll('.product-card');
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setActive(document.querySelector('button[data-category="all"]'), 'all');
    });
</script>
</body>

</html>