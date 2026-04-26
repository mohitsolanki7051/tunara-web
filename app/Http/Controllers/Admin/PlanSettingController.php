<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanSetting;
use Illuminate\Http\Request;

class PlanSettingController extends Controller
{
    public function index()
    {
        $free = PlanSetting::where('plan', 'free')->first();
        $pro  = PlanSetting::where('plan', 'pro')->first();


        if (!$free) {
            $free = PlanSetting::create([
                'plan'                   => 'free',
                'max_tunnels'            => 1,
                'max_requests_per_day'   => 1000,
                'has_custom_subdomain'   => false,
                'has_password_protection'=> false,
                'price'                  => 0,
                'is_active'              => true,
            ]);
        }

        if (!$pro) {
            $pro = PlanSetting::create([
                'plan'                   => 'pro',
                'max_tunnels'            => 5,
                'max_requests_per_day'   => -1,
                'has_custom_subdomain'   => true,
                'has_password_protection'=> true,
                'price'                  => 9,
                'is_active'              => true,
            ]);
        }

        return view('admin.settings', compact('free', 'pro'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'free_max_tunnels'          => 'required|integer|min:1',
            'free_max_requests'         => 'required|integer|min:-1',
            'free_price'                => 'required|numeric|min:0',
            'pro_max_tunnels'           => 'required|integer|min:1',
            'pro_max_requests'          => 'required|integer|min:-1',
            'pro_price'                 => 'required|numeric|min:0',
        ]);

        PlanSetting::where('plan', 'free')->update([
            'max_tunnels'             => $request->free_max_tunnels,
            'max_requests_per_day'    => $request->free_max_requests,
            'has_custom_subdomain'    => $request->has('free_custom_subdomain'),
            'has_password_protection' => $request->has('free_password_protection'),
            'price'                   => $request->free_price,
        ]);

        PlanSetting::where('plan', 'pro')->update([
            'max_tunnels'             => $request->pro_max_tunnels,
            'max_requests_per_day'    => $request->pro_max_requests,
            'has_custom_subdomain'    => $request->has('pro_custom_subdomain'),
            'has_password_protection' => $request->has('pro_password_protection'),
            'price'                   => $request->pro_price,
        ]);

        return back()->with('success', 'Plan settings updated successfully!');
    }
}
