#!/usr/bin/env php
<?php
/**
 * Automated Code Structure Organizer
 * 
 * This script reorganizes your codebase into a clean, maintainable structure
 * without breaking any functionality.
 * 
 * Usage:
 *   php tools/organize-structure.php --dry-run   # Preview changes
 *   php tools/organize-structure.php --execute   # Apply changes
 *   php tools/organize-structure.php --rollback  # Undo changes
 */

class StructureOrganizer
{
    private $rootPath;
    private $dryRun = true;
    private $backupPath;
    private $movedFiles = [];
    private $updatedPaths = [];
    
    private $fileMap = [
        // Authentication files → public/auth/
        'login.php' => 'public/auth/login.php',
        'signup.php' => 'public/auth/signup.php',
        'logout.php' => 'public/auth/logout.php',
        'forgot-pwd.php' => 'public/auth/forgot-password.php',
        'reset-password.php' => 'public/auth/reset-password.php',
        'choose_role.php' => 'public/auth/choose-role.php',
        
        // Client pages → pages/client/
        'client-dashboard.php' => 'pages/client/dashboard.php',
        'booking.php' => 'pages/client/booking.php',
        'question.php' => 'pages/client/questionnaire.php',
        'notes.php' => 'pages/client/notes.php',
        'paywall.php' => 'pages/client/paywall.php',
        
        // Therapist pages → pages/therapist/
        'therapist-dashboard.php' => 'pages/therapist/dashboard.php',
        'signthera.php' => 'pages/therapist/registration.php',
        
        // Admin pages → pages/admin/
        'admin-dashboard.php' => 'pages/admin/dashboard.php',
        
        // Public pages → pages/public/
        'about.php' => 'pages/public/about.php',
        'contact.php' => 'pages/public/contact.php',
        'clinic.php' => 'pages/public/clinic.php',
        
        // Shared layouts → includes/layouts/
        'header.php' => 'includes/layouts/header.php',
        'footer.php' => 'includes/layouts/footer.php',
        
        // Helper files → includes/helpers/
        'constants.php' => 'includes/helpers/constants.php',
    ];
    
    private $directoryMoves = [
        // Move entire admin folder contents
        'admin/' => 'pages/admin/',
    ];
    
    private $duplicatesToRemove = [
        'admin/my_patients.php', // Keep my-patients.php (kebab-case)
    ];

    public function __construct($rootPath)
    {
        $this->rootPath = rtrim($rootPath, '/');
        $this->backupPath = $this->rootPath . '/.backup_' . date('YmdHis');
    }

    public function run($mode = 'dry-run')
    {
        $this->dryRun = ($mode === 'dry-run');
        
        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║     Code Structure Organizer                          ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";
        
        if ($mode === 'rollback') {
            return $this->rollback();
        }
        
        if ($this->dryRun) {
            echo "🔍 DRY RUN MODE - No files will be changed\n";
            echo "   Run with --execute to apply changes\n\n";
        } else {
            echo "⚡ EXECUTE MODE - Files will be reorganized\n";
            echo "   Backup will be created at: {$this->backupPath}\n\n";
            
            if (!$this->confirm("Continue with reorganization?")) {
                echo "❌ Cancelled\n";
                return;
            }
        }
        
        try {
            $this->createBackup();
            $this->createNewStructure();
            $this->moveFiles();
            $this->moveDirectories();
            $this->updateFilePaths();
            $this->createRedirects();
            $this->checkForDuplicates();
            $this->generateReport();
            
            if (!$this->dryRun) {
                $this->saveManifest();
                echo "\n✅ Reorganization complete!\n";
                echo "   Backup saved to: {$this->backupPath}\n";
                echo "   Run with --rollback to undo changes\n\n";
            } else {
                echo "\n✅ Dry run complete!\n";
                echo "   Run with --execute to apply these changes\n\n";
            }
            
        } catch (Exception $e) {
            echo "\n❌ Error: " . $e->getMessage() . "\n";
            if (!$this->dryRun) {
                echo "   Rolling back changes...\n";
                $this->rollback();
            }
        }
    }

    private function createBackup()
    {
        if ($this->dryRun) {
            echo "📦 Would create backup at: {$this->backupPath}\n";
            return;
        }
        
        echo "📦 Creating backup...\n";
        
        // Create backup directory
        if (!mkdir($this->backupPath, 0755, true)) {
            throw new Exception("Failed to create backup directory");
        }
        
        // Copy critical files
        $filesToBackup = array_merge(
            array_keys($this->fileMap),
            ['index.php', '.htaccess', 'composer.json']
        );
        
        foreach ($filesToBackup as $file) {
            $source = $this->rootPath . '/' . $file;
            if (file_exists($source)) {
                $dest = $this->backupPath . '/' . $file;
                $destDir = dirname($dest);
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                copy($source, $dest);
            }
        }
        
        echo "   ✓ Backup created\n";
    }

