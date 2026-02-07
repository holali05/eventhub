<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. L'ADMIN a un passe-droit TOTAL
            if (strtolower($user->role) === 'admin') {
                return $next($request);
            }

            // 2. Si ce n'est pas un admin, on vérifie le statut
            if (strtolower($user->status) !== 'approved') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('status', 'Votre compte est en attente d\'approbation par un administrateur.');
            }
        }

        return $next($request);
    }
}