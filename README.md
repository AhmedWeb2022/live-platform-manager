# 🎥 LivePlatformManager

A Laravel package to manage live session integrations (Zoom, 100ms, LiveLink) with APIs, an admin dashboard, and reusable Blade components.

باقة Laravel لإدارة الجلسات المباشرة عبر Zoom و100ms وLiveLink من خلال API ولوحة تحكم ومكونات Blade قابلة لإعادة الاستخدام.

---

## 🚀 Features | 🎯 الميزات

- ✅ Support for multiple live platforms: Zoom, 100ms, LiveLink  
  ✅ دعم منصات متعددة للبث المباشر مثل Zoom و100ms وLiveLink
- 🧩 Interface-based service design (extensible)  
  🧩 تصميم قائم على الواجهات لتسهيل التوسع
- 📊 Admin dashboard for managing platforms, accounts, and sessions  
  📊 لوحة تحكم لإدارة المنصات والحسابات والجلسات
- 🛠️ APIs to create, delete, end sessions & generate signatures  
  🛠️ واجهات برمجية (APIs) لإنشاء، حذف، وإنهاء الاجتماعات وتوليد التواقيع
- 🌐 Multi-language-ready (Arabic + English)  
  🌐 دعم متعدد اللغات (العربية + الإنجليزية)
- 🔧 Easy configuration via `.env` & `services.php`  
  🔧 إعداد سهل من خلال ملفات البيئة والتكوين
- 🧩 Reusable Blade components  
  🧩 مكونات Blade قابلة لإعادة الاستخدام

---

## 📦 Installation | التثبيت

```bash
composer require waheed43/live-platform-manager
```

### 🔧 Publish Assets | نشر الملفات

```bash
php artisan vendor:publish --tag=liveplatform-views
php artisan vendor:publish --tag=liveplatform-assets
```

---

## ⚙️ Environment Variables | متغيرات البيئة

Add the following to your `.env`:  
أضف التالي إلى ملف `.env`:

```env
# Zoom
ZOOM_TOKEN_URL=https://zoom.us/oauth/token
ZOOM_CREATE_MEETING_URL=https://api.zoom.us/v2/users/me/meetings
ZOOM_DELETE_MEETING_URL=https://api.zoom.us/v2/meetings
ZOOM_UPDATE_MEETING_URL=https://api.zoom.us/v2/meetings

# 100ms
100MS_BASE_URL=https://api.100ms.live/v2/
100MS_CREATE_MEETING_URL=https://api.100ms.live/v2/rooms
100MS_CREATE_CODE_URL=https://api.100ms.live/v2/room-codes/room/
```

---

## 🛠️ Update `config/services.php`

```php
'zoom' => [
    'TOKEN_URL' => env('ZOOM_TOKEN_URL'),
    'CREATE_MEETING_URL' => env('ZOOM_CREATE_MEETING_URL'),
    'DELETE_MEETING_URL' => env('ZOOM_DELETE_MEETING_URL'),
    'UPDATE_MEETING_URL' => env('ZOOM_UPDATE_MEETING_URL') . '/{{ meetingId }}/status',
    'DATA' => [
        'grant_type' => 'account_credentials',
        'account_id' => '{{account_id}}',
    ],
    'HEADERS' => [
        'Authorization' => 'Basic {{credentials}}',
        'Content-Type' => 'application/json',
    ],
],

'100ms' => [
    'BASE_URL' => env('100MS_BASE_URL'),
    'CREATE_MEETING_URL' => env('100MS_CREATE_MEETING_URL'),
    'CREATE_CODE_URL' => env('100MS_CREATE_CODE_URL'),
    'HEADERS' => [
        'Authorization' => 'Bearer {{token}}',
        'Content-Type' => 'application/json',
    ],
],
```

---

## 🧪 API Routes | مسارات API

```php
Route::controller(LiveIntegerationController::class)->group(function () {
    Route::post('fetch_live_accounts', 'fetch_live_accounts');
    Route::post('fetch-live', 'fetch_live');
    Route::post('fetch-live-dev', 'fetch_live_dev');
    Route::post('create-live', 'create_live');
    Route::post('delete_live', 'delete_live');
    Route::post('fetch_zoom_config', 'fetch_zoom_config');
    Route::post('end_meeting', 'end_meeting');
});
```

---

## 🖥️ Admin Dashboard Routes | مسارات لوحة التحكم

```php
Route::prefix('live-admin')->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware('auth:web')->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');

        Route::resource('platform', PlatformController::class)->names('admin.platform');
        Route::resource('live_account', LiveAccountController::class)->names('admin.live_account');
        Route::resource('session', SessionController::class)->names('admin.session');
    });
});
```

---

## 🧩 Blade Component | مكون Blade

Example usage:  
استخدام المكون:

```blade
<x-liveplatform::join-button :session="$session" />
```

---

## 🧠 Usage in Code | الاستخدام في الكود

```php
use AhmedWeb\LivePlatformManager\Services\Zoom\ZoomService;

$zoom = new ZoomService($liveAccount);
$meeting = $zoom->createMeeting([...]);

$zoom->endMeeting($meetingId);
$zoom->deleteMeeting($meetingId);
$signature = $zoom->generateSignature();
```

---

## 🤝 Contributing | المساهمة

1. Fork the repository  
2. Create a new feature branch  
3. Commit and push your changes  
4. Open a Pull Request  

---

## 📄 License | الرخصة

MIT © [Your Name]

---

````

Let me know if you’d like to include badges, links to documentation, or examples for 100ms or LiveLink too.
