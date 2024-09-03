# Define the output file
$outputFile = "$PSScriptRoot\dist\output.txt"

# Create the dist directory if it doesn't exist
New-Item -ItemType Directory -Force -Path "$PSScriptRoot\dist" | Out-Null

# Clear the output file if it exists, or create it if it doesn't
"" | Set-Content $outputFile

# Function to process files
function Process-File($file) {
    "" | Add-Content $outputFile
    "this is the file named $($file.FullName) and this is the content" | Add-Content $outputFile
    "" | Add-Content $outputFile

    # Check if the file extension is .svelte, .html, .css, or .js
    $codeFileExtensions = @(".svelte", ".html", ".css", ".js")
    if ($codeFileExtensions -contains $file.Extension) {
        # Add opening code fence with the file extension (without the dot)
        "``````$($file.Extension.TrimStart('.'))" | Add-Content $outputFile
        Get-Content $file.FullName | Add-Content $outputFile
        # Add closing code fence
        "``````" | Add-Content $outputFile
    } else {
        # For other file types, just add the content without code fences
        Get-Content $file.FullName | Add-Content $outputFile
    }

    "" | Add-Content $outputFile
    "" | Add-Content $outputFile
    "" | Add-Content $outputFile
}

# List of files to ignore
$ignoreFiles = @(
    "jsconfig.json",
    "package.json",
    "package-lock.json",
    "postcss.config.js",
    "README.md",
    "structure.ps1",
    "svelte.config.js",
    "tailwind.config.js",
    "vite.config.js",
    ".gitignore",
    "composer.lock"
)

# Find all files, excluding those in node_modules, dist, and the ignore list
Get-ChildItem -Path $PSScriptRoot -Recurse -File |
    Where-Object {
        $_.FullName -notmatch 'node_modules' -and
        $_.FullName -notmatch 'vendor' -and
        $_.FullName -notmatch '.idea' -and
        $_.FullName -notmatch '.git' -and
        $_.FullName -notmatch 'dist' -and
        $_.FullName -notmatch 'public' -and
        $_.Extension -ne '.bat' -and
        $_.Extension -ne '.ps1' -and
        $_.Name -notin $ignoreFiles
    } |
    ForEach-Object {
        Write-Host "Processing: $($_.FullName)"
        Process-File $_
    }

Write-Host "File processing complete. Output saved to $outputFile"