# LivePlatformManager

**LivePlatformManager** is a Laravel package that provides a unified interface to create, manage, and join live sessions across various platforms like Zoom, 100ms, and more.

## 📦 Installation

```bash
composer require ahmedweb/live-platform-manager
````

## ⚙️ Publish Configs (Optional)

```bash
php artisan vendor:publish --provider="ahmedWeb\LivePlatformManager\LivePlatformManagerServiceProvider"
```

---

## 🧾 API Endpoints

### 1. Create Live Session

**POST** `/create-live`

#### Request Example

```json
{
  "platform_code": "zoom",
  "live_account_id": 1,
  "platform_type": 1,
  "platform_session": {
    "id": 1,
    "name": "Math Class",
    "description": "Algebra Lesson",
    "start_time": "09:00",
    "end_time": "10:00",
    "start_date": "2025-06-11",
    "end_date": "2025-06-11",
    "duration": 60,
    "platform_session_related_data": "{}"
  }
}
```

---
### 2. Fetch Live Info

**POST** `/fetch-live`

#### Request Example

```json
{
  "platform_code": "zoom",
  "session_id": 1,
  "platform_type": 1
}
```

---

### 3. Delete Live

**DELETE** `/delete_live`

#### Request Example

```json
{
  "platform_code": "zoom",
  "live_account_id": 1,
  "platform_type": 1,
  "session_id": 1
}
```

---

### 4. Fetch Zoom Config

**POST** `/fetch_zoom_config`

#### Request Example

```json
{
  "platform_code": "zoom",
  "live_account_id": 1,
  "role": 1,
  "user": {
    "id": 2,
    "name": "Ahmed"
  },
  "session_id": 1
}
```

---

## 📊 Dashboard Endpoints

### Auth

#### Login

**POST** `/live-admin/login`

#### Request Example

```json
{
  "email": "admin@example.com",
  "password": "secret"
}
```

---

### Platform Management

#### Store Platform

**POST** `/live-admin/platform/store`

#### Request Example

```json
{
  "name": "Zoom",
  "url": "https://zoom.us",
  "code": "zoom"
}
```

#### Update Platform

**PUT** `/live-admin/platform/update/{platform}`

#### Request Example

```json
{
  "name": "Zoom",
  "url": "https://zoom.us",
  "code": "zoom"
}
```

---

### Live Account Management

#### Store Live Account

**POST** `live-admin/live-account/store`

#### Request Example

```json
{
  "integeration_type": 1,
  "name": "Zoom Account",
  "client_id": "your-client-id",
  "client_secret": "your-client-secret",
  "account_id": "your-account-id",
  "sdk_key": "your-sdk-key",
  "sdk_secret": "your-sdk-secret",
  "join_url": "https://zoom.us/j/..."
}
```

#### Update Live Account

**PUT** `/live-admin/live-account/update/{liveAccount}`

#### Request Example

```json
{
  "name": "Zoom Account",
  "client_id": "your-client-id",
  "client_secret": "your-client-secret",
  "account_id": "your-account-id",
  "sdk_key": "your-sdk-key",
  "sdk_secret": "your-sdk-secret",
  "integeration_type": 1
}
```

---

## 🧾 Resources Returned

### LiveResource

```json
{
  "id": 1,
  "zoom_id": "123456789",
  "password": "abc123",
  "join_url": "https://zoom.us/j/123456789"
}
```

*For 100ms:*

```json
{
  "id": 1,
  "room_id": "room123",
  "host_code": "host-code",
  "guest_code": "guest-code",
  "join_url": "https://100ms.live/session"
}
```

---

### LiveAccountResource

```json
{
  "id": 1,
  "platform_id": 2,
  "platform_type": 1,
  "name": "Zoom Account",
  "type": 1
}
```

---

### SessionResource

```json
{
  "id": 5,
  "live_account_id": 1,
  "session_id": 10
}
```

---

## 📌 Supported Platforms

* ✅ Zoom
* ✅ 100ms
* 🚧 LiveLink (In progress)

---

## 🧠 Notes

* Use the correct `platform_type` enum values as defined in `PlatformTypeEnum`:

  * `1` => Zoom
  * `2` => 100ms
* All session actions should follow the standard Laravel request/validation flow.

---

## 🧪 Testing

To run tests:

```bash
php artisan test
```

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss.

---

## 📄 License

[MIT License](LICENSE)

```

Let me know if you want a version of this in **Arabic**, **GitHub Actions CI**, or **auto-published docs via Laravel Swagger**.
```
