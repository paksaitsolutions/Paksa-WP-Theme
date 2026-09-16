Add-Type -Assembly 'System.IO.Compression'
Add-Type -Assembly 'System.IO.Compression.FileSystem'

$zipPath  = Join-Path $PSScriptRoot 'paksa-it-solutions-theme.zip'
$themeDir = Join-Path $PSScriptRoot 'paksa-it-solutions'
$prefix   = 'paksa-it-solutions/'

$excludeDirs  = @('.git','.github','.kilo','.kilocode','node_modules','vendor')
$excludeFiles = @('.gitignore','.DS_Store','Thumbs.db')
$excludeExts  = @('.zip')

if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

$fsOut = New-Object System.IO.FileStream($zipPath,
    [System.IO.FileMode]::Create,
    [System.IO.FileAccess]::Write,
    [System.IO.FileShare]::None)

$zip = New-Object System.IO.Compression.ZipArchive(
    $fsOut,
    [System.IO.Compression.ZipArchiveMode]::Create,
    $false)   # leaveOpen = false

$count = 0
$files = Get-ChildItem -Path $themeDir -Recurse -File
foreach ($file in $files) {
    $rel  = $file.FullName.Substring($themeDir.Length + 1).Replace('\','/')
    $skip = $false
    foreach ($d in $excludeDirs) {
        if ($rel -like ($d + '/*') -or $rel -eq $d) { $skip = $true; break }
    }
    if ($excludeFiles -contains $file.Name) { $skip = $true }
    if ($excludeExts  -contains $file.Extension) { $skip = $true }
    if ($skip) { continue }

    $entryName   = $prefix + $rel
    $entry       = $zip.CreateEntry($entryName, [System.IO.Compression.CompressionLevel]::Optimal)
    $entryStream = $entry.Open()
    $fileStream  = New-Object System.IO.FileStream($file.FullName,
        [System.IO.FileMode]::Open,
        [System.IO.FileAccess]::Read,
        [System.IO.FileShare]::Read)
    $fileStream.CopyTo($entryStream)
    $fileStream.Dispose()
    $entryStream.Dispose()
    $count++
}

$zip.Dispose()

$info = Get-Item $zipPath
[Console]::WriteLine('ZIP: ' + $info.Name + ' - ' + [math]::Round($info.Length / 1KB) + ' KB, ' + $count + ' files added')

$z = [System.IO.Compression.ZipFile]::OpenRead($zipPath)
[Console]::WriteLine('Entries in ZIP: ' + $z.Entries.Count)

$checks = @(
    'paksa-it-solutions/style.css',
    'paksa-it-solutions/functions.php',
    'paksa-it-solutions/inc/updater.php',
    'paksa-it-solutions/patterns/services-categories.php',
    'paksa-it-solutions/patterns/services-features.php',
    'paksa-it-solutions/patterns/services-process.php',
    'paksa-it-solutions/patterns/services-stats.php'
)
foreach ($c in $checks) {
    $found = $z.Entries | Where-Object { $_.FullName -eq $c }
    if ($found) { [Console]::WriteLine('  OK      ' + $c) }
    else        { [Console]::WriteLine('  MISSING ' + $c) }
}

$nested = $z.Entries | Where-Object { $_.FullName -like 'paksa-it-solutions/paksa-it-solutions/*' }
if ($nested) { [Console]::WriteLine('  ERROR: nested directory') }
else         { [Console]::WriteLine('  OK      No nested directory') }

$z.Dispose()
[Console]::WriteLine('Done.')
