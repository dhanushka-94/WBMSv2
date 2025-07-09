<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fas fa-cogs text-blue-600 mr-3"></i>System Settings
                </h2>
                <p class="text-gray-600 text-sm mt-1">Manage customer divisions and types with custom reference IDs</p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i>
                    Custom ID Generator
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Enhanced Alert Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Tab Navigation -->
            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6">
                        <button class="tab-btn py-4 px-1 border-b-2 font-semibold text-sm border-blue-500 text-blue-600 flex items-center" 
                                onclick="showTab('divisions')">
                            <i class="fas fa-map-marked-alt mr-2"></i>
                            Customer Divisions
                            <span class="ml-2 bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">{{ $divisions->count() }}</span>
                        </button>
                        <button class="tab-btn py-4 px-1 border-b-2 font-semibold text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center" 
                                onclick="showTab('customer-types')">
                            <i class="fas fa-tags mr-2"></i>
                            Customer Types
                            <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $customerTypes->count() }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Enhanced Divisions Tab -->
            <div id="divisions-tab" class="tab-content">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-map-marked-alt text-blue-600 mr-3"></i>
                                    Customer Divisions
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">Manage geographical divisions with custom reference codes</p>
                            </div>
                            <button onclick="openModal('division-modal')" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Add Division
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-building mr-2 text-gray-400"></i>Division Name
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-2 text-gray-400"></i>Custom ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-info-circle mr-2 text-gray-400"></i>Description
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-toggle-on mr-2 text-gray-400"></i>Status
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-users mr-2 text-gray-400"></i>Customers
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-2 text-gray-400"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($divisions as $division)
                                        <tr class="hover:bg-blue-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-semibold text-gray-900">{{ $division->name }}</div>
                                                        <div class="text-xs text-gray-500">Division</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($division->custom_id)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                        <i class="fas fa-code mr-1"></i>{{ $division->custom_id }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>Not Set
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $division->description ?? 'No description provided' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($division->is_active)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                                        <i class="fas fa-check-circle mr-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-users text-gray-400 mr-2"></i>
                                                    <span class="text-sm font-semibold text-gray-900">{{ $division->customers->count() }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">customers</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="editDivision({{ $division->id }}, '{{ addslashes($division->name) }}', '{{ $division->custom_id }}', '{{ addslashes($division->description) }}', {{ $division->is_active ? 'true' : 'false' }})"
                                                            class="inline-flex items-center px-3 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md transition duration-150">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    @if($division->customers->count() == 0)
                                                        <form action="{{ route('settings.divisions.destroy', $division) }}" 
                                                              method="POST" 
                                                              class="inline-block"
                                                              onsubmit="return confirm('Are you sure you want to delete this division?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition duration-150">
                                                                <i class="fas fa-trash mr-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 rounded-md cursor-not-allowed" title="Cannot delete division with customers">
                                                            <i class="fas fa-lock mr-1"></i>Protected
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-map-marked-alt text-4xl text-gray-300 mb-4"></i>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No divisions found</h3>
                                                    <p class="text-gray-500 mb-4">Get started by creating your first division</p>
                                                    <button onclick="openModal('division-modal')" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                                                        <i class="fas fa-plus mr-2"></i>Add Division
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Customer Types Tab -->
            <div id="customer-types-tab" class="tab-content hidden">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-tags text-emerald-600 mr-3"></i>
                                    Customer Types
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">Manage customer categories with custom reference codes</p>
                            </div>
                            <button onclick="openModal('customer-type-modal')" 
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-sm transition duration-200 transform hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Add Customer Type
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-tag mr-2 text-gray-400"></i>Type Name
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-2 text-gray-400"></i>Custom ID
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-info-circle mr-2 text-gray-400"></i>Description
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-toggle-on mr-2 text-gray-400"></i>Status
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-users mr-2 text-gray-400"></i>Customers
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-2 text-gray-400"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($customerTypes as $type)
                                        <tr class="hover:bg-emerald-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                                            <i class="fas fa-user-tag text-emerald-600 text-sm"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-semibold text-gray-900">{{ $type->name }}</div>
                                                        <div class="text-xs text-gray-500">Customer Type</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <i class="fas fa-code mr-1"></i>{{ $type->custom_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $type->description ?? 'No description provided' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($type->is_active)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                                        <i class="fas fa-check-circle mr-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-users text-gray-400 mr-2"></i>
                                                    <span class="text-sm font-semibold text-gray-900">{{ $type->customers->count() }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">customers</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="editCustomerType({{ $type->id }}, '{{ addslashes($type->name) }}', '{{ $type->custom_id }}', '{{ addslashes($type->description) }}', {{ $type->is_active ? 'true' : 'false' }})"
                                                            class="inline-flex items-center px-3 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md transition duration-150">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </button>
                                                    @if($type->customers->count() == 0)
                                                        <form action="{{ route('settings.customer-types.destroy', $type) }}" 
                                                              method="POST" 
                                                              class="inline-block"
                                                              onsubmit="return confirm('Are you sure you want to delete this customer type?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition duration-150">
                                                                <i class="fas fa-trash mr-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 rounded-md cursor-not-allowed" title="Cannot delete customer type with customers">
                                                            <i class="fas fa-lock mr-1"></i>Protected
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No customer types found</h3>
                                                    <p class="text-gray-500 mb-4">Get started by creating your first customer type</p>
                                                    <button onclick="openModal('customer-type-modal')" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
                                                        <i class="fas fa-plus mr-2"></i>Add Customer Type
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Division Modal -->
    <div id="division-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full hidden z-50 opacity-0 transition-opacity duration-300">
        <div class="relative top-10 mx-auto p-0 border-0 w-11/12 md:w-1/2 lg:w-2/5 max-w-md shadow-2xl rounded-xl bg-white">
            <div class="relative">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center" id="division-modal-title">
                            <i class="fas fa-map-marked-alt mr-3"></i>Add Division
                        </h3>
                        <button onclick="closeModal('division-modal')" class="text-blue-100 hover:text-white transition duration-150">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <form id="division-form" action="{{ route('settings.divisions.store') }}" method="POST">
                        @csrf
                        <div id="division-method"></div>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="division_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-building text-blue-500 mr-2"></i>Division Name *
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="division_name"
                                           required
                                           maxlength="255"
                                           placeholder="Enter division name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                </div>
                                
                                <div>
                                    <label for="division_custom_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-hashtag text-blue-500 mr-2"></i>Custom ID *
                                        <span class="text-xs text-gray-500 font-normal">(Max 4 chars)</span>
                                    </label>
                                    <input type="text" 
                                           name="custom_id" 
                                           id="division_custom_id"
                                           required
                                           maxlength="4"
                                           placeholder="e.g., GDP"
                                           style="text-transform: uppercase;"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                </div>
                            </div>
                            
                            <div>
                                <label for="division_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Description
                                </label>
                                <textarea name="description" 
                                          id="division_description"
                                          rows="3"
                                          maxlength="500"
                                          placeholder="Enter division description (optional)"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 resize-none"></textarea>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="flex items-center cursor-pointer">
                                    <!-- Hidden input to ensure is_active is always sent -->
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="division_is_active"
                                           value="1"
                                           checked
                                           class="sr-only">
                                    <div class="relative">
                                        <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition duration-150 toggle-bg"></div>
                                        <div class="absolute w-4 h-4 bg-white rounded-full shadow -left-1 -top-1 transition transform duration-150 toggle-dot"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-semibold text-gray-700">
                                        <i class="fas fa-toggle-on text-green-500 mr-2 toggle-icon"></i>Active Status
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                            <button type="button" 
                                    onclick="closeModal('division-modal')"
                                    class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition duration-150">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 text-sm font-semibold text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition duration-150 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Save Division
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Customer Type Modal -->
    <div id="customer-type-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full hidden z-50 opacity-0 transition-opacity duration-300">
        <div class="relative top-10 mx-auto p-0 border-0 w-11/12 md:w-1/2 lg:w-2/5 max-w-md shadow-2xl rounded-xl bg-white">
            <div class="relative">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 rounded-t-xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center" id="customer-type-modal-title">
                            <i class="fas fa-tags mr-3"></i>Add Customer Type
                        </h3>
                        <button onclick="closeModal('customer-type-modal')" class="text-emerald-100 hover:text-white transition duration-150">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6">
                    <form id="customer-type-form" action="{{ route('settings.customer-types.store') }}" method="POST">
                        @csrf
                        <div id="customer-type-method"></div>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="customer_type_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tag text-emerald-500 mr-2"></i>Type Name *
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="customer_type_name"
                                           required
                                           maxlength="255"
                                           placeholder="Enter type name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150">
                                </div>
                                
                                <div>
                                    <label for="customer_type_custom_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-hashtag text-emerald-500 mr-2"></i>Custom ID *
                                        <span class="text-xs text-gray-500 font-normal">(Max 3 chars)</span>
                                    </label>
                                    <input type="text" 
                                           name="custom_id" 
                                           id="customer_type_custom_id"
                                           required
                                           maxlength="3"
                                           placeholder="e.g., RES"
                                           style="text-transform: uppercase;"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150">
                                </div>
                            </div>
                            
                            <div>
                                <label for="customer_type_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle text-emerald-500 mr-2"></i>Description
                                </label>
                                <textarea name="description" 
                                          id="customer_type_description"
                                          rows="3"
                                          maxlength="500"
                                          placeholder="Enter type description (optional)"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-150 resize-none"></textarea>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="flex items-center cursor-pointer">
                                    <!-- Hidden input to ensure is_active is always sent -->
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="customer_type_is_active"
                                           value="1"
                                           checked
                                           class="sr-only">
                                    <div class="relative">
                                        <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition duration-150 toggle-bg"></div>
                                        <div class="absolute w-4 h-4 bg-white rounded-full shadow -left-1 -top-1 transition transform duration-150 toggle-dot"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-semibold text-gray-700">
                                        <i class="fas fa-toggle-on text-green-500 mr-2 toggle-icon"></i>Active Status
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                            <button type="button" 
                                    onclick="closeModal('customer-type-modal')"
                                    class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition duration-150">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 text-sm font-semibold text-white bg-emerald-600 border border-transparent rounded-lg hover:bg-emerald-700 transition duration-150 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Save Customer Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Enhanced Tab functionality
    function showTab(tabName) {
        // Hide all tab contents with smooth transition
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Reset all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
            
            // Update badge colors
            const badge = btn.querySelector('span');
            if (badge) {
                badge.classList.remove('bg-blue-100', 'text-blue-600');
                badge.classList.add('bg-gray-100', 'text-gray-600');
            }
        });
        
        // Show selected tab with smooth transition
        const selectedTab = document.getElementById(tabName + '-tab');
        selectedTab.classList.remove('hidden');
        
        // Update active tab button
        const activeBtn = event.target.closest('.tab-btn');
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
        activeBtn.classList.add('border-blue-500', 'text-blue-600');
        
        // Update active badge color
        const activeBadge = activeBtn.querySelector('span');
        if (activeBadge) {
            activeBadge.classList.remove('bg-gray-100', 'text-gray-600');
            activeBadge.classList.add('bg-blue-100', 'text-blue-600');
        }
    }

    // Enhanced Modal functionality
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        
        // Add smooth fade-in animation
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10);
        
        // Focus on first input
        const firstInput = modal.querySelector('input[type="text"]');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('opacity-100');
        resetForm(modalId);
    }

    function resetForm(modalId) {
        if (modalId === 'division-modal') {
            const form = document.getElementById('division-form');
            form.reset();
            form.action = "{{ route('settings.divisions.store') }}";
            document.getElementById('division-method').innerHTML = '';
            document.getElementById('division-modal-title').innerHTML = '<i class="fas fa-map-marked-alt mr-3"></i>Add Division';
            
            // Reset toggle to active state
            const checkbox = document.getElementById('division_is_active');
            checkbox.checked = true;
            updateToggleDisplay(checkbox);
            
        } else if (modalId === 'customer-type-modal') {
            const form = document.getElementById('customer-type-form');
            form.reset();
            form.action = "{{ route('settings.customer-types.store') }}";
            document.getElementById('customer-type-method').innerHTML = '';
            document.getElementById('customer-type-modal-title').innerHTML = '<i class="fas fa-tags mr-3"></i>Add Customer Type';
            
            // Reset toggle to active state
            const checkbox = document.getElementById('customer_type_is_active');
            checkbox.checked = true;
            updateToggleDisplay(checkbox);
        }
    }

    // Toggle switch functionality
    function updateToggleDisplay(checkbox) {
        const label = checkbox.closest('label');
        const toggleBg = label.querySelector('.toggle-bg');
        const toggleDot = label.querySelector('.toggle-dot');
        const toggleIcon = label.querySelector('.toggle-icon');
        
        if (checkbox.checked) {
            // Active state
            toggleBg.classList.remove('bg-gray-200');
            toggleBg.classList.add('bg-green-400');
            toggleDot.classList.remove('translate-x-0');
            toggleDot.classList.add('translate-x-4');
            toggleIcon.classList.remove('fa-toggle-off', 'text-red-500');
            toggleIcon.classList.add('fa-toggle-on', 'text-green-500');
        } else {
            // Inactive state
            toggleBg.classList.remove('bg-green-400');
            toggleBg.classList.add('bg-gray-200');
            toggleDot.classList.remove('translate-x-4');
            toggleDot.classList.add('translate-x-0');
            toggleIcon.classList.remove('fa-toggle-on', 'text-green-500');
            toggleIcon.classList.add('fa-toggle-off', 'text-red-500');
        }
    }

    function setupToggleSwitches() {
        // Setup division toggle
        const divisionToggle = document.getElementById('division_is_active');
        if (divisionToggle) {
            const divisionLabel = divisionToggle.closest('label');
            divisionLabel.addEventListener('click', function(e) {
                if (e.target === divisionToggle) return; // Don't double-trigger
                e.preventDefault();
                divisionToggle.checked = !divisionToggle.checked;
                updateToggleDisplay(divisionToggle);
            });
            updateToggleDisplay(divisionToggle); // Initialize display
        }

        // Setup customer type toggle
        const customerTypeToggle = document.getElementById('customer_type_is_active');
        if (customerTypeToggle) {
            const customerTypeLabel = customerTypeToggle.closest('label');
            customerTypeLabel.addEventListener('click', function(e) {
                if (e.target === customerTypeToggle) return; // Don't double-trigger
                e.preventDefault();
                customerTypeToggle.checked = !customerTypeToggle.checked;
                updateToggleDisplay(customerTypeToggle);
            });
            updateToggleDisplay(customerTypeToggle); // Initialize display
        }
    }

    // Edit division with enhanced error handling
    function editDivision(id, name, customId, description, isActive) {
        try {
            document.getElementById('division_name').value = name || '';
            document.getElementById('division_custom_id').value = customId || '';
            document.getElementById('division_description').value = description || '';
            
            const checkbox = document.getElementById('division_is_active');
            checkbox.checked = isActive;
            updateToggleDisplay(checkbox);
            
            document.getElementById('division-form').action = `/settings/divisions/${id}`;
            document.getElementById('division-method').innerHTML = '@method("PUT")';
            document.getElementById('division-modal-title').innerHTML = '<i class="fas fa-edit mr-3"></i>Edit Division';
            
            openModal('division-modal');
        } catch (error) {
            console.error('Error editing division:', error);
            alert('An error occurred while opening the edit form. Please try again.');
        }
    }

    // Edit customer type with enhanced error handling
    function editCustomerType(id, name, customId, description, isActive) {
        try {
            document.getElementById('customer_type_name').value = name || '';
            document.getElementById('customer_type_custom_id').value = customId || '';
            document.getElementById('customer_type_description').value = description || '';
            
            const checkbox = document.getElementById('customer_type_is_active');
            checkbox.checked = isActive;
            updateToggleDisplay(checkbox);
            
            document.getElementById('customer-type-form').action = `/settings/customer-types/${id}`;
            document.getElementById('customer-type-method').innerHTML = '@method("PUT")';
            document.getElementById('customer-type-modal-title').innerHTML = '<i class="fas fa-edit mr-3"></i>Edit Customer Type';
            
            openModal('customer-type-modal');
        } catch (error) {
            console.error('Error editing customer type:', error);
            alert('An error occurred while opening the edit form. Please try again.');
        }
    }

    // Enhanced auto-uppercase functionality
    function setupAutoUppercase() {
        const customIdInputs = ['division_custom_id', 'customer_type_custom_id'];
        
        customIdInputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                });
                
                input.addEventListener('keypress', function(e) {
                    const char = String.fromCharCode(e.which);
                    if (!/[A-Za-z0-9]/.test(char)) {
                        e.preventDefault();
                    }
                });
            }
        });
    }

    // Form submission handling
    function setupFormSubmission() {
        // Division form
        const divisionForm = document.getElementById('division-form');
        if (divisionForm) {
            divisionForm.addEventListener('submit', function(e) {
                const name = document.getElementById('division_name').value.trim();
                const customId = document.getElementById('division_custom_id').value.trim();
                
                if (!name) {
                    e.preventDefault();
                    showValidationError('Division name is required.');
                    return false;
                }
                
                if (!customId) {
                    e.preventDefault();
                    showValidationError('Custom ID is required.');
                    return false;
                }
                
                if (customId.length > 4) {
                    e.preventDefault();
                    showValidationError('Custom ID must be 4 characters or less.');
                    return false;
                }
            });
        }

        // Customer type form
        const customerTypeForm = document.getElementById('customer-type-form');
        if (customerTypeForm) {
            customerTypeForm.addEventListener('submit', function(e) {
                const name = document.getElementById('customer_type_name').value.trim();
                const customId = document.getElementById('customer_type_custom_id').value.trim();
                
                if (!name) {
                    e.preventDefault();
                    showValidationError('Customer type name is required.');
                    return false;
                }
                
                if (!customId) {
                    e.preventDefault();
                    showValidationError('Custom ID is required.');
                    return false;
                }
                
                if (customId.length > 3) {
                    e.preventDefault();
                    showValidationError('Custom ID must be 3 characters or less.');
                    return false;
                }
            });
        }
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setupAutoUppercase();
        setupToggleSwitches();
        setupFormSubmission();
        
        // Add click handlers for modal backgrounds
        ['division-modal', 'customer-type-modal'].forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal(modalId);
                    }
                });
            }
        });
        
        // Add escape key handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const visibleModals = document.querySelectorAll('[id$="-modal"]:not(.hidden)');
                visibleModals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    });

    // Form validation feedback
    function showValidationError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg';
        alertDiv.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">${message}</p>
                </div>
            </div>
        `;
        
        // Insert at top of page
        const container = document.querySelector('.max-w-7xl');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    </script>
</x-app-layout> 