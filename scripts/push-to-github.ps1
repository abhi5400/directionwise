# Quick script to push to GitHub
param(
    [Parameter(Mandatory=$true)]
    [string]$GitHubUsername
)

Write-Host "Adding GitHub remote..." -ForegroundColor Yellow
git remote add origin "https://github.com/$GitHubUsername/directionwise.git"

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Remote added successfully" -ForegroundColor Green
} else {
    Write-Host "⚠️  Remote might already exist. Continuing..." -ForegroundColor Yellow
    git remote set-url origin "https://github.com/$GitHubUsername/directionwise.git"
}

Write-Host ""
Write-Host "Pushing to GitHub..." -ForegroundColor Yellow
git push -u origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "✅ Successfully pushed to GitHub!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Cyan
    Write-Host "1. Go to: https://github.com/$GitHubUsername/directionwise" -ForegroundColor White
    Write-Host "2. Click Settings > Pages" -ForegroundColor White
    Write-Host "3. Under Source, select 'GitHub Actions'" -ForegroundColor White
    Write-Host "4. Your site will deploy automatically!" -ForegroundColor White
    Write-Host ""
    Write-Host "Your site will be available at:" -ForegroundColor Cyan
    Write-Host "https://$GitHubUsername.github.io/directionwise" -ForegroundColor Green
} else {
    Write-Host ""
    Write-Host "✗ Failed to push. Make sure:" -ForegroundColor Red
    Write-Host "  - You have a GitHub repository named 'directionwise'" -ForegroundColor Yellow
    Write-Host "  - You're authenticated with GitHub (use GitHub Desktop or configure Git credentials)" -ForegroundColor Yellow
}

