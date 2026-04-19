const fs = require('fs');
const path = require('path');

const dir = 'c:\\Users\\sparsh\\car-dealership';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    let p = path.join(dir, file);
    let content = fs.readFileSync(p, 'utf8');
    
    // Replace all images with class="card-image-img" to fridge.jpg
    let updatedContent = content.replace(/(<img class="card-image-img" src="images\/)[^"]+/g, '$1fridge.jpg');

    if (updatedContent !== content) {
        fs.writeFileSync(p, updatedContent);
        console.log(`Updated all vehicles to fridge.jpg in ${file}`);
    }
});
