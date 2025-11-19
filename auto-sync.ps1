<#
Kobopoint automatic Git sync script (Windows PowerShell)

What it does, safely:
- Detects origin remote and default branch (main or master)
- Stashes any uncommitted changes
- Fast-forward pulls the default branch from origin
- Merges the updated default branch into your current branch (no history rewrite)
- Restores your stash
- Pushes your current branch (sets upstream if missing)

If a merge or stash pop conflict occurs, the script will stop and tell you what to fix.
#>

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

function Exec($cmd) {
  Write-Host "`n> $cmd" -ForegroundColor Cyan
  $out = & powershell -NoProfile -Command $cmd 2>&1
  if ($LASTEXITCODE -ne 0) { throw "Command failed ($LASTEXITCODE): $cmd`n$out" }
  return $out
}

function Git($args) {
  $cmd = "git $args"
  Write-Host "`n> $cmd" -ForegroundColor Cyan
  $out = & git $args 2>&1
  if ($LASTEXITCODE -ne 0) { throw "Git failed ($LASTEXITCODE): $cmd`n$out" }
  return $out
}

try {
  # Ensure we are inside a git repo
  $inside = (& git rev-parse --is-inside-work-tree 2>$null).Trim()
  if ($LASTEXITCODE -ne 0 -or $inside -ne 'true') { throw 'Not inside a Git repository.' }

  $originUrl = (& git remote get-url origin 2>$null)
  if ($LASTEXITCODE -ne 0 -or [string]::IsNullOrWhiteSpace($originUrl)) {
    Write-Warning 'No origin remote set. Set it with: git remote add origin https://github.com/abokisub/Kobopoint.git'
    throw 'Origin remote is required.'
  }
  Write-Host "Origin: $originUrl" -ForegroundColor Green

  $currentBranch = (& git rev-parse --abbrev-ref HEAD).Trim()
  Write-Host "Current branch: $currentBranch" -ForegroundColor Green

  # Detect default branch (prefer main, fallback master)
  & git fetch origin "main:refs/remotes/origin/main" 2>$null | Out-Null
  $hasMain = $LASTEXITCODE -eq 0
  & git fetch origin "master:refs/remotes/origin/master" 2>$null | Out-Null
  $hasMaster = $LASTEXITCODE -eq 0

  if (-not $hasMain -and -not $hasMaster) { throw 'Cannot detect default branch (main/master) on origin.' }
  $defaultBranch = if ($hasMain) { 'main' } else { 'master' }
  Write-Host "Default branch: $defaultBranch" -ForegroundColor Green

  # Stash changes if any
  $status = (& git status --porcelain)
  $didStash = $false
  if (-not [string]::IsNullOrWhiteSpace($status)) {
    Write-Host 'Stashing local changes…' -ForegroundColor Yellow
    & git stash push -u -m "auto-sync $(Get-Date -UFormat %Y-%m-%d_%H-%M-%S)" | Out-Null
    if ($LASTEXITCODE -ne 0) { throw 'Failed to stash changes.' }
    $didStash = $true
  }

  # Update default branch
  if ($currentBranch -ne $defaultBranch) {
    Git "switch $defaultBranch"
  }
  Git "pull --ff-only origin $defaultBranch"

  # Switch back to original working branch if it is different
  if ($currentBranch -ne $defaultBranch) {
    Git "switch $currentBranch"
    # Merge default branch into current (safer than rebase)
    try {
      Git "merge $defaultBranch"
    } catch {
      Write-Warning "Merge produced conflicts. Please resolve, then run: git add . && git commit"
      throw $_
    }
  }

  # Restore stash
  if ($didStash) {
    Write-Host 'Restoring stashed changes…' -ForegroundColor Yellow
    & git stash pop
    if ($LASTEXITCODE -ne 0) {
      Write-Warning "Stash pop produced conflicts. Resolve them, then: git add . && git commit"
      throw 'Stash pop conflicts encountered.'
    }
  }

  # Push current branch (set upstream if missing)
  $hasUpstream = (& git rev-parse --abbrev-ref --symbolic-full-name @{u} 2>$null)
  if ($LASTEXITCODE -ne 0 -or [string]::IsNullOrWhiteSpace($hasUpstream)) {
    Write-Host "Setting upstream and pushing: origin/$currentBranch" -ForegroundColor Green
    Git "push -u origin $currentBranch"
  } else {
    Write-Host "Pushing $currentBranch" -ForegroundColor Green
    Git "push"
  }

  Write-Host "`nSync complete ✅" -ForegroundColor Green
  Write-Host "- Origin: $originUrl"
  Write-Host "- Default: $defaultBranch"
  Write-Host "- Branch:  $currentBranch"
} catch {
  Write-Error "`nAuto-sync failed: $_"
  exit 1
}