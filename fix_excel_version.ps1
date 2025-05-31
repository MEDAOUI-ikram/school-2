# ========================================
# CORRECTION DE LA VERSION LARAVEL EXCEL
# ========================================

Write-Host "=== SUPPRESSION DE L'ANCIENNE VERSION ===" -ForegroundColor Red

# 1. Supprimer l'ancienne version
composer remove maatwebsite/excel
composer remove barryvdh/laravel-dompdf

# 2. Nettoyer complètement
php artisan cache:clear
php artisan config:clear
composer clear-cache

# 3. Supprimer vendor pour être sûr
if (Test-Path -Path "vendor") {
    Remove-Item -Path "vendor" -Recurse -Force
}
if (Test-Path -Path "composer.lock") {
    Remove-Item -Path "composer.lock" -Force
}

Write-Host "=== INSTALLATION DE LA VERSION MODERNE ===" -ForegroundColor Green

# 4. Réinstaller tout
composer install

# 5. Installer la version moderne de Laravel Excel (3.x)
composer require "maatwebsite/excel:^3.1"

# 6. Installer DomPDF
composer require barryvdh/laravel-dompdf

# 7. Régénérer l'autoloader
composer dump-autoload

Write-Host "=== PUBLICATION DES CONFIGURATIONS ===" -ForegroundColor Green

# 8. Publier les configurations
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

Write-Host "=== VÉRIFICATION ===" -ForegroundColor Green

# 9. Vérifier les versions
Write-Host "Version de Laravel Excel :" -ForegroundColor Yellow
composer show maatwebsite/excel

Write-Host ""
Write-Host "Version de DomPDF :" -ForegroundColor Yellow
composer show barryvdh/laravel-dompdf

Write-Host "=== TERMINÉ ===" -ForegroundColor Green
