/* AutoDeal Frontend App (jQuery + localStorage) */
(function () {
    const STORE_KEYS = {
        CART: 'autodeal_cart',
        WISHLIST: 'autodeal_wishlist',
        COMPARE: 'autodeal_compare',
        USER: 'autodeal_user'
    };

    // Catalog (ids should match data-id in HTML where present)
    const catalog = [
        { id: 'luxury-sedan-2024', name: '2024 Luxury Sedan', price: 45999, type: 'sedan', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/luxury_sedan.png" },
        { id: 'sport-suv-2024', name: '2024 Sport SUV', price: 52999, type: 'suv', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/sport_suv.png" },
        { id: 'sports-car-2024', name: '2024 Sports Car', price: 68999, type: 'sports', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/sports_car.png" },
        { id: 'family-van-2024', name: '2024 Family Van', price: 38999, type: 'van', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/family_van.png" },
        { id: 'electric-2024', name: '2024 Electric Car', price: 55999, type: 'electric', year: 2024, fuel: 'electric', condition: 'new', image: "images/electric_car.png" },
        { id: 'compact-suv-2024', name: '2024 Compact SUV', price: 42999, type: 'suv', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/compact_suv.png" },
        { id: 'premium-sedan-2023', name: '2023 Premium Sedan', price: 39999, type: 'sedan', year: 2023, fuel: 'gasoline', condition: 'used', image: "images/premium_sedan.png" },
        { id: 'luxury-suv-2024', name: '2024 Luxury SUV', price: 62999, type: 'suv', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/luxury_suv.png" },
        { id: 'super-sports-2024', name: '2024 Super Sports', price: 89999, type: 'sports', year: 2024, fuel: 'gasoline', condition: 'new', image: "images/super_sports.png" }
    ];

    function getProductById(id) {
        return catalog.find(p => p.id === id);
    }

    // Storage helpers
    function readStore(key, fallback) {
        try {
            const raw = localStorage.getItem(key);
            return raw ? JSON.parse(raw) : fallback;
        } catch {
            return fallback;
        }
    }
    function writeStore(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    // Cart
    function getCart() { return readStore(STORE_KEYS.CART, []); }
    function setCart(v) { writeStore(STORE_KEYS.CART, v); }
    function addToCart(productId, qty = 1) {
        const cart = getCart();
        const existing = cart.find(i => i.id === productId);
        if (existing) existing.qty += qty;
        else cart.push({ id: productId, qty });
        setCart(cart);
        updateBadges();
    }
    function removeFromCart(productId) {
        const cart = getCart().filter(i => i.id !== productId);
        setCart(cart);
        updateBadges();
    }
    function cartTotals() {
        const cart = getCart();
        let subtotal = 0;
        let items = 0;
        cart.forEach(i => {
            const p = getProductById(i.id);
            if (!p) return;
            subtotal += p.price * i.qty;
            items += i.qty;
        });
        const tax = Math.round(subtotal * 0.08);
        const total = subtotal + tax;
        return { items, subtotal, tax, total };
    }

    // Wishlist
    function getWishlist() { return readStore(STORE_KEYS.WISHLIST, []); }
    function setWishlist(v) { writeStore(STORE_KEYS.WISHLIST, v); }
    function addToWishlist(productId) {
        const list = new Set(getWishlist());
        list.add(productId);
        setWishlist([...list]);
        updateBadges();
    }
    function removeFromWishlist(productId) {
        const list = new Set(getWishlist());
        list.delete(productId);
        setWishlist([...list]);
        updateBadges();
    }

    // Compare (limit to 3)
    function getCompare() { return readStore(STORE_KEYS.COMPARE, []); }
    function setCompare(v) { writeStore(STORE_KEYS.COMPARE, v.slice(0, 3)); }
    function addToCompare(productId) {
        const list = getCompare();
        if (!list.includes(productId)) {
            list.push(productId);
            setCompare(list);
        }
    }
    function removeFromCompare(productId) {
        setCompare(getCompare().filter(id => id !== productId));
    }

    // Auth (demo only)
    function getUser() { return readStore(STORE_KEYS.USER, null); }
    function setUser(u) { writeStore(STORE_KEYS.USER, u); }
    function updateUserUI() {
        const user = getUser();
        const $loginBtn = $('a.btn.btn-outline[href="login.html"]');
        if (user && user.email) {
            $loginBtn.text(user.fullname ? `Hi, ${user.fullname.split(' ')[0]}` : 'Account');
        }
    }

    // Badges
    function updateBadges() {
        const wishlistCount = getWishlist().length;
        const cartCount = cartTotals().items;
        $('.nav-actions a[href="wishlist.html"] .badge').text(wishlistCount);
        $('.nav-actions a[href="cart.html"] .badge').text(cartCount);
    }

    // Products page: filtering and actions
    function initProductsPage() {
        // Ensure each .card has data attributes; if missing, infer from title using catalog map
        $('.cards-grid .card').each(function () {
            const $card = $(this);
            if ($card.attr('data-id')) return;
            const title = $card.find('.card-title').text().trim();
            const match = catalog.find(p => p.name === title);
            if (match) {
                $card.attr({
                    'data-id': match.id,
                    'data-type': match.type,
                    'data-price': match.price,
                    'data-year': match.year,
                    'data-fuel': match.fuel,
                    'data-condition': match.condition
                });
            }
        });

        // Normalize buttons
        $('.cards-grid .card').each(function () {
            const $card = $(this);
            const id = $card.attr('data-id');
            if (!id) return;
            // Add to Cart
            $card.find('.card-actions .btn.btn-primary').addClass('add-to-cart').attr('href', '#').attr('data-id', id).text('Add to Cart');
            // Wishlist
            $card.find('.card-actions .btn.btn-outline').addClass('add-to-wishlist').attr('href', '#').attr('data-id', id);
            // Add Compare button if not present
            if ($card.find('.card-actions .add-to-compare').length === 0) {
                $('<a class="btn btn-outline add-to-compare" href="#" style="font-size:0.85rem;">Compare</a>').attr('data-id', id).appendTo($card.find('.card-actions'));
            }
            // View Details
            if ($card.find('.view-details').length === 0) {
                $('<a class="btn btn-secondary view-details" href="#">View Details</a>').attr('data-id', id).appendTo($card.find('.card-actions'));
            }
        });

        // Filter logic
        function matchesFilters($card) {
            const type = $('#type').val();
            const price = $('#price').val();
            const year = $('#year').val();
            const fuel = $('#fuel').val();
            const isNew = $('#filter-new').is(':checked');
            const isUsed = $('#filter-used').is(':checked');
            const warranty = $('#filter-warranty').is(':checked'); // demo flag: show all if selected
            const financing = $('#filter-financing').is(':checked'); // demo flag: show all if selected

            const cType = $card.attr('data-type');
            const cYear = parseInt($card.attr('data-year'), 10);
            const cFuel = $card.attr('data-fuel');
            const cCond = $card.attr('data-condition');
            const cPrice = parseInt($card.attr('data-price'), 10);

            if (type !== 'all' && cType !== type) return false;
            if (year !== 'all' && cYear !== parseInt(year, 10)) return false;
            if (fuel !== 'all' && cFuel !== fuel) return false;
            if (price !== 'all') {
                if (price === '0-30000' && !(cPrice < 30000)) return false;
                if (price === '30000-50000' && !(cPrice >= 30000 && cPrice <= 50000)) return false;
                if (price === '50000-70000' && !(cPrice > 50000 && cPrice <= 70000)) return false;
                if (price === '70000+' && !(cPrice > 70000)) return false;
            }
            if (isNew && cCond !== 'new') return false;
            if (isUsed && cCond !== 'used') return false;
            // warranty/financing are demo toggles; they don't filter out items in this static demo
            return true;
        }
        function applyFilters() {
            $('.cards-grid .card').each(function () {
                const $card = $(this);
                $card.toggle(matchesFilters($card));
            });
        }
        $('#type,#price,#year,#fuel,#filter-new,#filter-used,#filter-warranty,#filter-financing').on('change click', applyFilters);
        applyFilters();

        // Actions
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault();
            addToCart($(this).attr('data-id'), 1);
        });
        $(document).on('click', '.add-to-wishlist', function (e) {
            e.preventDefault();
            addToWishlist($(this).attr('data-id'));
        });
        $(document).on('click', '.add-to-compare', function (e) {
            e.preventDefault();
            addToCompare($(this).attr('data-id'));
            alert('Added to comparison (max 3).');
        });
        $(document).on('click', '.view-details', function (e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            window.location.href = `product.html?id=${encodeURIComponent(id)}`;
        });
    }

    // Cart page
    function initCartPage() {
        const $list = $('#cart-list');
        const cart = getCart();
        $list.empty();
        if (cart.length === 0) {
            $list.append('<p class="text-light">Your cart is empty.</p>');
        } else {
            cart.forEach(item => {
                const p = getProductById(item.id);
                if (!p) return;
                const $row = $(`
                    <div class="cart-item" data-id="${p.id}">
                        <div class="item-image"><img src="${p.image}" alt="${p.name}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;"></div>
                        <div class="item-details">
                            <h3 class="item-title">${p.name}</h3>
                            <p class="text-light mb-05">$${p.price.toLocaleString()} • Qty: 
                                <input type="number" class="quantity-input" value="${item.qty}" min="1">
                            </p>
                            <div class="item-price">$${(p.price * item.qty).toLocaleString()}</div>
                        </div>
                        <div class="item-actions">
                            <button class="remove-btn">Remove</button>
                        </div>
                    </div>
                `);
                $list.append($row);
            });
        }
        function refreshSummary() {
            const t = cartTotals();
            $('#summary-items').text(`Subtotal (${t.items} items)`);
            $('#summary-subtotal').text(`$${t.subtotal.toLocaleString()}`);
            $('#summary-tax').text(`$${t.tax.toLocaleString()}`);
            $('#summary-total').text(`$${t.total.toLocaleString()}`);
            updateBadges();
        }
        refreshSummary();

        $list.on('click', '.remove-btn', function () {
            const id = $(this).closest('.cart-item').attr('data-id');
            removeFromCart(id);
            $(this).closest('.cart-item').remove();
            refreshSummary();
        });
        $list.on('change', '.quantity-input', function () {
            const id = $(this).closest('.cart-item').attr('data-id');
            const qty = Math.max(1, parseInt($(this).val(), 10) || 1);
            const cart = getCart();
            const item = cart.find(i => i.id === id);
            if (item) {
                item.qty = qty;
                setCart(cart);
                const p = getProductById(id);
                $(this).closest('.item-details').find('.item-price').text(`$${(p.price * qty).toLocaleString()}`);
                refreshSummary();
            }
        });
    }

    // Wishlist page
    function initWishlistPage() {
        const $list = $('#wishlist-list');
        const ids = getWishlist();
        $list.empty();
        if (ids.length === 0) {
            $list.append('<p class="text-light">Your wishlist is empty.</p>');
        } else {
            ids.forEach(id => {
                const p = getProductById(id);
                if (!p) return;
                const $row = $(`
                    <div class="wishlist-item" data-id="${p.id}">
                        <div class="item-image"><img src="${p.image}" alt="${p.name}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;"></div>
                        <div class="item-details">
                            <h3 class="item-title">${p.name}</h3>
                            <p class="text-light mb-05">$${p.price.toLocaleString()}</p>
                            <div class="item-price">$${p.price.toLocaleString()}</div>
                        </div>
                        <div class="item-actions">
                            <a href="#" class="btn btn-primary move-to-cart">Add to Cart</a>
                            <button class="remove-btn">Remove</button>
                        </div>
                    </div>
                `);
                $list.append($row);
            });
        }
        $list.on('click', '.remove-btn', function () {
            const id = $(this).closest('.wishlist-item').attr('data-id');
            removeFromWishlist(id);
            $(this).closest('.wishlist-item').remove();
            updateBadges();
        });
        $list.on('click', '.move-to-cart', function (e) {
            e.preventDefault();
            const id = $(this).closest('.wishlist-item').attr('data-id');
            addToCart(id, 1);
            removeFromWishlist(id);
            $(this).closest('.wishlist-item').remove();
        });
    }

    // Comparison page
    function initComparePage() {
        const ids = getCompare();
        const items = ids.map(getProductById).filter(Boolean);
        const $thead = $('#compare-head');
        const $tbody = $('#compare-body');
        $thead.empty();
        $tbody.empty();
        if (items.length === 0) {
            $tbody.append('<tr><td colspan="4" class="text-light">No items in comparison. Add up to 3 from Products.</td></tr>');
            return;
        }
        const head = ['Specifications', ...items.map(p => p.name)];
        $thead.append(`<tr>${head.map(h => `<th>${h}</th>`).join('')}</tr>`);
        function row(label, getVal) {
            return `<tr><td><strong>${label}</strong></td>${items.map(p => `<td>${getVal(p)}</td>`).join('')}</tr>`;
        }
        $tbody.append(row('Price', p => `$${p.price.toLocaleString()}`));
        $tbody.append(row('Type', p => p.type.toUpperCase()));
        $tbody.append(row('Year', p => p.year));
        $tbody.append(row('Fuel', p => p.fuel));
        $tbody.append(row('Condition', p => p.condition));
        $tbody.append(`<tr><td><strong>Action</strong></td>${
            items.map(p => `<td><a href="#" class="btn btn-primary btn-sm add-to-cart" data-id="${p.id}">Add to Cart</a> <a href="#" class="btn btn-outline btn-sm remove-compare" data-id="${p.id}">Remove</a></td>`).join('')
        }</tr>`);

        $(document).on('click', '.remove-compare', function (e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            removeFromCompare(id);
            window.location.reload();
        });
        $(document).on('click', 'table .add-to-cart', function (e) {
            e.preventDefault();
            addToCart($(this).attr('data-id'), 1);
        });
    }

    // Product details page
    function initProductDetailsPage() {
        const params = new URLSearchParams(window.location.search);
        const id = params.get('id');
        const p = id ? getProductById(id) : null;
        const $root = $('#product-details');
        if (!p) {
            $root.html('<p class="text-light">Product not found.</p>');
            return;
        }
        $root.html(`
            <div class="grid-auto-400-gap-3">
                <div class="card p-0">
                    <img src="${p.image}" alt="${p.name}" style="width: 100%; object-fit: cover; border-radius: 12px; display: block;">
                </div>
                <div class="p-2 bg-white rounded-12 shadow">
                    <h2 class="fs-3 text-dark mb-1">${p.name}</h2>
                    <div class="fs-2 text-primary mb-2">$${p.price.toLocaleString()}</div>
                    
                    <h3 class="fs-1 text-dark mb-1">Specifications</h3>
                    <div class="bg-light p-2 rounded-12 mb-2">
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px; border-bottom:1px solid #ddd; padding-bottom:5px;">
                            <span class="text-light">Condition</span>
                            <strong class="text-dark">${p.condition.toUpperCase()}</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px; border-bottom:1px solid #ddd; padding-bottom:5px;">
                            <span class="text-light">Type</span>
                            <strong class="text-dark">${p.type.toUpperCase()}</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px; border-bottom:1px solid #ddd; padding-bottom:5px;">
                            <span class="text-light">Year</span>
                            <strong class="text-dark">${p.year}</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <span class="text-light">Fuel Type</span>
                            <strong class="text-dark">${p.fuel.toUpperCase()}</strong>
                        </div>
                    </div>
                    
                    <div class="card-actions" style="margin-top: 2rem;">
                        <a href="#" class="btn btn-primary add-to-cart" data-id="${p.id}" style="flex:1; text-align:center;">Add to Cart</a>
                        <a href="#" class="btn btn-outline add-to-wishlist" data-id="${p.id}"><img src="images/heart_icon.png" alt="wishlist" class="emoji-icon"> Save</a>
                        <a href="#" class="btn btn-outline add-to-compare" data-id="${p.id}">Compare</a>
                    </div>
                </div>
            </div>
        `);
    }

    // Auth pages
    function initLoginPage() {
        $('form').on('submit', function (e) {
            e.preventDefault();
            const email = $('#email').val().trim();
            const password = $('#password').val().trim();
            if (!email || !password) return;
            const user = getUser();
            if (user && user.email === email) {
                setUser(user);
                window.location.href = 'index.html';
            } else {
                // Accept any credentials for demo; create a basic user if none exists
                setUser({ email, fullname: email.split('@')[0] });
                window.location.href = 'index.html';
            }
        });
    }
    function initSignupPage() {
        $('form').on('submit', function (e) {
            e.preventDefault();
            const fullname = $('#fullname').val().trim();
            const email = $('#email').val().trim();
            const password = $('#password').val().trim();
            const confirm = $('#confirm-password').val().trim();
            if (!fullname || !email || !password || password !== confirm) return;
            setUser({ fullname, email });
            window.location.href = 'index.html';
        });
    }

    // Global init
    $(function () {
        updateBadges();
        updateUserUI();
        const path = location.pathname.toLowerCase();
        if (path.endsWith('/products.html')) initProductsPage();
        if (path.endsWith('/cart.html')) initCartPage();
        if (path.endsWith('/wishlist.html')) initWishlistPage();
        if (path.endsWith('/comparison.html')) initComparePage();
        if (path.endsWith('/product.html')) initProductDetailsPage();
        if (path.endsWith('/login.html')) initLoginPage();
        if (path.endsWith('/signup.html')) initSignupPage();
        // Bind generic add-to-cart/wishlist on any page
        $(document).on('click', '.add-to-cart', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToCart($(this).attr('data-id'), 1);
        });
        $(document).on('click', '.add-to-wishlist', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToWishlist($(this).attr('data-id'));
        });
        $(document).on('click', '.add-to-compare', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToCompare($(this).attr('data-id'));
        });
    });
})();

