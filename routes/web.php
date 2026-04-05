<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Events\MessageSent;
use App\Models\Message;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\GroupChatController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\User;
use App\Models\Product;
use App\Notifications\ProductApprovedNotification;
use App\Notifications\ProductRejectedNotification;

// Test route for email notifications
Route::get('/test-email', function () {
    // Get a test user (seller)
    $user = User::where('role', 'seller')->first();
    
    if (!$user) {
        return 'No seller found for testing';
    }
    
    // Get a test product
    $product = Product::first();
    
    if (!$product) {
        return 'No product found for testing';
    }
    
    // Send test notifications
    $user->notify(new ProductApprovedNotification($product));
    
    return 'Test email sent for product approval!';
});

// Share categories with all views
View::composer('*', function ($view) {
    try {
        $categories = \App\Models\Category::all();
        $view->with('categories', $categories);
    } catch (Exception $e) {
        // If there's a database issue, use empty collection
        $view->with('categories', collect());
        // Log the error for debugging
        \Log::error('Database error fetching categories for view: ' . $e->getMessage());
    }
});

Route::get('/', function () {
    try {
        // Fetch all categories (without product counts)
        $categories = \App\Models\Category::all();
        
        // Fetch latest verified and active products with primary image
        $products = \App\Models\Product::with(['primaryImage', 'category'])
            ->where('verification_status', 'approved')
            ->where('status', 'active') // Add filter for active products
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();
    } catch (Exception $e) {
        // If there's a database issue, use empty collections
        $categories = collect();
        $products = collect();
        // Log the error for debugging
        \Log::error('Database error on homepage: ' . $e->getMessage());
    }
    
    return view('welcome', compact('categories', 'products'));
})->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', function () {
        return view('auth.passwords.email');
    })->name('password.request');
    
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    })->name('password.email');
    
    Route::get('/reset-password/{token}', function (string $token, Request $request) {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    })->name('password.reset');
    
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );
        
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Your password has been reset successfully!')
                    : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
    
    // Admin Login Route
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public Pages
Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/business', function () {
    return view('business');
})->name('business');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'showContactForm'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Help & Support Routes
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/safety-tips', function () {
    return view('safety-tips');
})->name('safety-tips');

// Sell Routes
Route::get('/sell', function () {
    return view('sell');
})->name('sell');

Route::get('/how-to-sell', function () {
    return view('how-to-sell');
})->name('how-to-sell');

Route::get('/business-accounts', function () {
    return view('business-accounts');
})->name('business-accounts');

Route::get('/advertise', function () {
    return view('advertise');
})->name('advertise');

// Public Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/browse', [PublicProductController::class, 'browse'])->name('browse');
    Route::get('/{id}', [PublicProductController::class, 'show'])->name('show');
    Route::get('/subcategories', [PublicProductController::class, 'getSubcategories'])->name('subcategories');
});

