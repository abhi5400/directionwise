# GitHub Pages Setup Guide

This guide will help you deploy your Direction Wise Tourism website to GitHub Pages.

## ⚠️ Important Note

GitHub Pages only serves **static files** (HTML, CSS, JavaScript). It cannot run PHP. The static site generator converts your PHP templates to static HTML files.

**Features that won't work on GitHub Pages:**
- ❌ Booking form submissions (API endpoint)
- ❌ Contact form submissions (will use mailto: instead)
- ❌ Admin panel
- ❌ Dynamic content generation

**Workarounds:**
- Contact forms can use `mailto:` links or third-party services like [Formspree](https://formspree.io)
- Booking forms can redirect to a contact page or external booking system
- All content is pre-generated, so updates require regenerating the static site

## Quick Start

### Step 1: Create GitHub Repository

1. Go to [GitHub](https://github.com) and sign in
2. Click the **+** icon in the top right → **New repository**
3. Name it `directionwise` (or your preferred name)
4. Choose **Public** (required for free GitHub Pages)
5. **Do NOT** initialize with README, .gitignore, or license (we already have these)
6. Click **Create repository**

### Step 2: Initialize Git (if not already done)

Open PowerShell/Terminal in your project directory and run:

```bash
# Check if Git is initialized
git status

# If not initialized, run:
git init
git add .
git commit -m "Initial commit - Direction Wise Tourism website"
```

### Step 3: Connect to GitHub and Push

```bash
# Replace YOUR_USERNAME with your GitHub username
git remote add origin https://github.com/YOUR_USERNAME/directionwise.git
git branch -M main
git push -u origin main
```

### Step 4: Enable GitHub Pages

1. Go to your repository on GitHub
2. Click **Settings** (top menu)
3. Scroll down to **Pages** (left sidebar)
4. Under **Source**, select:
   - **Deploy from a branch**: `gh-pages` branch, `/ (root)` folder
   - OR **GitHub Actions** (recommended - automated deployment)
5. Click **Save**

### Step 5: Automated Deployment (Recommended)

The repository includes a GitHub Actions workflow that automatically:
- Generates the static site when you push to `main`
- Updates the base URL automatically
- Deploys to GitHub Pages

**Just push to main and it will deploy automatically!**

```bash
# Make any changes to your site
git add .
git commit -m "Update website content"
git push origin main
```

The workflow will run automatically and deploy your site in a few minutes.

## Manual Deployment (Alternative)

If you prefer manual deployment:

### 1. Generate Static Site

```bash
php scripts/generate-static-site.php
```

### 2. Update Base URL

Before generating, update the base URL in `scripts/generate-static-site.php`:

```php
$baseUrl = 'https://YOUR_USERNAME.github.io/directionwise';
```

Replace `YOUR_USERNAME` with your GitHub username.

### 3. Deploy to gh-pages Branch

```bash
# Create and switch to gh-pages branch
git checkout -b gh-pages

# Remove all files except gh-pages content
git rm -rf .
git clean -fxd

# Copy static site files to root
cp -r gh-pages/* .

# Commit and push
git add .
git commit -m "Deploy static site to GitHub Pages"
git push origin gh-pages

# Switch back to main branch
git checkout main
```

## Your Site URL

After deployment, your site will be available at:

```
https://YOUR_USERNAME.github.io/directionwise
```

Replace `YOUR_USERNAME` with your GitHub username.

## Updating Your Site

### With Automated Deployment (Recommended)

1. Make changes to your PHP files, views, or data
2. Commit and push:
   ```bash
   git add .
   git commit -m "Update site content"
   git push origin main
   ```
3. GitHub Actions will automatically regenerate and deploy

### With Manual Deployment

1. Make changes to your PHP files, views, or data
2. Regenerate static site:
   ```bash
   php scripts/generate-static-site.php
   ```
3. Follow the manual deployment steps above

## Custom Domain (Optional)

To use a custom domain (e.g., `directionwisetourism.com`):

1. Add a `CNAME` file in the `gh-pages` directory:
   ```
   directionwisetourism.com
   ```

2. Update DNS settings with your domain provider:
   - Add a `CNAME` record pointing to `YOUR_USERNAME.github.io`

3. Enable custom domain in GitHub Pages settings:
   - Go to repository **Settings** > **Pages**
   - Enter your custom domain
   - Click **Save**

## Troubleshooting

### Images Not Loading

- Check that asset paths are relative (not absolute)
- Ensure all images are in the `assets` directory
- Verify images were copied to `gh-pages/assets/`

### Links Not Working

- Internal links should use `.html` extension (e.g., `about.html`)
- The static site generator automatically fixes most links

### 404 Errors

- Ensure all pages are generated in the `gh-pages` directory
- Check that file names match the links
- Verify the base URL is correct

### GitHub Actions Failing

- Check the **Actions** tab in your repository
- Review the workflow logs for errors
- Ensure PHP is set up correctly in the workflow

### Forms Not Working

- Booking and contact forms are disabled on the static site
- Use third-party services like [Formspree](https://formspree.io) for form submissions
- Or use `mailto:` links for contact

## Need Help?

- Check GitHub Actions logs (if using automated deployment)
- Verify the `gh-pages` directory contains all files
- Ensure the base URL is correct
- Review the generated HTML files for issues

## Next Steps

1. ✅ Push your code to GitHub
2. ✅ Enable GitHub Pages in repository settings
3. ✅ Wait for deployment (automatic with GitHub Actions)
4. ✅ Visit your site at `https://YOUR_USERNAME.github.io/directionwise`
5. ✅ Share your site with others!

---

**Note:** The static site is automatically generated from your PHP templates. To update content, edit the PHP files and regenerate the static site (or let GitHub Actions do it automatically).

