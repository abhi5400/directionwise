# PowerShell script to download tour images
$toursDir = "assets/images/tours"
if (-not (Test-Path $toursDir)) {
    New-Item -ItemType Directory -Path $toursDir -Force | Out-Null
}

Write-Host "Downloading tour images..." -ForegroundColor Cyan

function Download-Image {
    param([string]$Url, [string]$OutputPath)
    try {
        Invoke-WebRequest -Uri $Url -OutFile $OutputPath -ErrorAction Stop | Out-Null
        Write-Host "Downloaded: $OutputPath" -ForegroundColor Green
        return $true
    }
    catch {
        Write-Host "Failed: $OutputPath" -ForegroundColor Red
        return $false
    }
}

$images = @(
    @{Name="dubai-city-tour.jpg"; Url="https://picsum.photos/1200/675?random=1"; Desc="Dubai City Tour"},
    @{Name="desert-safari.jpg"; Url="https://picsum.photos/1200/675?random=2"; Desc="Desert Safari"},
    @{Name="grand-mosque.jpg"; Url="https://picsum.photos/1200/675?random=3"; Desc="Grand Mosque"},
    @{Name="burj-al-arab.jpg"; Url="https://picsum.photos/1200/675?random=4"; Desc="Burj Al Arab"},
    @{Name="dhow-cruise.jpg"; Url="https://picsum.photos/1200/675?random=5"; Desc="Dhow Cruise"},
    @{Name="ferrari-world.jpg"; Url="https://picsum.photos/1200/675?random=6"; Desc="Ferrari World"},
    @{Name="airport-transfer.jpg"; Url="https://picsum.photos/1200/675?random=7"; Desc="Airport Transfer"},
    @{Name="customized-tour.jpg"; Url="https://picsum.photos/1200/675?random=8"; Desc="Customized Tour"}
)

foreach ($img in $images) {
    $outputPath = Join-Path $toursDir $img.Name
    Write-Host "Downloading $($img.Desc)..." -ForegroundColor Yellow
    Download-Image -Url $img.Url -OutputPath $outputPath
    Start-Sleep -Milliseconds 500
}

Write-Host ""
Write-Host "Download complete!" -ForegroundColor Green
Write-Host "Note: These are placeholder images. Replace with actual tour images." -ForegroundColor Yellow
