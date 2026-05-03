/* AutoDeal Frontend App (jQuery + localStorage) */
(function () {
    const STORE_KEYS = {
        CART: 'autodeal_cart',
        WISHLIST: 'autodeal_wishlist',
        COMPARE: 'autodeal_compare',
        USER: 'autodeal_user',
        COUPON: 'autodeal_coupon',
        RECENT: 'autodeal_recent'
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

        const coupon = getCoupon();
        let discount = 0;
        if (coupon && COUPONS[coupon]) {
            if (COUPONS[coupon].type === 'percent') {
                discount = subtotal * COUPONS[coupon].val;
            } else if (COUPONS[coupon].type === 'fixed') {
                discount = Math.min(subtotal, COUPONS[coupon].val);
            }
        }
        
        const afterDiscount = subtotal - discount;
        const tax = Math.round(afterDiscount * 0.08);
        const total = afterDiscount + tax;
        return { items, subtotal, discount, tax, total, coupon };
    }

    // Coupons
    const COUPONS = {
        'SAVE10': { type: 'percent', val: 0.10 },
        'MINUS500': { type: 'fixed', val: 500 }
    };
    function getCoupon() { return readStore(STORE_KEYS.COUPON, null); }
    function setCoupon(c) { writeStore(STORE_KEYS.COUPON, c); }

    // Recently Viewed
    function getRecent() { return readStore(STORE_KEYS.RECENT, []); }
    function addRecent(id) {
        let list = getRecent().filter(x => x !== id);
        list.unshift(id);
        writeStore(STORE_KEYS.RECENT, list.slice(0, 4));
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
            // Quick View
            if ($card.find('.quick-view-btn').length === 0) {
                $('<button class="btn btn-outline quick-view-btn" style="width:100%; margin-top:0.5rem;">Quick View</button>').attr('data-id', id).insertBefore($card.find('.card-actions'));
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
                if (matchesFilters($card)) {
                    $card.stop(true, true).fadeIn(300);
                } else {
                    $card.stop(true, true).fadeOut(300);
                }
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
            
            // Handle discount row
            if (t.discount > 0) {
                if ($('#summary-discount-row').length === 0) {
                    $('<div class="summary-row" id="summary-discount-row"><span>Discount (' + t.coupon + ')</span><span class="text-primary">-$' + t.discount.toLocaleString() + '</span></div>').insertAfter($('#summary-items').parent());
                } else {
                    $('#summary-discount-row').html('<span>Discount (' + t.coupon + ')</span><span class="text-primary">-$' + t.discount.toLocaleString() + '</span>');
                }
            } else {
                $('#summary-discount-row').remove();
            }

            $('#summary-tax').text(`$${t.tax.toLocaleString()}`);
            $('#summary-total').text(`$${t.total.toLocaleString()}`);
            updateBadges();

            // Setup coupon UI if not present
            if ($('#coupon-section').length === 0) {
                const couponHtml = `
                    <div id="coupon-section" class="mt-1 mb-1">
                        <div style="display:flex; gap:0.5rem;">
                            <input type="text" id="coupon-input" placeholder="Promo code" class="form-control" style="flex:1;">
                            <button id="apply-coupon-btn" class="btn btn-secondary">Apply</button>
                        </div>
                        <p id="coupon-msg" class="text-light mt-05" style="font-size:0.85rem;"></p>
                    </div>
                `;
                $(couponHtml).insertBefore($('.summary-row').first().parent().find('.mt-2').first());
            }

            // Sync coupon input value if active
            if (t.coupon) {
                $('#coupon-input').val(t.coupon).prop('disabled', true);
                $('#apply-coupon-btn').text('Remove').addClass('remove-mode');
            } else {
                $('#coupon-input').val('').prop('disabled', false);
                $('#apply-coupon-btn').text('Apply').removeClass('remove-mode');
            }
        }
        refreshSummary();

        // Coupon events
        $(document).on('click', '#apply-coupon-btn', function() {
            if ($(this).hasClass('remove-mode')) {
                setCoupon(null);
                $('#coupon-msg').text('Coupon removed.').css('color', '');
            } else {
                const code = $('#coupon-input').val().trim().toUpperCase();
                if (COUPONS[code]) {
                    setCoupon(code);
                    $('#coupon-msg').text('Coupon applied successfully!').css('color', 'green');
                } else {
                    $('#coupon-msg').text('Invalid coupon code.').css('color', 'red');
                }
            }
            refreshSummary();
        });

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
            
            <!-- Recently Viewed Section -->
            <div id="recently-viewed-container" style="margin-top: 4rem;"></div>
        `);

        // Track and Display Recently Viewed
        addRecent(p.id);
        const recentIds = getRecent().filter(rid => rid !== p.id); // don't show current item
        if (recentIds.length > 0) {
            let recentHtml = '<h3 class="section-title" style="margin-bottom: 2rem; font-size: 1.8rem;">Recently <span>Viewed</span></h3><div class="cards-grid">';
            recentIds.forEach(rid => {
                const rp = getProductById(rid);
                if (rp) {
                    recentHtml += `
                        <div class="card" data-id="${rp.id}">
                            <div class="card-image">
                                <img src="${rp.image}" alt="${rp.name}" class="card-image-img">
                            </div>
                            <div class="card-content">
                                <h3 class="card-title">${rp.name}</h3>
                                <p class="card-price">$${rp.price.toLocaleString()}</p>
                                <div class="card-actions mt-1">
                                    <a class="btn btn-secondary view-details" href="product.html?id=${rp.id}" style="width:100%; text-align:center;">View Details</a>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            recentHtml += '</div>';
            $('#recently-viewed-container').html(recentHtml);
        }
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

    function initContactPage() {
        $('form').on('submit', function (e) {
            e.preventDefault();
            const name = $('#name').val().trim();
            const email = $('#email').val().trim();
            const subject = $('#subject').val();
            const message = $('#message').val().trim();
            if (!name || !email || !subject || !message) return;
            
            alert('Thank you, ' + name + '! Your message regarding "' + subject + '" has been sent successfully.');
            this.reset();
        });
    }

    function initCheckoutPage() {
        const cart = getCart();
        if (cart.length === 0) {
            alert('Your cart is empty. Redirecting to products.');
            window.location.href = 'products.html';
            return;
        }
        
        // Render summary read-only
        const $list = $('#checkout-items');
        $list.empty();
        cart.forEach(item => {
            const p = getProductById(item.id);
            if (!p) return;
            $list.append(`
                <div style="display:flex; justify-content:space-between; margin-bottom: 0.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #eee;">
                    <span>${item.qty}x ${p.name}</span>
                    <span>$${(p.price * item.qty).toLocaleString()}</span>
                </div>
            `);
        });
        
        const t = cartTotals();
        let summaryHtml = `
            <div style="display:flex; justify-content:space-between; margin-top: 1rem;">
                <strong>Subtotal</strong><span>$${t.subtotal.toLocaleString()}</span>
            </div>
        `;
        if (t.discount > 0) {
            summaryHtml += `
            <div style="display:flex; justify-content:space-between; color: var(--primary-color);">
                <strong>Discount (${t.coupon})</strong><span>-$${t.discount.toLocaleString()}</span>
            </div>`;
        }
        summaryHtml += `
            <div style="display:flex; justify-content:space-between;">
                <strong>Tax (8%)</strong><span>$${t.tax.toLocaleString()}</span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-top: 1rem; font-size: 1.25rem; border-top: 2px solid #ccc; padding-top: 0.5rem;">
                <strong>Total</strong><strong class="text-primary">$${t.total.toLocaleString()}</strong>
            </div>
        `;
        $('#checkout-summary-totals').html(summaryHtml);

        // Handle submission
        $('#checkout-form').on('submit', function (e) {
            e.preventDefault();
            alert('Order placed successfully! Thank you for choosing AutoDeal.');
            setCart([]);
            setCoupon(null);
            window.location.href = 'index.html';
        });
    }

    // --- Animations and UI Enhancements ---

    // 1. Add to Cart Animation
    function animateAddToCart($btn) {
        const $cartIcon = $('.nav-actions a[href="cart.html"]');
        if ($cartIcon.length === 0) return;

        // Fly-to-cart animation
        const srcImg = $btn.closest('.card').find('img.card-image-img').attr('src') || $btn.closest('.grid-auto-400-gap-3').find('img').attr('src');
        if (srcImg) {
            const $flyImg = $('<img/>').attr('src', srcImg).css({
                position: 'absolute',
                top: $btn.offset().top,
                left: $btn.offset().left,
                width: '50px',
                height: '50px',
                borderRadius: '50%',
                objectFit: 'cover',
                zIndex: 9999,
                opacity: 0.8
            }).appendTo('body');

            $flyImg.animate({
                top: $cartIcon.offset().top,
                left: $cartIcon.offset().left,
                width: 20,
                height: 20,
                opacity: 0
            }, 600, 'swing', function() {
                $(this).remove();
                // Pop the cart icon
                $cartIcon.css('transform', 'scale(1.2)');
                setTimeout(() => $cartIcon.css('transform', 'scale(1)'), 200);
            });
        }
    }

    // 2. Quick View Modal
    function injectQuickViewModal() {
        if ($('#quick-view-modal').length > 0) return;
        const modalHtml = `
            <div id="quick-view-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:10000; justify-content:center; align-items:center;">
                <div style="background:#fff; width:90%; max-width:600px; border-radius:12px; padding:2rem; position:relative; animation: slideIn 0.3s ease-out;">
                    <button id="close-quick-view" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                    <div id="quick-view-content" style="display:flex; gap:1.5rem; align-items:center; flex-wrap:wrap;"></div>
                </div>
            </div>
            <style>
                @keyframes slideIn { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
            </style>
        `;
        $('body').append(modalHtml);

        $('#close-quick-view, #quick-view-modal').on('click', function(e) {
            if (e.target === this) $('#quick-view-modal').fadeOut();
        });
    }

    // 3. Back to Top Button
    function injectBackToTop() {
        if ($('#back-to-top').length > 0) return;
        const btnHtml = `
            <button id="back-to-top" style="display:none; position:fixed; bottom:2rem; right:2rem; width:50px; height:50px; border-radius:50%; background:var(--primary-color); color:#fff; border:none; font-size:1.5rem; cursor:pointer; z-index:9000; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: transform 0.2s;">
                &#8679;
            </button>
        `;
        $('body').append(btnHtml);

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });

        $('#back-to-top').on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 500);
        });

        $('#back-to-top').hover(function(){ $(this).css('transform', 'translateY(-5px)'); }, function(){ $(this).css('transform', 'translateY(0)'); });
    }

    // Global init
    $(function () {
        updateBadges();
        updateUserUI();
        
        injectQuickViewModal();
        injectBackToTop();

        const path = location.pathname.toLowerCase();
        if (path.endsWith('/products.html')) initProductsPage();
        if (path.endsWith('/cart.html')) initCartPage();
        if (path.endsWith('/wishlist.html')) initWishlistPage();
        if (path.endsWith('/comparison.html')) initComparePage();
        if (path.endsWith('/product.html')) initProductDetailsPage();
        if (path.endsWith('/login.html')) initLoginPage();
        if (path.endsWith('/signup.html')) initSignupPage();
        if (path.endsWith('/contact.html')) initContactPage();
        if (path.endsWith('/checkout.html')) initCheckoutPage();

        // Bind generic add-to-cart/wishlist on any page
        $(document).on('click', '.add-to-cart', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToCart($(this).attr('data-id'), 1);
            animateAddToCart($(this));
        });
        $(document).on('click', '.add-to-wishlist', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToWishlist($(this).attr('data-id'));
        });
        $(document).on('click', '.add-to-compare', function (e) {
            if ($(this).is('a')) e.preventDefault();
            addToCompare($(this).attr('data-id'));
            alert('Added to comparison (max 3).');
        });

        // Quick View Event
        $(document).on('click', '.quick-view-btn', function (e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            const p = getProductById(id);
            if (!p) return;
            
            $('#quick-view-content').html(`
                <div style="flex:1; min-width:200px;">
                    <img src="${p.image}" style="width:100%; border-radius:8px; object-fit:cover;">
                </div>
                <div style="flex:1; min-width:200px;">
                    <h2 class="fs-3 text-dark mb-1">${p.name}</h2>
                    <p class="fs-2 text-primary mb-1">$${p.price.toLocaleString()}</p>
                    <p class="text-light mb-1">${p.year} | ${p.type.toUpperCase()} | ${p.condition.toUpperCase()}</p>
                    <button class="btn btn-primary add-to-cart btn-full" data-id="${p.id}">Add to Cart</button>
                    <a href="product.html?id=${p.id}" class="btn btn-outline btn-full mt-1">Full Details</a>
                </div>
            `);
            $('#quick-view-modal').css('display', 'flex').hide().fadeIn();
        });
    });
})();

