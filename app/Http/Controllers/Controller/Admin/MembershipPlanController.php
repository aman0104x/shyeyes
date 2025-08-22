<?php

namespace App\Http\Controllers\Controller\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the membership plans.
     */
    public function index()
    {
        $plans = MembershipPlan::all();
        $availableFeatures = [
            'View member profiles',
            'Send 10 messages daily',
            'Unlimited messaging',
            'Access public & private chat rooms',
            'Video calling feature',
            'Priority matchmaking',
            'Access exclusive events',
            'Media sharing',
            'Access SHY-EYES exclusive events',
            'Matchmaking with AI'
        ];

        return view('admin.membership-plans.index', compact('plans', 'availableFeatures'));
    }

    /**
     * Show the form for creating a new membership plan.
     */
    public function create()
    {
        $availableFeatures = [
            'View member profiles',
            'Send 10 messages daily',
            'Unlimited messaging',
            'Access public & private chat rooms',
            'Video calling feature',
            'Priority matchmaking',
            'Access exclusive events',
            'Media sharing',
            'Access SHY-EYES exclusive events',
            'Matchmaking with AI'
        ];

        return view('admin.membership-plans.create', compact('availableFeatures'));
    }

    /**
     * Store a newly created membership plan in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'features' => 'required|array',
            'features.*' => 'string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        MembershipPlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'monthly_price' => $request->monthly_price,
            'features' => $request->features,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan created successfully.');
    }

    /**
     * Display the specified membership plan.
     */
    public function show(MembershipPlan $membershipPlan)
    {
        return view('admin.membership-plans.show', compact('membershipPlan'));
    }

    /**
     * Show the form for editing the specified membership plan.
     */
    public function edit(MembershipPlan $membershipPlan)
    {
        $availableFeatures = [
            'View member profiles',
            'Send 10 messages daily',
            'Unlimited messaging',
            'Access public & private chat rooms',
            'Video calling feature',
            'Priority matchmaking',
            'Access exclusive events',
            'Media sharing',
            'Access SHY-EYES exclusive events',
            'Matchmaking with AI'
        ];

        return view('admin.membership-plans.edit', compact('membershipPlan', 'availableFeatures'));
    }

    /**
     * Update the specified membership plan in storage.
     */
    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'features' => 'required|array',
            'features.*' => 'string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $membershipPlan->update([
            'name' => $request->name,
            'price' => $request->price,
            'monthly_price' => $request->monthly_price,
            'features' => $request->features,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan updated successfully.');
    }

    /**
     * Remove the specified membership plan from storage.
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->delete();

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan deleted successfully.');
    }
}
