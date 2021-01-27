<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 処理速度とメモリ使用量のログ出力
 */
class LoggingProcessMemory
{
    /**
     * 送信されてきたリクエストの処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response  = $next($request);

        $startTime = microtime(true);
        $initialMemory = memory_get_usage();

        // 何かの処理

        $runningTime =  microtime(true) - $startTime;
        $usedMemory = (memory_get_peak_usage() - $initialMemory) / (1024 * 1024);

        \Log::info('running time: ' . $runningTime . ' [s]');
        \Log::info('used memory: ' . $usedMemory . ' [MB]');

        return $response;
    }
}
