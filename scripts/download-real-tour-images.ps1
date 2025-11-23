# Script to download actual tour images from free stock photo services
# This script uses specific image URLs that you can update with real tour images

$toursDir = "assets/images/tours"
if (-not (Test-Path $toursDir)) {
    New-Item -ItemType Directory -Path $toursDir -Force | Out-Null
}

Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host "Tour Images Downloader" -ForegroundColor Cyan
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host ""

# You can update these URLs with direct image links from:
# - Pixabay: Right-click image > Copy image address
# - Pexels: Right-click image > Copy image address  
# - Unsplash: Right-click image > Copy image address
# Or use the helper HTML page: scripts/open-image-searches.html

$imageUrls = @{
    "dubai-city-tour.jpg" = ""
    "desert-safari.jpg" = ""
    "grand-mosque.jpg" = ""
    "burj-al-arab.jpg" = ""
    "dhow-cruise.jpg" = ""
    "ferrari-world.jpg" = ""
    "airport-transfer.jpg" = ""
    "customized-tour.jpg" = ""
}

Write-Host "To download real tour images:" -ForegroundColor Yellow
Write-Host "1. Open scripts/open-image-searches.html in your browser" -ForegroundColor White
Write-Host "2. Find images you like on Pixabay, Pexels, or Unsplash" -ForegroundColor White
Write-Host "3. Right-click the image and select 'Copy image address'" -ForegroundColor White
Write-Host "4. Update the URLs in this script, then run it again" -ForegroundColor White
Write-Host ""
Write-Host "Alternatively, manually download images and save them to:" -ForegroundColor Yellow
Write-Host "  $toursDir" -ForegroundColor Cyan
Write-Host ""

$hasUrls = $false
foreach ($key in $imageUrls.Keys) {
    if ($imageUrls[$key] -ne "") {
        $hasUrls = $true
        break
    }
}

if (-not $hasUrls) {
    Write-Host "No image URLs configured yet." -ForegroundColor Red
    Write-Host "Using existing placeholder images for now." -ForegroundColor Yellow
    exit
}

function Download-Image {
    param([string]$Url, [string]$OutputPath)
    try {
        $ProgressPreference = 'SilentlyContinue'
        Invoke-WebRequest -Uri $Url -OutFile $OutputPath -ErrorAction Stop | Out-Null
        Write-Host "  Downloaded: $OutputPath" -ForegroundColor Green
        return $true
    }
    catch {
        Write-Host "  Failed: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

Write-Host "Downloading images..." -ForegroundColor Cyan
foreach ($filename in $imageUrls.Keys) {
    $url = $imageUrls[$filename]
    if ($url -ne "") {
        $outputPath = Join-Path $toursDir $filename
        Write-Host "Downloading $filename..." -ForegroundColor Yellow
        Download-Image -Url $url -OutputPath $outputPath
    }
}

Write-Host ""
Write-Host "Done!" -ForegroundColor Green


