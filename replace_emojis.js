const fs = require('fs');
const path = require('path');

const dir = 'c:\\Users\\sparsh\\car-dealership';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

const replacements = {
    '❤️': '<img src="images/heart_icon.png" alt="wishlist" class="emoji-icon">',
    '🛒': '<img src="images/cart_icon.png" alt="cart" class="emoji-icon">',
    '⚡': '<img src="images/engine_icon.png" alt="engine" class="emoji-icon">',
    '⛽': '<img src="images/fuel_icon.png" alt="fuel" class="emoji-icon">',
    '🛡️': '<img src="images/shield_icon.png" alt="warranty" class="emoji-icon">',
    '🎯': '<img src="images/target_icon.png" alt="feature" class="emoji-icon">',
    '🔋': '<img src="images/battery_icon.png" alt="battery" class="emoji-icon">',
    '🏆': '<img src="images/trophy_icon.png" alt="best prices" class="emoji-icon">',
    '🚀': '<img src="images/rocket_icon.png" alt="fast delivery" class="emoji-icon">',
    '💼': '<img src="images/briefcase_icon.png" alt="expert support" class="emoji-icon">',
    '📞': '<img src="images/phone_icon.png" alt="phone" class="emoji-icon">',
    '✉️': '<img src="images/email_icon.png" alt="email" class="emoji-icon">',
    '📍': '<img src="images/address_icon.png" alt="address" class="emoji-icon">',
};

files.forEach(file => {
    const p = path.join(dir, file);
    let origContent = fs.readFileSync(p, 'utf8');
    let content = origContent;
    
    // Replace all mapping emojis
    for (const [emoji, img] of Object.entries(replacements)) {
        content = content.replaceAll(emoji, img);
    }
    
    // Specifically handle the car images inside .card-image
    // Example: <div class="card-image">🚗</div>
    // We replace the outer div exactly with an img since keeping it a div with an img inside would require modifying all css sizes.
    // Or we keep it, but set font size 0 and insert img. Better just replace with <img class="card-image" src="..." alt="Vehicle">
    // But .card-image is used as a container in styles.css.
    content = content.replace(/<div class="card-image">(.*?)<\/div>/g, (match, inner) => {
        let e = inner.trim();
        let imgName = 'sedan.jpg'; // default
        if (e.includes('🚙')) imgName = 'suv.jpg';
        else if (e.includes('🏎️')) imgName = 'sports.jpg';
        else if (e.includes('🚐')) imgName = 'fridge.jpg';
        else if (e.includes('🚗')) imgName = 'sedan.jpg';
        
        if (['🚗','🚙','🏎️','🚐'].some(car => e.includes(car))) {
           return `<img class="card-image-img" src="images/${imgName}" alt="Vehicle" style="width: 100%; height: 200px; object-fit: cover; display: block;">`;
        }
        return match; // If there are no emojis, keep it
    });

    if (content !== origContent) {
        fs.writeFileSync(p, content);
        console.log(`Updated ${file}`);
    }
});
