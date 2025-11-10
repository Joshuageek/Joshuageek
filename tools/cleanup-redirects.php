#!/usr/bin/env php
<?php
/**
 * Cleanup Redirect Files and Old Folders
 * 
 * Removes:
 * - Redirect files in root (old locations)
 * - Old admin/ folder (already moved to pages/admin/)
 * - Keeps backup folder (for safety)
 * 
 * Usage:
 *   php tools/cleanup-redirects.php --dry-run   # Preview
 *   php tools/cleanup-redirects.php --execute   # Remove files
 */

class RedirectCleanup
{
    private $rootPath;
    private $dryRun = true;
    private $removedCount = 0;
    
    // Files that are redirect files (should be removed)
    private $redirectFiles = [
        'about.php',
        'admin-dashboard.php',
        'booking.php',
        'choose_role.php',
        'clinic.php',
        'constants.php',
        'contact.php',
        'footer.php',
        'forgot-pwd.php',
        'header.php',
        'login.php',
        'logout.php',
        'notes.php',
        'paywall.php',
        'question.php',
        'reset-password.php',
        'signthera.php',
        'signup.php',
        'therapist-dashboard.php',
    ];
    
    // Files to KEEP in root
    private $keepFiles = [
        'index.php',
        'test-db-connection.php',
        'composer.json',
        'composer.lock',
        '.env',
        '.env.example',
        '.gitignore',
        '.htaccess',
        'switch-db.sh',
        '.reorganization_manifest.json',
    ];
    
    // Directories to remove (already moved)
    private $oldDirectories = [
        'admin',  // Now in pages/admin/
    ];

    public function __construct($rootPath)
    {
        $this->rootPath = rtrim($rootPath, '/');
    }

    public function run($mode = 'dry-run')
    {
        $this->dryRun = ($mode === 'dry-run');
        
        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║     Cleanup Redirect Files & Old Folders              ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";
        
        if ($this->dryRun) {
            echo "🔍 DRY RUN MODE - No files will be deleted\n";
            echo "   Run with --execute to actually remove files\n\n";
        } else {
            echo "⚡ EXECUTE MODE - Files will be permanently deleted\n";
            echo "   (Backup folder will be preserved)\n\n";
            
            if (!$this->confirm("⚠️  This will delete redirect files. Continue?")) {
                echo "❌ Cancelled\n";
                return;
            }
        }
        
        $this->cleanupRedirectFiles();
        $this->cleanupOldDirectories();
        $this->generateReport();
        
        if (!$this->dryRun) {
            echo "\n✅ Cleanup complete!\n";
            echo "   Files removed: {$this->removedCount}\n";
            echo "   Backup preserved: .backup_20251101111728/\n\n";
        } else {
            echo "\n✅ Dry run complete!\n";
            echo "   Run with --execute to remove these files\n\n";
        }
    }

    private function cleanupRedirectFiles()
    {
        echo "🧹 Removing redirect files from root...\n";
        
        foreach ($this->redirectFiles as $file) {
            $path = $this->rootPath . '/' . $file;
            
            if (!file_exists($path)) {
                continue;
            }
            
            // Verify it's actually a redirect file
            $content = file_get_contents($path);
            if (strpos($content, '// This file has been moved to:') === false &&
                strpos($content, 'header(\'Location:') === false) {
                echo "   ⚠ Skipping {$file} (not a redirect file)\n";
                continue;
            }
            
            if ($this->dryRun) {
                echo "   → Would remove: {$file}\n";
                $this->removedCount++;
            } else {
                if (unlink($path)) {
                    echo "   ✓ Removed: {$file}\n";
                    $this->removedCount++;
                } else {
                    echo "   ✗ Failed to remove: {$file}\n";
                }
            }
        }
    }

    private function cleanupOldDirectories()
    {
        echo "\n📂 Removing old directories...\n";
        
        foreach ($this->oldDirectories as $dir) {
            $path = $this->rootPath . '/' . $dir;
            
            if (!is_dir($path)) {
                echo "   ⚠ Skipping {$dir}/ (not found)\n";
                continue;
            }
            
            // Count files in directory
            $files = $this->getFilesInDirectory($path);
            $fileCount = count($files);
            
            if ($fileCount === 0) {
                echo "   ⚠ Skipping {$dir}/ (already empty)\n";
                continue;
            }
            
            if ($this->dryRun) {
                echo "   → Would remove: {$dir}/ ({$fileCount} files)\n";
                foreach ($files as $file) {
                    echo "      • " . basename($file) . "\n";
                }
            } else {
                echo "   Removing {$dir}/ ({$fileCount} files)...\n";
                if ($this->removeDirectory($path)) {
                    echo "   ✓ Removed: {$dir}/\n";
                    $this->removedCount += $fileCount;
                } else {
                    echo "   ✗ Failed to remove: {$dir}/\n";
                }
            }
        }
    }

    private function getFilesInDirectory($dir)
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }

    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        
        return rmdir($dir);
    }

    private function generateReport()
    {
        echo "\n";
        echo "╔════════════════════════════════════════════════════════╗\n";
        echo "║     Cleanup Summary                                   ║\n";
        echo "╚════════════════════════════════════════════════════════╝\n";
        echo "\n";
        
        if ($this->dryRun) {
            echo "Files that would be removed: {$this->removedCount}\n";
        } else {
            echo "Files removed: {$this->removedCount}\n";
        }
        
        echo "\n";
        echo "📝 After cleanup, your root directory will only have:\n";
        echo "\n";
        echo "Essential Files:\n";
        echo "  • index.php              (Homepage)\n";
        echo "  • composer.json          (Dependencies)\n";
        echo "  • .env                   (Configuration)\n";
        echo "  • .htaccess             (Server config)\n";
        echo "\n";
        echo "Utility Files:\n";
        echo "  • test-db-connection.php (Database testing)\n";
        echo "  • switch-db.sh          (Environment switcher)\n";
        echo "\n";
        echo "Organized Directories:\n";
        echo "  • pages/                (All pages by role)\n";
        echo "  • public/               (Public access files)\n";
        echo "  • includes/             (Shared code)\n";
        echo "  • config/               (Configuration)\n";
        echo "  • migrations/           (Database)\n";
        echo "  • tools/                (Dev tools)\n";
        echo "\n";
        echo "Preserved:\n";
        echo "  • .backup_*/            (Safety backup - keep this!)\n";
        echo "\n";
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
$cleanup = new RedirectCleanup($rootPath);

// Parse arguments
$mode = 'dry-run';
if (isset($argv[1])) {
    switch ($argv[1]) {
        case '--execute':
        case '-e':
            $mode = 'execute';
            break;
        case '--dry-run':
        case '-d':
        default:
            $mode = 'dry-run';
            break;
    }
}

$cleanup->run($mode);