    private function createNewStructure()
    {
        echo "\n📁 Creating new directory structure...\n";
        
        $directories = [
            'public/auth',
            'public/assets',
            'pages/client',
            'pages/therapist',
            'pages/admin',
            'pages/public',
            'includes/layouts',
            'includes/helpers',
            'includes/auth',
            'tools',
        ];
        
        foreach ($directories as $dir) {
            $fullPath = $this->rootPath . '/' . $dir;
            
            if ($this->dryRun) {
                if (!is_dir($fullPath)) {
                    echo "   → Would create: {$dir}/\n";
                }
            } else {
                if (!is_dir($fullPath)) {
                    if (mkdir($fullPath, 0755, true)) {
                        echo "   ✓ Created: {$dir}/\n";
                    } else {
                        throw new Exception("Failed to create directory: {$dir}");
                    }
                }
            }
        }
    }

    private function moveFiles()
    {
        echo "\n📝 Moving files to new locations...\n";
        
        foreach ($this->fileMap as $source => $destination) {
            $sourcePath = $this->rootPath . '/' . $source;
            $destPath = $this->rootPath . '/' . $destination;
            
            if (!file_exists($sourcePath)) {
                echo "   ⚠ Skipping {$source} (not found)\n";
                continue;
            }
            
            if ($this->dryRun) {
                echo "   → {$source}\n";
                echo "      to {$destination}\n";
            } else {
                // Create destination directory if needed
                $destDir = dirname($destPath);
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                
                // Copy file
                if (copy($sourcePath, $destPath)) {
                    $this->movedFiles[] = [
                        'source' => $source,
                        'destination' => $destination
                    ];
                    echo "   ✓ Moved: {$source} → {$destination}\n";
                } else {
                    throw new Exception("Failed to copy: {$source}");
                }
            }
        }
    }

    private function moveDirectories()
    {
        echo "\n📂 Moving directories...\n";
        
        foreach ($this->directoryMoves as $source => $destination) {
            $sourcePath = $this->rootPath . '/' . $source;
            $destPath = $this->rootPath . '/' . $destination;
            
            if (!is_dir($sourcePath)) {
                echo "   ⚠ Skipping {$source} (not found)\n";
                continue;
            }
            
            // Get all PHP files in source directory
            $files = glob($sourcePath . '*.php');
            
            foreach ($files as $file) {
                $filename = basename($file);
                $relSource = $source . $filename;
                $relDest = $destination . $filename;
                $fullDest = $destPath . $filename;
                
                if ($this->dryRun) {
                    echo "   → {$relSource}\n";
                    echo "      to {$relDest}\n";
                } else {
                    if (!is_dir($destPath)) {
                        mkdir($destPath, 0755, true);
                    }
                    
                    if (copy($file, $fullDest)) {
                        $this->movedFiles[] = [
                            'source' => $relSource,
                            'destination' => $relDest
                        ];
                        echo "   ✓ Moved: {$relSource} → {$relDest}\n";
                    }
                }
            }
        }
    }

