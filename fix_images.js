const fs = require('fs');
const path = require('path');

const dir = 'c:\\Users\\sparsh\\car-dealership';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    let p = path.join(dir, file);
    let content = fs.readFileSync(p, 'utf8');
    
    // We want to match:
    // <img class="card-image-img" src="images/..." ...>
    // <div class="card-content">
    //     <h3 class="card-title">2024 Electric Car</h3>
    
    // The exact structure is:
    // <img class="card-image-img" src="images/sedan.jpg" alt="Vehicle" style="width: 100%; height: 200px; object-fit: cover; display: block;">
    //                     <div class="card-content">
    //                         <h3 class="card-title">2024 Luxury Sedan</h3>

    const regex = /(<img class="card-image-img" src="images\/)[^"]+(".*?<h3 class="card-title">[^<]*?)(Sedan|SUV|Sports Car|Family Van|Electric Car|Compact SUV|Super Sports|Premium Sedan|Luxury SUV)(<\/h3>)/gs;

    let updatedContent = content.replace(regex, (match, p1, p2, type, p4) => {
        let newImg = 'sedan.jpg';
        if (type.includes('Electric')) newImg = 'electric.jpg';
        else if (type.includes('Compact SUV')) newImg = 'fridge.jpg'; // User explicitly said "compact suv image is called fridge"
        else if (type.includes('Family Van')) newImg = 'compact.jpg';
        else if (type.includes('SUV')) newImg = 'suv.jpg';
        else if (type.includes('Sports')) newImg = 'sports.jpg';
        else if (type.includes('Sedan')) newImg = 'sedan.jpg';
        
        return p1 + newImg + p2 + type + p4;
    });

    if (updatedContent !== content) {
        fs.writeFileSync(p, updatedContent);
        console.log(`Updated products in ${file}`);
    }
});