// Email Verification Routes
Route::get('/email/verify', [VerifyEmailController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Public AJAX routes
Route::get('/api/categories/{category_id}/subcategories', function ($category_id) {
    return response()->json(\App\Models\Subcategory::where('category_id', $category_id)->get());
});

// Protected Routes - Only accessible to authenticated users
Route::middleware('auth')->group(function () {
    // Favorites Routes
    Route::post('/products/{product}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('products.favorite');
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    
    // Inquiry Routes
    Route::prefix('inquiries')->name('inquiries.')->group(function () {
        Route::get('/', [InquiryController::class, 'index'])->name('index');
        Route::post('/add', [InquiryController::class, 'addToInquiry'])->name('add');
        Route::delete('/remove', [InquiryController::class, 'removeFromInquiry'])->name('remove');
    });
    
    // Chat Routes
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{slug}', [ChatController::class, 'show'])->name('show'); // Changed from {id} to {slug}
        Route::post('/conversation', [ChatController::class, 'createConversation'])->name('create-conversation');
        Route::post('/message', [ChatController::class, 'sendMessage'])->name('send-message');
        Route::get('/messages/{conversationId}', [ChatController::class, 'getMessages'])->name('get-messages');
        Route::get('/seller/{sellerId}/products', [ChatController::class, 'getSellerProducts'])->name('seller.products');
    });
    
    // Group Chat Routes
    Route::prefix('group-chat')->name('group-chat.')->group(function () {
        Route::get('/', [GroupChatController::class, 'index'])->name('index');
        Route::get('/{id}', [GroupChatController::class, 'show'])->name('show');
        Route::post('/{groupChatId}/message', [GroupChatController::class, 'sendMessage'])->name('send-message');
        Route::get('/{groupChatId}/messages', [GroupChatController::class, 'getMessages'])->name('get-messages');
    });
    
    // Pusher authentication route
    Route::post('/broadcasting/auth', [BroadcastController::class, 'authenticate']);
    
    // Buyer Routes
    Route::prefix('buyer')->name('buyer.')->middleware(['buyer', 'verified', 'buyer.approved'])->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/orders', function () {
            return 'Buyer orders page';
        })->name('orders');
        
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
        
        Route::get('/saved-products', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('saved-products');
        
        Route::get('/reviews', function () {
            return 'Buyer reviews page';
        })->name('reviews');
        
        Route::get('/settings', function () {
            return 'Buyer settings page';
        })->name('settings');
        
        Route::get('/support', function () {
            return 'Buyer support page';
        })->name('support');
        
        Route::get('/pending-approval', function () {
            return view('buyer.pending-approval');
        })->name('pending-approval');
        
        // Buyer Profile Routes
        Route::get('/profile', function () {
            return view('buyer.profile.index');
        })->name('profile.index');
        
        Route::get('/profile/personal-info', function () {
            return view('buyer.profile.personal-info');
        })->name('profile.personal-info');
        
        Route::get('/profile/business-info', function () {
            return view('buyer.profile.business-info');
        })->name('profile.business-info');
        
        Route::get('/profile/documents', function () {
            return view('buyer.profile.documents');
        })->name('profile.documents');
        
        Route::get('/profile/settings', function () {
            return view('buyer.profile.settings');
        })->name('profile.settings');
    });
    
    // Seller Routes
    Route::prefix('seller')->name('seller.')->middleware(['seller', 'verified', 'seller.verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/orders', function () {
            return 'Seller orders page';
        })->name('orders');
        
        Route::get('/orders/{id}', function ($id) {
            return "Seller order details page for order $id";
        })->name('orders.show');
        
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
        
        Route::get('/customers', function () {
            return 'Seller customers page';
        })->name('customers');
        
        // Product routes - Moved subcategories route to the top to avoid conflicts
        Route::get('/products/subcategories', [ProductController::class, 'getSubcategories'])->name('products.subcategories');
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/product-images/{id}', function ($id) {
            $image = \App\Models\ProductImage::where('id', $id)->firstOrFail();
            // Check if the image belongs to a product owned by the current seller
            if ($image->product->seller_id != auth()->id()) {
                abort(403, 'Unauthorized');
            }
            
            // Delete the file from storage
            \Storage::disk('public')->delete($image->image_path);
            
            // Delete the database record
            $image->delete();
            
            return redirect()->back()->with('success', 'Image deleted successfully.');
        })->name('product-images.destroy');
        Route::patch('/products/{id}/status', [ProductController::class, 'updateStatus'])->name('products.update-status');
        
        Route::get('/analytics', function () {
            return 'Seller analytics page';
        })->name('analytics');
        
        Route::get('/payments', function () {
            return 'Seller payments page';
        })->name('payments');
        
        Route::get('/settings', function () {
            return 'Seller settings page';
        })->name('settings');
        
        Route::get('/support', function () {
            return 'Seller support page';
        })->name('support');
        
        Route::get('/pending-verification', function () {
            return view('seller.pending-verification');
        })->name('pending-verification');
        
        // Seller Profile Routes
        Route::get('/profile', function () {
            return view('seller.profile.index');
        })->name('profile.index');
        
        Route::get('/profile/personal-info', function () {
            return view('seller.profile.personal-info');
        })->name('profile.personal-info');
        
        Route::get('/profile/business-info', function () {
            return view('seller.profile.business-info');
        })->name('profile.business-info');
        
        Route::get('/profile/documents', [ProfileController::class, 'showDocuments'])->name('profile.documents');
        Route::post('/profile/documents', [ProfileController::class, 'uploadDocument'])->name('profile.documents.upload');
        Route::delete('/profile/documents', [ProfileController::class, 'deleteDocument'])->name('profile.documents.delete');
        
        Route::get('/profile/settings', function () {
            return view('seller.profile.settings');
        })->name('profile.settings');
    });
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // User Management Routes
        Route::resource('users', UserController::class)->except(['create', 'store']);
        Route::patch('/users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
        
        // User Verification Routes
        Route::get('/verifications/users', [VerificationController::class, 'usersIndex'])->name('verifications.users.index');
        Route::get('/verifications/users/seller/{user}', [VerificationController::class, 'showSellerDetails'])->name('verifications.users.seller.show');
        Route::get('/verifications/users/buyer/{user}', [VerificationController::class, 'showBuyerDetails'])->name('verifications.users.buyer.show');
        Route::get('/verifications/users/seller/{user}/document', [VerificationController::class, 'serveSellerDocument'])->name('verifications.users.seller.document');
        Route::prefix('verifications/users')->name('verifications.users.')->group(function () {
            // Seller document verification
            Route::patch('/seller/{user}/verify', [VerificationController::class, 'verifySellerDocument'])->name('seller.verify');
            Route::patch('/seller/{user}/reject', [VerificationController::class, 'rejectSellerDocument'])->name('seller.reject');
            
            // Buyer approval
            Route::patch('/buyer/{user}/approve', [VerificationController::class, 'approveBuyer'])->name('buyer.approve');
            Route::patch('/buyer/{user}/reject', [VerificationController::class, 'rejectBuyer'])->name('buyer.reject');
        });
        
        // Product Verification Routes
        Route::get('/verifications/products', [VerificationController::class, 'productsIndex'])->name('verifications.products.index');
        Route::get('/verifications/products/{product}', [VerificationController::class, 'showProductDetails'])->name('verifications.products.show');
        Route::prefix('verifications/products')->name('verifications.products.')->group(function () {
            // Product verification
            Route::patch('/{product}/approve', [VerificationController::class, 'approveProduct'])->name('approve');
            Route::patch('/{product}/reject', [VerificationController::class, 'rejectProduct'])->name('reject');
        });
        
        // Redirect the old index route to user verification
        Route::get('/verifications', function () {
            return redirect()->route('admin.verifications.users.index');
        })->name('verifications.index');
        
        // Category Management Routes
        Route::resource('categories', CategoryController::class);
        Route::get('/categories/{category}/products', [CategoryController::class, 'showProducts'])->name('categories.products');
        
        // Subcategory Management Routes
        Route::prefix('categories/{category}')->name('categories.')->group(function () {
            Route::get('/subcategories', [CategoryController::class, 'subcategories'])->name('subcategories.index');
            Route::get('/subcategories/create', [CategoryController::class, 'createSubcategory'])->name('subcategories.create');
            Route::post('/subcategories', [CategoryController::class, 'storeSubcategory'])->name('subcategories.store');
            Route::get('/subcategories/{subcategory}/edit', [CategoryController::class, 'editSubcategory'])->name('subcategories.edit');
            Route::put('/subcategories/{subcategory}', [CategoryController::class, 'updateSubcategory'])->name('subcategories.update');
            Route::delete('/subcategories/{subcategory}', [CategoryController::class, 'destroySubcategory'])->name('subcategories.destroy');
            Route::get('/subcategories/{subcategory}/products', [CategoryController::class, 'showSubcategoryProducts'])->name('subcategories.products');
        });
        
        // Product Management Routes
        Route::resource('products', AdminProductController::class);
        Route::patch('/products/{product}/verify', [AdminProductController::class, 'verify'])->name('products.verify');
        Route::patch('/products/{product}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
        Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
        
        // Contact Messages Routes
        Route::get('/contact-messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        
        // Settings Routes
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    });
    
    // Pusher authentication route
    Route::post('/broadcasting/auth', [BroadcastController::class, 'authenticate']);
});

