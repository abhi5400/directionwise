# Quick setup script for GitHub Pages deployment
# This script helps you prepare your project for GitHub Pages

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "GitHub Pages Setup Helper" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if Git is initialized
if (-not (Test-Path ".git")) {
    Write-Host "Initializing Git repository..." -ForegroundColor Yellow
    git init
    Write-Host "✓ Git initialized" -ForegroundColor Green
} else {
    Write-Host "✓ Git already initialized" -ForegroundColor Green
}

# Check if remote is set
$remote = git remote get-url origin 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "⚠️  No GitHub remote configured yet." -ForegroundColor Yellow
    Write-Host ""
    $username = Read-Host "Enter your GitHub username"
    $repoName = Read-Host "Enter your repository name (default: directionwise)"
    if ([string]::IsNullOrWhiteSpace($repoName)) {
        $repoName = "directionwise"
    }
    
    Write-Host ""
    Write-Host "Adding GitHub remote..." -ForegroundColor Yellow
    git remote add origin "https://github.com/$username/$repoName.git"
    Write-Host "✓ Remote added: https://github.com/$username/$repoName.git" -ForegroundColor Green
} else {
    Write-Host "✓ GitHub remote configured: $remote" -ForegroundColor Green
}

# Generate static site
Write-Host ""
Write-Host "Generating static site..." -ForegroundColor Yellow
php scripts/generate-static-site.php

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Static site generated successfully!" -ForegroundColor Green
} else {
    Write-Host "✗ Failed to generate static site" -ForegroundColor Red
    exit 1
}

# Check if files are committed
$status = git status --porcelain
if ($status) {
    Write-Host ""
    Write-Host "⚠️  You have uncommitted changes." -ForegroundColor Yellow
    Write-Host ""
    $commit = Read-Host "Would you like to commit and push now? (y/n)"
    if ($commit -eq "y" -or $commit -eq "Y") {
        Write-Host ""
        Write-Host "Staging files..." -ForegroundColor Yellow
        git add .
        
        $message = Read-Host "Enter commit message (default: Initial commit)"
        if ([string]::IsNullOrWhiteSpace($message)) {
            $message = "Initial commit"
        }
        
        Write-Host "Committing..." -ForegroundColor Yellow
        git commit -m $message
        
        Write-Host ""
        Write-Host "Pushing to GitHub..." -ForegroundColor Yellow
        git branch -M main
        git push -u origin main
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host ""
            Write-Host "✅ Successfully pushed to GitHub!" -ForegroundColor Green
            Write-Host ""
            Write-Host "Next steps:" -ForegroundColor Cyan
            Write-Host "1. Go to your repository on GitHub" -ForegroundColor White
            Write-Host "2. Click Settings > Pages" -ForegroundColor White
            Write-Host "3. Under Source, select 'GitHub Actions'" -ForegroundColor White
            Write-Host "4. Your site will deploy automatically!" -ForegroundColor White
        } else {
            Write-Host "✗ Failed to push to GitHub" -ForegroundColor Red
            Write-Host "Make sure you have a GitHub repository created first." -ForegroundColor Yellow
        }
    }
} else {
    Write-Host ""
    Write-Host "✓ All files are committed" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "📖 For detailed instructions, see: GITHUB_PAGES_SETUP.md" -ForegroundColor Cyan
Write-Host ""

