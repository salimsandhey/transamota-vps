@extends('seller.profile.base')

@section('profile-content')
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Documents</h2>
        @if(!Auth::user()->profile->verification_doc)
            <button id="upload-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Upload Document
            </button>
        @else
            <button id="change-document-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Change Document
            </button>
        @endif
    </div>
    
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    
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
                            <div class="font-medium text-gray-900">{{ Auth::user()->profile->document_type_name }}</div>
                            <div class="text-sm text-gray-500">Uploaded</div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ asset('storage/' . Auth::user()->profile->verification_doc) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('seller.profile.documents.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                @if(!Auth::user()->profile->verified_by_admin)
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div class="text-sm text-yellow-700">
                                <strong>Pending Verification:</strong> Your document is awaiting admin approval.
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-green-700">
                                <strong>Verified:</strong> Your document has been approved by admin.
                            </div>
                        </div>
                    </div>
                @endif
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
            <li>GST registration certificate (if applicable)</li>
            <li>Product catalog or brochure (optional)</li>
        </ul>
    </div>
</div>

<!-- Upload Form - Moved to bottom and simplified -->
<div id="upload-form" class="bg-white rounded-xl border border-gray-200 p-6 mt-6 transition-all duration-300 ease-in-out {{ Auth::user()->profile->verification_doc ? 'hidden' : '' }}">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Document</h2>
    
    <form action="{{ route('seller.profile.documents.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="document_type" class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
            <select name="document_type" id="document_type" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Select document type</option>
                <option value="business_registration" {{ old('document_type') == 'business_registration' ? 'selected' : '' }}>Business Registration Certificate</option>
                <option value="government_id" {{ old('document_type') == 'government_id' ? 'selected' : '' }}>Government ID</option>
                <option value="bank_details" {{ old('document_type') == 'bank_details' ? 'selected' : '' }}>Bank Account Details</option>
                <option value="gst_certificate" {{ old('document_type') == 'gst_certificate' ? 'selected' : '' }}>GST Registration Certificate</option>
                <option value="product_catalog" {{ old('document_type') == 'product_catalog' ? 'selected' : '' }}>Product Catalog</option>
                <option value="other" {{ old('document_type') == 'other' ? 'selected' : '' }}>Other Document</option>
            </select>
            @error('document_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">File Upload</label>
            <div class="mt-1 flex justify-center px-4 pt-4 pb-5 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-blue-400 transition-colors" id="drop-zone">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="document" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                            <span>Upload a file</span>
                            <input id="document" name="document" type="file" class="sr-only" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
                </div>
            </div>
            <!-- File Preview Container -->
            <div id="file-preview" class="mt-3 hidden">
                <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg id="preview-icon" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-2">
                                <p id="preview-filename" class="text-sm font-medium text-gray-900 truncate max-w-xs"></p>
                                <p id="preview-filesize" class="text-xs text-gray-500"></p>
                            </div>
                        </div>
                        <button type="button" id="remove-file" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @error('document')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-3 pt-2">
            <button type="button" id="cancel-upload" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
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
        const uploadButton = document.getElementById('upload-btn');
        const changeDocumentButton = document.getElementById('change-document-btn');
        const uploadForm = document.getElementById('upload-form');
        const cancelButton = document.getElementById('cancel-upload');
        const documentInput = document.getElementById('document');
        const filePreview = document.getElementById('file-preview');
        const previewFilename = document.getElementById('preview-filename');
        const previewFilesize = document.getElementById('preview-filesize');
        const removeFileButton = document.getElementById('remove-file');
        const dropZone = document.getElementById('drop-zone');
        
        // Handle upload button click
        if (uploadButton) {
            uploadButton.addEventListener('click', function() {
                uploadForm.classList.remove('hidden');
                // Scroll to the form
                uploadForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        }
        
        // Handle change document button click
        if (changeDocumentButton) {
            changeDocumentButton.addEventListener('click', function() {
                uploadForm.classList.remove('hidden');
                // Scroll to the form
                uploadForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        }
        
        // Handle cancel button click
        if (cancelButton) {
            cancelButton.addEventListener('click', function() {
                uploadForm.classList.add('hidden');
                // Reset form
                if (documentInput) {
                    documentInput.value = '';
                    filePreview.classList.add('hidden');
                }
            });
        }
        
        // Handle file selection for preview
        if (documentInput) {
            documentInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    
                    // Update preview information
                    previewFilename.textContent = file.name;
                    previewFilesize.textContent = formatFileSize(file.size);
                    
                    // Show preview container
                    filePreview.classList.remove('hidden');
                } else {
                    // Hide preview if no file selected
                    filePreview.classList.add('hidden');
                }
            });
        }
        
        // Handle remove file button
        if (removeFileButton) {
            removeFileButton.addEventListener('click', function() {
                if (documentInput) {
                    documentInput.value = '';
                    filePreview.classList.add('hidden');
                }
            });
        }
        
        // Drag and drop functionality
        if (dropZone) {
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.classList.add('border-blue-400', 'bg-blue-50');
            });
            
            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            });
            
            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-blue-400', 'bg-blue-50');
                
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    // Set the file to the input
                    if (documentInput) {
                        documentInput.files = e.dataTransfer.files;
                        
                        // Trigger change event to update preview
                        const event = new Event('change', { bubbles: true });
                        documentInput.dispatchEvent(event);
                    }
                }
            });
        }
        
        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>
@endsection