<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if (Auth::guard('doctor')->check()) {
        $doctor = Auth::guard('doctor')->user();

        if ($doctor->status === 'approved') {

            // Manually check subscription from DB
            $subscription = DB::table('subscriptions')
                ->where('doctor_id', $doctor->id)
                ->orderByDesc('end_date')
                ->first();

            if ($subscription && Carbon::parse($subscription->end_date)->isFuture()) {
                return $next($request); // subscription is valid
            }

            // Auth::guard('doctor')->logout();
            return response()->view('doctor.subscription_expired', ['doctor' => $doctor ]);
        }

        elseif ($doctor->status === 'pending') {
            Auth::guard('doctor')->logout();
            return response()->view('doctor.pending', ['doctor' => $doctor]);
        }

        elseif ($doctor->status === 'rejected') {
            Auth::guard('doctor')->logout();
            return response()->view('doctor.rejected', ['doctor' => $doctor]);
        }
    }

    return redirect()->route('doctor.login');
}

}

