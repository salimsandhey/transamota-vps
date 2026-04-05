@extends('buyer.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Documents</h2>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            Upload Document
        </button>
    </div>
    
    <div class="mb-6">
        <h3 class="text-md font-medium text-gray-700 mb-3">Uploaded Documents</h3>
        
        @if(Auth::user()->profile->verification_doc)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-gray-900">Business Verification Document</div>
                            <div class="text-sm text-gray-500">Uploaded on {{ date('M d, Y') }}</div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No documents uploaded</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by uploading your business documents.</p>
            </div>
        @endif
    </div>
    
    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-md font-medium text-gray-700 mb-3">Document Requirements</h3>
        <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600">
            <li>Business registration certificate or license</li>
            <li>Government-issued ID (passport, driver's license, etc.)</li>
            <li>Bank account details or voided check</li>
            <li>Tax identification number (if applicable)</li>
        </ul>
    </div>
</div>

<!-- Upload Form (Hidden by default) -->
<div id="upload-form" class="hidden bg-white rounded-xl border border-gray-200 p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Upload Document</h2>
    
    <form>
        <div class="mb-6">
            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
            <select name="document_type" id="document_type" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select document type</option>
                <option value="business_registration">Business Registration Certificate</option>
                <option value="government_id">Government ID</option>
                <option value="bank_details">Bank Account Details</option>
                <option value="tax_id">Tax Identification Number</option>
                <option value="other">Other Document</option>
            </select>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">File Upload</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                Upload Document
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadButton = document.querySelector('.flex.items-center.justify-between.mb-6 button');
        const uploadForm = document.getElementById('upload-form');
        const cancelButton = uploadForm.querySelector('button[type="button"]');
        
        uploadButton.addEventListener('click', function() {
            uploadForm.classList.toggle('hidden');
        });
        
        cancelButton.addEventListener('click', function() {
            uploadForm.classList.add('hidden');
        });
    });
</script>
@endsection