/**
 * Tour Images Finder Script
 * Opens browser tabs with search results for tour images
 * 
 * Run this in Node.js to get direct links to image search results
 */

const tours = [
    {
        name: 'Dubai City Tour',
        filename: 'dubai-city-tour.jpg',
        searches: [
            'https://pixabay.com/images/search/dubai%20city/',
            'https://www.pexels.com/search/dubai/',
            'https://unsplash.com/s/photos/dubai-city'
        ]
    },
    {
        name: 'Desert Safari',
        filename: 'desert-safari.jpg',
        searches: [
            'https://pixabay.com/images/search/desert%20safari/',
            'https://www.pexels.com/search/desert%20safari/',
            'https://unsplash.com/s/photos/desert-safari'
        ]
    },
    {
        name: 'Grand Mosque',
        filename: 'grand-mosque.jpg',
        searches: [
            'https://pixabay.com/images/search/grand%20mosque/',
            'https://www.pexels.com/search/grand%20mosque/',
            'https://unsplash.com/s/photos/sheikh-zayed-grand-mosque'
        ]
    },
    {
        name: 'Burj Al Arab',
        filename: 'burj-al-arab.jpg',
        searches: [
            'https://pixabay.com/images/search/burj%20al%20arab/',
            'https://www.pexels.com/search/burj%20al%20arab/',
            'https://unsplash.com/s/photos/burj-al-arab'
        ]
    },
    {
        name: 'Dhow Cruise',
        filename: 'dhow-cruise.jpg',
        searches: [
            'https://pixabay.com/images/search/dhow%20cruise/',
            'https://www.pexels.com/search/dhow/',
            'https://unsplash.com/s/photos/dhow-cruise'
        ]
    },
    {
        name: 'Ferrari World',
        filename: 'ferrari-world.jpg',
        searches: [
            'https://pixabay.com/images/search/ferrari%20world/',
            'https://www.pexels.com/search/ferrari%20world/',
            'https://unsplash.com/s/photos/ferrari-world'
        ]
    },
    {
        name: 'Airport Transfer',
        filename: 'airport-transfer.jpg',
        searches: [
            'https://pixabay.com/images/search/luxury%20car/',
            'https://www.pexels.com/search/luxury%20car/',
            'https://unsplash.com/s/photos/luxury-car'
        ]
    },
    {
        name: 'Customized Tour',
        filename: 'customized-tour.jpg',
        searches: [
            'https://pixabay.com/images/search/travel%20planning/',
            'https://www.pexels.com/search/travel%20planning/',
            'https://unsplash.com/s/photos/travel-planning'
        ]
    }
];

console.log('🎯 Tour Images Search Links\n');
console.log('='.repeat(60));
console.log('\nCopy and open these links in your browser to find images:\n');

tours.forEach((tour, index) => {
    console.log(`\n${index + 1}. ${tour.name}`);
    console.log(`   Filename: ${tour.filename}`);
    console.log(`   Search Links:`);
    tour.searches.forEach((url, i) => {
        const site = url.includes('pixabay') ? 'Pixabay' : 
                    url.includes('pexels') ? 'Pexels' : 'Unsplash';
        console.log(`   ${i + 1}. ${site}: ${url}`);
    });
});

console.log('\n' + '='.repeat(60));
console.log('\n📋 Instructions:');
console.log('1. Open the links above in your browser');
console.log('2. Search for high-quality, free images');
console.log('3. Download images (1200x675px recommended)');
console.log('4. Save to: assets/images/tours/');
console.log('5. Use exact filenames listed above');
console.log('6. Run: npm run convert-images (to create WebP versions)');
console.log('\n✅ All images should be free for commercial use!');