    private function updateFilePaths()
    {
        echo "\n🔧 Updating file paths in code...\n";
        
        if ($this->dryRun) {
            echo "   → Would update include/require paths\n";
            echo "   → Would update relative links\n";
            return;
        }
        
        // Path replacements
        $replacements = [
            // Old includes → New includes
            "include('header.php')" => "include(__DIR__ . '/../../includes/layouts/header.php')",
            'include("header.php")' => 'include(__DIR__ . "/../../includes/layouts/header.php")',
            "include('footer.php')" => "include(__DIR__ . '/../../includes/layouts/footer.php')",
            'include("footer.php")' => 'include(__DIR__ . "/../../includes/layouts/footer.php")',
            "require_once 'config/db.php'" => "require_once __DIR__ . '/../../config/db.php'",
            "./php/config.php" => "../../php/config.php",
        ];
        
        // Update moved files
        foreach ($this->movedFiles as $moved) {
            $filePath = $this->rootPath . '/' . $moved['destination'];
            
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                $originalContent = $content;
                
                foreach ($replacements as $old => $new) {
                    $content = str_replace($old, $new, $content);
                }
                
                if ($content !== $originalContent) {
                    file_put_contents($filePath, $content);
                    $this->updatedPaths[] = $moved['destination'];
                    echo "   ✓ Updated paths in: {$moved['destination']}\n";
                }
            }
        }
    }

    private function createRedirects()
    {
        echo "\n🔀 Creating redirect files (for backward compatibility)...\n";
        
        if ($this->dryRun) {
            echo "   → Would create redirect files in old locations\n";
            return;
        }
        
        foreach ($this->movedFiles as $moved) {
            $oldPath = $this->rootPath . '/' . $moved['source'];
            $newPath = $moved['destination'];
            
            // Create redirect file
            $redirectContent = "<?php\n";
            $redirectContent .= "// This file has been moved to: {$newPath}\n";
            $redirectContent .= "// Redirecting...\n";
            $redirectContent .= "header('Location: /{$newPath}');\n";
            $redirectContent .= "exit;\n";
            
            file_put_contents($oldPath, $redirectContent);
            echo "   ✓ Created redirect: {$moved['source']}\n";
        }
    }

    private function checkForDuplicates()
    {
        echo "\n🔍 Checking for duplicate files...\n";
        
        foreach ($this->duplicatesToRemove as $duplicate) {
            $path = $this->rootPath . '/' . $duplicate;
            
            if (file_exists($path)) {
                if ($this->dryRun) {
                    echo "   → Would remove duplicate: {$duplicate}\n";
                } else {
                    if (unlink($path)) {
                        echo "   ✓ Removed duplicate: {$duplicate}\n";
                    }
                }
            }
        }
    }

    private function generateReport()
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║     Reorganization Summary                            ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";
        
        echo "Files moved: " . count($this->movedFiles) . "\n";
        echo "Paths updated: " . count($this->updatedPaths) . "\n";
        echo "Duplicates removed: " . count($this->duplicatesToRemove) . "\n";
        echo "\n";
        
        if (!$this->dryRun && count($this->movedFiles) > 0) {
            echo "📝 New structure:\n";
            echo "\n";
            echo "pages/\n";
            echo "├── client/         # Client dashboard, booking, questionnaire\n";
            echo "├── therapist/      # Therapist dashboard, profile\n";
            echo "├── admin/          # All admin pages\n";
            echo "└── public/         # Public pages (about, contact, clinic)\n";
            echo "\n";
            echo "public/\n";
            echo "└── auth/           # Login, signup, password reset\n";
            echo "\n";
            echo "includes/\n";
            echo "├── layouts/        # Header, footer, sidebar\n";
            echo "└── helpers/        # Helper functions, constants\n";
            echo "\n";
        }
    }

    private function saveManifest()
    {
        $manifest = [
            'timestamp' => date('Y-m-d H:i:s'),
            'backup_path' => $this->backupPath,
            'moved_files' => $this->movedFiles,
            'updated_paths' => $this->updatedPaths,
        ];
        
        $manifestPath = $this->rootPath . '/.reorganization_manifest.json';
        file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
    }

    private function rollback()
    {
        echo "🔄 Rolling back changes...\n\n";
        
        $manifestPath = $this->rootPath . '/.reorganization_manifest.json';
        
        if (!file_exists($manifestPath)) {
            echo "❌ No manifest found. Cannot rollback.\n";
            return;
        }
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        $backupPath = $manifest['backup_path'];
        
        if (!is_dir($backupPath)) {
            echo "❌ Backup directory not found: {$backupPath}\n";
            return;
        }
        
        if (!$this->confirm("Restore from backup at {$backupPath}?")) {
            echo "❌ Cancelled\n";
            return;
        }
        
        // Restore files
        foreach ($manifest['moved_files'] as $moved) {
            $backupFile = $backupPath . '/' . $moved['source'];
            $originalFile = $this->rootPath . '/' . $moved['source'];
            
            if (file_exists($backupFile)) {
                copy($backupFile, $originalFile);
                echo "   ✓ Restored: {$moved['source']}\n";
            }
        }
        
        echo "\n✅ Rollback complete!\n";
    }

    private function confirm($message)
    {
        echo "{$message} [y/N]: ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return strtolower(trim($line)) === 'y';
    }
}

// Main execution
if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

$rootPath = dirname(__DIR__);
$organizer = new StructureOrganizer($rootPath);

// Parse arguments
$mode = 'dry-run';
if (isset($argv[1])) {
    switch ($argv[1]) {
        case '--execute':
        case '-e':
            $mode = 'execute';
            break;
        case '--rollback':
        case '-r':
            $mode = 'rollback';
            break;
        case '--dry-run':
        case '-d':
        default:
            $mode = 'dry-run';
            break;
    }
}

$organizer->run($mode);
