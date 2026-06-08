<?php require_once '../../../actions/database.php';

function findProjectRoot($dir) {
    $dir = realpath($dir);

    while ($dir && $dir !== dirname($dir)) {

        if (
            file_exists($dir . '/.gitignore') ||
            (file_exists($dir . '/index.php') && is_dir($dir . '/assets'))
        ) {
            return $dir;
        }

        $dir = dirname($dir);
    }

    return $dir;
}

function getProjectSizes($startDir) {

    $rootDir = findProjectRoot($startDir);

    $sizes = [
        'code' => 0,
        'temp' => 0,
        'backups' => 0,
        'git' => 0,
        'assets' => 0,
        'other' => 0
    ];

    if (!$rootDir) {
        return [
            'error' => 'Root not found'
        ];
    }

    $root = str_replace('\\', '/', $rootDir);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootDir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {

        if (!$file->isFile()) continue;

        $path = str_replace('\\', '/', $file->getPathname());
        $relative = ltrim(str_replace($root, '', $path), '/');
        $size = $file->getSize();

        // 🧠 GIT
        if (str_starts_with($relative, '.git/')) {
            $sizes['git'] += $size;
            continue;
        }

        // 🧪 TEMP
        if (str_starts_with($relative, 'temp/')) {
            $sizes['temp'] += $size;
            continue;
        }

        // 💾 BACKUPS
        if (str_starts_with($relative, 'backups/')) {
            $sizes['backups'] += $size;
            continue;
        }

        // 🖼 ASSETS + CODE FILE TYPES INCLUDED IN CODE
        if (
            str_starts_with($relative, 'assets/') ||
            preg_match('/\.(png|jpg|jpeg|gif|webp|ico|svg|css|js)$/i', $relative)
        ) {
            $sizes['assets'] += $size;
            continue;
        }

        // 📦 CODE
        $sizes['code'] += $size;
    }

    // 💽 DISK (déplacé dans other)
    $sizes['other'] = disk_total_space($rootDir) - disk_free_space($rootDir);

    return [
        'root' => $rootDir,
        'sizes' => $sizes,
        'disk' => [
            'total' => disk_total_space($rootDir),
            'free' => disk_free_space($rootDir),
            'used' => disk_total_space($rootDir) - disk_free_space($rootDir),
        ],
        'total_project' => array_sum($sizes)
    ];
}

header('Content-Type: application/json');

echo json_encode(getProjectSizes(__DIR__), JSON_PRETTY_PRINT);