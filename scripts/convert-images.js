/**
 * Image Conversion Script
 * Converts JPEG/PNG images to WebP and AVIF formats using sharp
 * 
 * Usage: node scripts/convert-images.js
 */

const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const SOURCE_DIR = path.join(__dirname, '../assets/images/source');
const OUTPUT_DIR = path.join(__dirname, '../assets/images/tours');
const SIZES = [
    { width: 400, suffix: 'thumb' },
    { width: 800, suffix: 'medium' },
    { width: 1200, suffix: 'large' }
];

// Ensure output directory exists
if (!fs.existsSync(OUTPUT_DIR)) {
    fs.mkdirSync(OUTPUT_DIR, { recursive: true });
}

/**
 * Convert image to WebP
 */
async function convertToWebP(inputPath, outputPath, width, quality = 75) {
    try {
        await sharp(inputPath)
            .resize(width, null, { withoutEnlargement: true })
            .webp({ quality })
            .toFile(outputPath);
        console.log(`✓ Created: ${path.basename(outputPath)}`);
        return true;
    } catch (error) {
        console.error(`✗ Error converting ${inputPath}:`, error.message);
        return false;
    }
}

/**
 * Convert image to AVIF (optional, better compression)
 */
async function convertToAVIF(inputPath, outputPath, width, quality = 75) {
    try {
        await sharp(inputPath)
            .resize(width, null, { withoutEnlargement: true })
            .avif({ quality })
            .toFile(outputPath);
        console.log(`✓ Created: ${path.basename(outputPath)}`);
        return true;
    } catch (error) {
        console.error(`✗ Error converting ${inputPath}:`, error.message);
        return false;
    }
}

/**
 * Process a single image file
 */
async function processImage(filePath) {
    const fileName = path.basename(filePath, path.extname(filePath));
    const ext = path.extname(filePath).toLowerCase();
    
    if (!['.jpg', '.jpeg', '.png'].includes(ext)) {
        console.log(`⚠ Skipping ${filePath} (not a supported format)`);
        return;
    }

    console.log(`\nProcessing: ${fileName}${ext}`);

    // Process each size
    for (const size of SIZES) {
        const webpPath = path.join(OUTPUT_DIR, `${fileName}-${size.suffix}.webp`);
        await convertToWebP(filePath, webpPath, size.width);
        
        // Also create original size WebP
        if (size.width === 1200) {
            const originalWebp = path.join(OUTPUT_DIR, `${fileName}.webp`);
            await convertToWebP(filePath, originalWebp, size.width);
        }
    }

    // Create original size JPEG (optimized)
    const optimizedJpeg = path.join(OUTPUT_DIR, `${fileName}.jpg`);
    try {
        await sharp(filePath)
            .resize(1200, null, { withoutEnlargement: true })
            .jpeg({ quality: 85, mozjpeg: true })
            .toFile(optimizedJpeg);
        console.log(`✓ Created: ${path.basename(optimizedJpeg)}`);
    } catch (error) {
        console.error(`✗ Error optimizing JPEG:`, error.message);
    }
}

/**
 * Main function
 */
async function main() {
    console.log('🖼️  Image Conversion Script');
    console.log('============================\n');

    if (!fs.existsSync(SOURCE_DIR)) {
        console.error(`✗ Source directory not found: ${SOURCE_DIR}`);
        console.log(`\nPlease create the directory and add your source images.`);
        process.exit(1);
    }

    const files = fs.readdirSync(SOURCE_DIR)
        .filter(file => /\.(jpg|jpeg|png)$/i.test(file))
        .map(file => path.join(SOURCE_DIR, file));

    if (files.length === 0) {
        console.log('⚠ No images found in source directory.');
        console.log(`\nPlace your source images in: ${SOURCE_DIR}`);
        process.exit(0);
    }

    console.log(`Found ${files.length} image(s) to process.\n`);

    for (const file of files) {
        await processImage(file);
    }

    console.log('\n✅ Image conversion complete!');
    console.log(`\nOutput directory: ${OUTPUT_DIR}`);
}

// Run the script
main().catch(error => {
    console.error('Fatal error:', error);
    process.exit(1);
});

