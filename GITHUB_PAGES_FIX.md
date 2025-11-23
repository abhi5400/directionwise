# Fix GitHub Pages Configuration

Your site is live but showing the README instead of the website. Here's how to fix it:

## Quick Fix

1. **Go to your repository**: https://github.com/abhi5400/directionwise
2. **Click "Settings"** (top menu)
3. **Click "Pages"** (left sidebar)
4. **Under "Source"**, you'll see one of these:
   - If it says "Deploy from a branch" → Change it to **"GitHub Actions"**
   - If it already says "GitHub Actions" → The workflow might not have run yet

5. **Check GitHub Actions**:
   - Click the **"Actions"** tab in your repository
   - You should see a workflow called "Deploy to GitHub Pages"
   - If it shows "No workflow runs", the workflow hasn't triggered yet
   - If it shows a run, click on it to see if it succeeded or failed

## If Workflow Hasn't Run

The workflow should run automatically when you push to `main`. If it hasn't:

1. Go to **Actions** tab
2. Click **"Deploy to GitHub Pages"** workflow
3. Click **"Run workflow"** button (top right)
4. Select **"main"** branch
5. Click **"Run workflow"**

## If Workflow Failed

Check the workflow logs to see what went wrong. Common issues:
- PHP version mismatch
- Missing dependencies
- Path issues

## After Fixing

Once the workflow completes successfully:
- Your site will be at: https://abhi5400.github.io/directionwise
- It should show the actual website (home page with hero, tours, etc.)
- Not the README file

## Manual Alternative

If GitHub Actions doesn't work, you can manually deploy:

1. Generate static site locally:
   ```bash
   php scripts/generate-static-site.php
   ```

2. Create and push to gh-pages branch:
   ```bash
   git checkout -b gh-pages
   git rm -rf .
   git clean -fxd
   cp -r gh-pages/* .
   git add .
   git commit -m "Deploy static site"
   git push origin gh-pages
   git checkout main
   ```

3. In Settings > Pages, select "Deploy from a branch" → "gh-pages" → "/ (root)"

