@extends('layouts.app')

@section('title', 'All Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800">
                <i class="fas fa-cog"></i> All Settings
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-8">
            @foreach($settings as $group => $groupSettings)
                <div class="mb-8 pb-8 border-b last:border-b-0">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 capitalize">
                        <i class="fas fa-folder-open text-gray-500"></i> {{ ucfirst($group) }} Settings
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($groupSettings as $setting)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-700 mb-1">{{ $setting->key }}</h3>
                                        @if($setting->description)
                                            <p class="text-sm text-gray-500 mb-2">{{ $setting->description }}</p>
                                        @endif
                                        
                                        @if($setting->type === 'image')
                                            @if($setting->value)
                                                <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="h-32 rounded-lg mb-2">
                                            @else
                                                <span class="text-gray-400 text-sm">No image uploaded</span>
                                            @endif
                                        @elseif($setting->type === 'textarea')
                                            <div class="text-gray-800 text-sm whitespace-pre-wrap">{{ $setting->value ?? 'Not set' }}</div>
                                        @else
                                            <div class="text-gray-800">{{ $setting->value ?? 'Not set' }}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-4">
                                        <button onclick="editSetting({{ $setting->id }}, '{{ $setting->key }}', '{{ $setting->type }}')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition text-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($settings->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-inbox text-6xl mb-4"></i>
                    <p class="text-xl">No settings found. Add some settings to get started!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold mb-4">Edit Setting</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" id="settingLabel">Setting Value</label>
                <input type="text" id="settingValue" name="value" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <textarea id="settingTextarea" name="value" rows="4" class="hidden w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                <input type="file" id="settingFile" name="value" class="hidden w-full px-4 py-3 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editSetting(id, key, type) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const label = document.getElementById('settingLabel');
    const input = document.getElementById('settingValue');
    const textarea = document.getElementById('settingTextarea');
    const file = document.getElementById('settingFile');
    
    form.action = `/admin/settings/${id}`;
    label.textContent = key;
    
    input.classList.add('hidden');
    textarea.classList.add('hidden');
    file.classList.add('hidden');
    
    if (type === 'textarea') {
        textarea.classList.remove('hidden');
    } else if (type === 'image') {
        file.classList.remove('hidden');
    } else {
        input.classList.remove('hidden');
    }
    
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
