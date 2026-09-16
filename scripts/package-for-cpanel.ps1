Param()

Set-Location -Path (Split-Path -Parent $MyInvocation.MyCommand.Definition)
Set-Location ..\

Write-Host 'Running composer install inside composer container...'
docker compose run --rm composer install --no-interaction --prefer-dist --optimize-autoloader

Write-Host 'Running artisan cache commands inside app container...'
try {
    docker compose run --rm app php artisan key:generate --force
} catch {
    Write-Host 'key generate command failed or key already exists'
}
try {
    docker compose run --rm app php artisan cache:clear
} catch {
    Write-Host 'cache:clear failed'
}
try {
    docker compose run --rm app php artisan config:cache
} catch {
    Write-Host 'config:cache failed'
}
try {
    docker compose run --rm app php artisan route:cache
} catch {
    Write-Host 'route:cache failed'
}
try {
    docker compose run --rm app php artisan view:cache
} catch {
    Write-Host 'view:cache failed'
}

$releaseDir = Join-Path -Path (Get-Location) -ChildPath 'release'
if (Test-Path $releaseDir) { Remove-Item -Recurse -Force $releaseDir }
New-Item -ItemType Directory -Path $releaseDir | Out-Null

$exclude = @('.git', 'docker', 'docker-compose.yml', 'Dockerfile', 'docker\', '.env', 'node_modules', 'tests', 'storage', 'vendor/*/.gitkeep')

Write-Host 'Copying project files to release folder (excluding common dev files)...'
Get-ChildItem -Force -Recurse | Where-Object {
    $p = $_.FullName.Replace((Get-Location).Path + '\\','')
    foreach ($e in $exclude) { if ($p -like "$e*" ) { return $false } }
    return $true
} | Copy-Item -Destination $releaseDir -Recurse -Force -Container

Write-Host 'Including vendor folder (if present)...'
if (Test-Path vendor) { Copy-Item -Path vendor -Destination $releaseDir -Recurse -Force }

$zipPath = Join-Path -Path (Get-Location) -ChildPath 'varen-cpanel-release.zip'
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

Write-Host "Creating ZIP: $zipPath"
Compress-Archive -Path (Join-Path $releaseDir '*') -DestinationPath $zipPath -Force

Write-Host 'Cleaning up temporary release folder'
Remove-Item -Recurse -Force $releaseDir

Write-Host "Release package ready: $zipPath"