// Test route for file upload debugging
Route::get('/test-upload', function () {
    return view('test-upload');
})->name('test.upload.form');

Route::post('/test-upload', function (Request $request) {
    \Log::info('Test upload request received');
    \Log::info('Has file images:', ['has_files' => $request->hasFile('images')]);
    \Log::info('All files:', ['files' => $request->allFiles()]);
    
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            \Log::info("Test image $index:", [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);
        }
    }
    
    return response()->json(['status' => 'success', 'message' => 'Files received']);
})->name('test.upload');

// Test route for document serving
Route::get('/test-document/{userId}', function ($userId) {
    $user = \App\Models\User::with('profile')->findOrFail($userId);
    
    if (!$user->profile || is_null($user->profile->verification_doc)) {
        return 'No document found for this user.';
    }
    
    return 'Document path: ' . $user->profile->verification_doc;
});

// Test JavaScript functionality
Route::get('/test-js', function () {
    return view('test-js');
})->name('test.js');

// Test group chat functionality
Route::get('/test-group-chat', function () {
    // Get the first verified seller (for testing)
    $user = \App\Models\User::where('role', 'seller')->where('is_verified', true)->first();
    
    if (!$user) {
        return 'No verified seller users found';
    }
    
    // Authenticate as this user
    auth()->login($user);
    
    // Redirect to group chat index
    return redirect()->route('group-chat.index');
})->name('test.group-chat');

