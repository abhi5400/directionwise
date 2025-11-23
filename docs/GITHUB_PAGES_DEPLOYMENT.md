# GitHub Pages Deployment Guide

This guide explains how to deploy the Direction Wise Tourism website to GitHub Pages.

## ⚠️ Important Note

**GitHub Pages only serves static files (HTML, CSS, JavaScript).** It cannot run PHP. This guide shows you how to generate a static version of your site for GitHub Pages.

## Prerequisites

1. A GitHub account
2. Git installed on your computer
3. PHP 8.0+ installed (for generating the static site)

## Step 1: Generate Static Site

1. **Update the base URL** in `scripts/generate-static-site.php`:
   ```php
   $baseUrl = 'https://YOUR_USERNAME.github.io/directionwise';
   ```
   Replace `YOUR_USERNAME` with your GitHub username.

2. **Run the static site generator**:
   ```bash
   php scripts/generate-static-site.php
   ```

3. This will create a `gh-pages` directory with all static HTML files.

## Step 2: Initialize Git Repository (if not already done)

```bash
git init
git add .
git commit -m "Initial commit"
```

## Step 3: Create GitHub Repository

1. Go to [GitHub](https://github.com) and create a new repository
2. Name it `directionwise` (or your preferred name)
3. **Do NOT initialize with README** (if you already have files)

## Step 4: Push to GitHub

```bash
git remote add origin https://github.com/YOUR_USERNAME/directionwise.git
git branch -M main
git push -u origin main
```

## Step 5: Deploy to GitHub Pages

### Option A: Manual Deployment

1. **Generate the static site** (if you haven't already):
   ```bash
   php scripts/generate-static-site.php
   ```

2. **Create and switch to gh-pages branch**:
   ```bash
   git checkout -b gh-pages
   git rm -rf .
   git clean -fxd
   cp -r gh-pages/* .
   git add .
   git commit -m "Deploy to GitHub Pages"
   git push origin gh-pages
   git checkout main
   ```

3. **Enable GitHub Pages**:
   - Go to your repository on GitHub
   - Click **Settings** > **Pages**
   - Under "Source", select **gh-pages branch**
   - Click **Save**

4. Your site will be available at:
   ```
   https://YOUR_USERNAME.github.io/directionwise
   ```

### Option B: Automated Deployment (Recommended)

The repository includes a GitHub Actions workflow that automatically generates and deploys the static site.

1. **The workflow is already configured** in `.github/workflows/deploy-gh-pages.yml`

2. **Just push to main branch**:
   ```bash
   git push origin main
   ```

3. **Enable GitHub Pages**:
   - Go to your repository on GitHub
   - Click **Settings** > **Pages**
   - Under "Source", select **GitHub Actions**
   - The workflow will automatically deploy on every push to main

## Step 6: Update Base URL

After your site is live, update the base URL in `scripts/generate-static-site.php` with your actual GitHub Pages URL, then regenerate:

```bash
php scripts/generate-static-site.php
git add gh-pages
git commit -m "Update static site with correct base URL"
git push
```

## Limitations of Static Site

Since GitHub Pages doesn't support PHP, the following features will **NOT work**:

- ❌ Booking form submissions (API endpoint)
- ❌ Contact form submissions (will use mailto: instead)
- ❌ Admin panel
- ❌ Dynamic content generation

**Workarounds:**
- Contact forms can use `mailto:` links or third-party services like Formspree
- Booking forms can redirect to a contact page or external booking system
- All content is pre-generated, so updates require regenerating the static site

## Updating the Site

Whenever you make changes:

1. **Update your PHP files** (views, data, etc.)
2. **Regenerate the static site**:
   ```bash
   php scripts/generate-static-site.php
   ```
3. **Commit and push**:
   ```bash
   git add .
   git commit -m "Update site content"
   git push
   ```

If using GitHub Actions, the site will automatically redeploy.

## Custom Domain (Optional)

To use a custom domain:

1. Add a `CNAME` file in the `gh-pages` directory:
   ```
   yourdomain.com
   ```

2. Update DNS settings with your domain provider
3. Enable custom domain in GitHub Pages settings

## Troubleshooting

### Images not loading
- Check that asset paths are relative (not absolute)
- Ensure all images are in the `assets` directory

### Links not working
- Internal links should use `.html` extension (e.g., `about.html`)
- Update the static site generator if links are broken

### 404 errors
- Ensure all pages are generated in the `gh-pages` directory
- Check that file names match the links

## Need Help?

If you encounter issues:
1. Check GitHub Actions logs (if using automated deployment)
2. Verify the `gh-pages` directory contains all files
3. Ensure the base URL is correct in the generator script

