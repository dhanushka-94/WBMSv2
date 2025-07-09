<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Display the settings page with divisions and customer types
     */
    public function index(): View
    {
        $divisions = Division::orderBy('name')->get();
        $customerTypes = CustomerType::orderBy('name')->get();
        
        return view('settings.index', compact('divisions', 'customerTypes'));
    }

    // DIVISION CRUD METHODS
    
    /**
     * Store a new division
     */
    public function storeDivision(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
            'custom_id' => 'required|string|max:4|unique:divisions,custom_id',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle checkbox: if not present or false, set to false; if present and true, set to true
        $validated['is_active'] = $request->has('is_active') && $request->input('is_active');

        Division::create($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Division created successfully.');
    }

    /**
     * Update a division
     */
    public function updateDivision(Request $request, Division $division): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('divisions')->ignore($division->id)
            ],
            'custom_id' => [
                'required',
                'string',
                'max:4',
                Rule::unique('divisions')->ignore($division->id)
            ],
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle checkbox: if not present or false, set to false; if present and true, set to true
        $validated['is_active'] = $request->has('is_active') && $request->input('is_active');

        $division->update($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Division updated successfully.');
    }

    /**
     * Delete a division
     */
    public function destroyDivision(Division $division): RedirectResponse
    {
        // Check if division has customers
        if ($division->customers()->count() > 0) {
            return redirect()->route('settings.index')
                ->with('error', 'Cannot delete division. It has associated customers.');
        }

        $division->delete();

        return redirect()->route('settings.index')
            ->with('success', 'Division deleted successfully.');
    }

    // CUSTOMER TYPE CRUD METHODS
    
    /**
     * Store a new customer type
     */
    public function storeCustomerType(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:customer_types,name',
            'custom_id' => 'required|string|max:3|unique:customer_types,custom_id',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle checkbox: if not present or false, set to false; if present and true, set to true
        $validated['is_active'] = $request->has('is_active') && $request->input('is_active');

        CustomerType::create($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Customer type created successfully.');
    }

    /**
     * Update a customer type
     */
    public function updateCustomerType(Request $request, CustomerType $customerType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customer_types')->ignore($customerType->id)
            ],
            'custom_id' => [
                'required',
                'string',
                'max:3',
                Rule::unique('customer_types')->ignore($customerType->id)
            ],
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle checkbox: if not present or false, set to false; if present and true, set to true
        $validated['is_active'] = $request->has('is_active') && $request->input('is_active');

        $customerType->update($validated);

        return redirect()->route('settings.index')
            ->with('success', 'Customer type updated successfully.');
    }

    /**
     * Delete a customer type
     */
    public function destroyCustomerType(CustomerType $customerType): RedirectResponse
    {
        // Check if customer type has customers
        if ($customerType->customers()->count() > 0) {
            return redirect()->route('settings.index')
                ->with('error', 'Cannot delete customer type. It has associated customers.');
        }

        $customerType->delete();

        return redirect()->route('settings.index')
            ->with('success', 'Customer type deleted successfully.');
    }
}
