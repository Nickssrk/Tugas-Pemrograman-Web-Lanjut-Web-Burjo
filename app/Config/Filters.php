<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AdminFilter;

/**
 * CATATAN:
 * File ini meng-override Config/Filters.php bawaan CodeIgniter 4.
 * Sejak CI4 4.5.0, ada properti $required yang WAJIB diisi (forcehttps,
 * pagecache, performance) — karena itu alias-alias tersebut tetap
 * disertakan di sini meskipun tidak dipakai langsung oleh fitur Warung
 * Burjo, supaya tidak terjadi error "FilterException::forNoAlias".
 *
 * Jika versi CI4 Anda sedikit berbeda, cara paling aman adalah TIDAK
 * menimpa seluruh file ini — cukup buka Filters.php bawaan project Anda,
 * lalu tambahkan baris berikut ke dalam array $aliases yang sudah ada:
 *
 *   'adminauth' => AdminFilter::class,
 *
 * beserta baris "use App\Filters\AdminFilter;" di bagian atas.
 */
class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'adminauth'     => AdminFilter::class,
    ];

    public array $globals = [
        'before' => [
            // 'csrf',
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    public array $filters = [];

    /**
     * Filter wajib bawaan CodeIgniter 4 (sejak versi 4.5.0).
     * JANGAN dihapus, atau aplikasi akan error forNoAlias.
     */
    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];
}
