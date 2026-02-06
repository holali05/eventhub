<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    /**
     * Gère la requête entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. On vérifie si l'utilisateur est connecté
        if (Auth::check()) {
            $user = Auth::user();

            // 2. Si c'est un admin, il passe toujours (pas besoin d'approbation)
            if ($user->role === 'admin') {
                return $next($request);
            }

            // 3. Si l'organisateur n'est pas encore approuvé
            if ($user->status !== 'approved') {
                // On le déconnecte et on le redirige avec un message
                Auth::logout();
                
                return redirect()->route('login')->with('status', 'Votre compte est en attente d\'approbation par un administrateur.');
            }
        }

        return $next($request);
    }
}