// Test controller functionality
Route::get('/test-controller', [App\Http\Controllers\TestController::class, 'index'])->name('test.controller');

// Simple test for GroupChatController
Route::get('/test-group-chat-simple', function () {
    return 'Group chat route is working';
});

// Direct test for GroupChatController
Route::get('/test-group-chat-controller', [GroupChatController::class, 'index']);

// Test route to send a group message
Route::get('/test-send-group-message/{groupId}', function ($groupId) {
    $user = auth()->user();
    if (!$user) {
        return 'Not authenticated';
    }
    
    $groupChat = \App\Models\GroupChat::findOrFail($groupId);
    
    // Check if user is member of group
    if (!$groupChat->users->contains($user->id)) {
        return 'User is not a member of this group chat';
    }
    
    // Create a test message
    $message = \App\Models\GroupChatMessage::create([
        'group_chat_id' => $groupChat->id,
        'sender_id' => $user->id,
        'message_type' => 'text',
        'message_text' => 'This is a test message sent at ' . now()->format('Y-m-d H:i:s'),
    ]);
    
    // Broadcast the message
    broadcast(new \App\Events\GroupMessageSent($message))->toOthers();
    
    return "Test message sent to group: {$groupChat->name}";
})->middleware('auth');

// Debug route to test group chat message sending
Route::post('/debug-group-chat-message/{groupId}', function (Request $request, $groupId) {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }
    
    try {
        $groupChat = \App\Models\GroupChat::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($groupId);
        
        $message = \App\Models\GroupChatMessage::create([
            'group_chat_id' => $groupChat->id,
            'sender_id' => $user->id,
            'message_type' => 'text',
            'message_text' => $request->message ?? 'Debug message',
        ]);
        
        $message->load('sender');
        
        broadcast(new \App\Events\GroupMessageSent($message))->toOthers();
        
        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware('auth');

// Test route to verify event broadcasting
Route::get('/test-broadcast/{groupId}', function ($groupId) {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }
    
    try {
        $groupChat = \App\Models\GroupChat::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($groupId);
        
        $message = \App\Models\GroupChatMessage::create([
            'group_chat_id' => $groupChat->id,
            'sender_id' => $user->id,
            'message_type' => 'text',
            'message_text' => 'Test broadcast message at ' . now()->format('Y-m-d H:i:s'),
        ]);
        
        $message->load('sender');
        
        // Log before broadcasting
        \Log::info('About to broadcast GroupMessageSent event', [
            'message_id' => $message->id,
            'group_chat_id' => $groupChat->id,
            'sender_id' => $user->id
        ]);
        
        // Broadcast the message
        broadcast(new \App\Events\GroupMessageSent($message))->toOthers();
        
        // Log after broadcasting
        \Log::info('GroupMessageSent event broadcast completed', [
            'message_id' => $message->id
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Event broadcasted successfully',
            'message_data' => $message
        ]);
    } catch (\Exception $e) {
        \Log::error('Error in test-broadcast route: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware('auth');