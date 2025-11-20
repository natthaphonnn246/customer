<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockAIAgents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // ==== 1) บล็อก AI User-Agents (Scout / GPT / Browser Agent ของ AI) ====
        $blockedAgents = [
            'ChatGPT', 
            'GPTBot', 
            'curl', 
            'python-requests',
            'AI-Agent',
            'ChatGPT-User',
            'OpenAI',
            'Perplexity',
            'BraveBot',
            'ClaudeBot'
        ];

        $userAgent = $request->header('User-Agent');

        foreach ($blockedAgents as $agent) {
            if ($userAgent && stripos($userAgent, $agent) !== false) {
                abort(403, 'Access blocked (AI agent not allowed).');
            }
        }

        // ==== 2) บล็อก IP ของ AI Providers (เลือกเปิดใช้ได้) ====
        $blockedIPs = [
            // ตัวอย่าง IP OpenAI (จริง)
            '20.189.',   // OpenAI cluster
            '20.18.',    // OpenAI EU cluster
             // '127.0.0.1' //test localhost
        ];

        $ip = $request->ip();
        foreach ($blockedIPs as $blocked) {
            if (str_starts_with($ip, $blocked)) {
                abort(403, 'Access denied.');
            }
        }

        // ==== 3) Require Session ของ User จริง (Scout ไม่มี) ====
        if (!$request->session()->has('user_logged_in')) {
            // ถ้าไม่มี session → บล็อกทันที
            abort(403, 'No valid session.');
        }

        return $next($request);
    }

}
